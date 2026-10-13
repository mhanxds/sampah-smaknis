<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriSampah;
use Illuminate\Http\Request;

class KategoriSampahController extends Controller
{
    public function index() { $kategoriSampah = KategoriSampah::latest()->paginate(15); return view('admin.kategori-sampah.index', compact('kategoriSampah')); }
    public function create() { return view('admin.kategori-sampah.create'); }
    public function store(Request $request) { $data=$request->validate(['nama_sampah'=>'required|string|max:100|unique:kategori_sampah,nama_sampah','harga_per_kg'=>'required|numeric|min:0']); KategoriSampah::create($data); return redirect()->route('admin.kategori-sampah.index')->with('success','Kategori ditambahkan.'); }
    public function show(KategoriSampah $kategoriSampah) { return view('admin.kategori-sampah.show', compact('kategoriSampah')); }
    public function edit(KategoriSampah $kategoriSampah) { return view('admin.kategori-sampah.edit', compact('kategoriSampah')); }
    public function update(Request $request, KategoriSampah $kategoriSampah) { $data=$request->validate(['nama_sampah'=>'required|string|max:100|unique:kategori_sampah,nama_sampah,'.$kategoriSampah->id,'harga_per_kg'=>'required|numeric|min:0']); $kategoriSampah->update($data); return redirect()->route('admin.kategori-sampah.index')->with('success','Kategori diperbarui.'); }
    public function destroy(KategoriSampah $kategoriSampah) { if ($kategoriSampah->detailSetoran()->exists()) return back()->withErrors('Kategori sudah digunakan dalam transaksi.'); $kategoriSampah->delete(); return redirect()->route('admin.kategori-sampah.index')->with('success','Kategori dihapus.'); }
}
