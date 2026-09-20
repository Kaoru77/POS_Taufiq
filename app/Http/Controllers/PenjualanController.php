<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $user = Auth::user();
        $keyword = $request->input('search');

        $sales = Penjualan::query()

            // 🔒 Filter berdasarkan role
            ->when($user->role->name === 'kasir', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })

            // 🔍 Search nama user
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('penjualan.index', compact('sales'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(SearchRequest $request)
    {
        $sale = Penjualan::where('user_id', Auth::id())
            ->where('status', 'OPEN')
            ->whereNull('status_pembayaran')
            ->first();

        if (!$sale) {
            $sale = Penjualan::create([
                'user_id' => Auth::id(),
                'status' => 'OPEN',
                'status_pembayaran' => null,
                'total_pembayaran' => 0,
                'metode_pembayaran' => 'CASH',
            ]);
        }

        $keyword = $request->input('search');

        if ($keyword) {
            $products = Produk::when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', '%' . $keyword . '%');
            })
                ->orderBy('nama')
                ->get();
        } else {
            $products = Produk::orderBy('nama')->get();
        }
        $mode = 'create';

        return view('penjualan.pos', compact('sale', 'products', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $this->authorize('view', $penjualan);

        $penjualan->load(['user', 'itemPenjualan.produk']);

        return view('penjualan.show', compact('penjualan'));
    }

    public function receipt(Penjualan $penjualan)
    {
        $this->authorize('view', $penjualan);

        $penjualan->load(['user', 'itemPenjualan.produk']);

        return view('penjualan.receipt', compact('penjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan)
    {
        $sale = $penjualan;

        $this->authorize('update', $sale);

        abort_if($sale->status === 'COMPLETED', 403);

        $sale->load('itemPenjualan');
        $products = Produk::orderBy('nama')->get();
        $mode = 'edit';

        return view('penjualan.pos', compact('sale', 'products', 'mode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {

        $this->authorize('update', $penjualan);

        $request->validate([
            'payment_method' => 'required|in:CASH,QRIS,TRANSFER',
            'uang_diterima'  => 'required_if:payment_method,CASH|nullable|integer|min:0',
        ]);

        if ($penjualan->status !== 'OPEN') {
            return back()->with('error', 'Transaksi sudah diproses');
        }

        if ($penjualan->itemPenjualan()->count() === 0) {
            return back()->with('error', 'Keranjang masih kosong');
        }
        $total = $penjualan->itemPenjualan()->sum('subtotal');

        if ($request->payment_method === 'CASH' && $request->uang_diterima < $total) {
            return back()->with('error', 'Uang diterima kurang dari total pembayaran');
        }

        if ($request->payment_method === 'CASH') {
            DB::transaction(function () use ($penjualan, $request, $total) {
                $penjualan->update([
                    'metode_pembayaran' => 'CASH',
                    'uang_diterima'     => $request->uang_diterima,
                    'total_pembayaran'  => $total,
                    'status_pembayaran' => null,
                    'status'            => 'COMPLETED',
                ]);
            });

            return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil diselesaikan');
        }

        // QRIS / TRANSFER: tahan dulu, tunggu konfirmasi manual dari kasir
        $penjualan->update([
            'metode_pembayaran' => $request->payment_method,
            'uang_diterima'     => null,
            'total_pembayaran'  => $total,
            'status_pembayaran' => 'MENUNGGU',
        ]);

        return redirect()->route('penjualan.edit', $penjualan)
            ->with('success', 'Menunggu konfirmasi pembayaran ' . $request->payment_method . '.');
    }
    public function konfirmasiPembayaran(Penjualan $penjualan)
    {
        $this->authorize('update', $penjualan);

        if ($penjualan->status_pembayaran !== 'MENUNGGU') {
            return back()->with('error', 'Tidak ada pembayaran yang menunggu konfirmasi.');
        }

        DB::transaction(function () use ($penjualan) {
            $total = $penjualan->itemPenjualan()->sum('subtotal');
            $penjualan->update([
                'total_pembayaran'  => $total,
                'status_pembayaran' => 'DITERIMA',
                'status'            => 'COMPLETED',
            ]);
        });

        return redirect()->route('penjualan.index')->with('success', 'Pembayaran dikonfirmasi, transaksi selesai.');
    }

    public function batalKonfirmasi(Penjualan $penjualan)
    {
        $this->authorize('update', $penjualan);

        if ($penjualan->status_pembayaran !== 'MENUNGGU') {
            return back()->with('error', 'Tidak ada pembayaran yang bisa dibatalkan.');
        }

        $penjualan->update([
            'status_pembayaran' => null,
        ]);

        return redirect()->route('penjualan.edit', $penjualan)
            ->with('success', 'Pemilihan metode pembayaran dibatalkan, silakan pilih ulang.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        $this->authorize('delete', $penjualan);
        // ! Pastikan hanya transaksi OPEN
        if ($penjualan->status !== 'OPEN') {
            return redirect()->route('penjualan.index')->with('error', 'Transaksi sudah selesai tidak bisa dibatalkan');
        }

        DB::transaction(function () use ($penjualan) {

            foreach ($penjualan->itemPenjualan as $item) {
                // 🔼 kembalikan stok
                $item->produk->increment('stok', $item->kuantitas);
            }

            // ❌ hapus item
            $penjualan->itemPenjualan()->delete();

            // ❌ hapus penjualan
            $penjualan->delete();
        });

        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Transaksi berhasil dibatalkan');
    }
}
