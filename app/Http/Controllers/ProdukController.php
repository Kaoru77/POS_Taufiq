<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produk\StoreRequest;
use App\Http\Requests\Produk\UpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request) // Menggunakan Request agar bisa baca query string 'kategori' & 'search'
    {
        $this->authorize('viewAny', Produk::class);
        
        $keyword = $request->input('search');
        $kategori = $request->input('kategori');

        // Buat query dasar
        $query = Produk::query();

        // Filter berdasarkan pencarian nama produk
        if ($keyword) {
            $query->where('nama', 'like', '%' . $keyword . '%');
        }

        // Filter berdasarkan jenis / kategori produk
        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        // Eksekusi data dengan urutan terbaru & pagination
        $products = $query->latest()->paginate(10)->withQueryString();

        return view('produk.index', compact('products'));
    }

    public function create()
    {
        $this->authorize('create', Produk::class);

        return view('produk.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Produk::class);

        $dataReq = $request->validated();

        $data['user_id']    = Auth::id();
        $data['nama']       = $dataReq['name'];
        $data['kategori']   = $dataReq['kategori']; // <--- MENAMBAHKAN KATEGORI
        $data['harga_beli'] = $dataReq['purchase_price'];
        $data['harga_jual'] = $dataReq['selling_price'];
        $data['stok']       = $dataReq['stock'] ?? true;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Product created successfully.');
    }

    public function edit(Produk $produk)
    {
        $this->authorize('update', $produk);
        return view('produk.edit', compact('produk'));
    }

    public function update(UpdateRequest $request, Produk $produk)
    {
        $this->authorize('update', $produk);
        $dataReq = $request->validated();

        $data = [
            'user_id'    => Auth::id(),
            'nama'       => $dataReq['name'],
            'kategori'   => $dataReq['kategori'], // <--- MENAMBAHKAN KATEGORI
            'harga_beli' => $dataReq['purchase_price'],
            'harga_jual' => $dataReq['selling_price'],
            'stok'       => $dataReq['stock'],
        ];

        if ($request->hasFile('foto')) {
            if ($produk->foto) {
                Storage::disk('public')->delete($produk->foto);
            }

            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        $produk->update($data);

        return redirect()->route('produk.edit', $produk->id)
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Produk $produk)
    {
        $this->authorize('delete', $produk);
        if ($produk->foto) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->route('produk.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function show(Produk $produk)
    {
        // Otorisasi menggunakan ProdukPolicy method view
        $this->authorize('view', $produk);

        return view('produk.show', compact('produk'));
    }
}