<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = Kategori::withCount('produk')
            ->when($request->search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%");
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        $this->authorize('create', Kategori::class);
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Kategori::class);

        $request->validate([
            'nama' => 'required|string|max:255|unique:kategoris,nama',
        ]);

        Kategori::create($request->only('nama'));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        $this->authorize('update', $kategori);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $this->authorize('update', $kategori);

        $request->validate([
            'nama' => 'required|string|max:255|unique:kategoris,nama,' . $kategori->id,
        ]);

        $kategori->update($request->only('nama'));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        $this->authorize('delete', $kategori);

        if ($kategori->produk()->exists()) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih dipakai oleh produk.');
        }

        $kategori->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}