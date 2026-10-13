<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class NasabahController extends Controller
{
    public function index() { $nasabah = Nasabah::with('user')->latest()->paginate(15); return view('admin.nasabah.index', compact('nasabah')); }
    public function create() { return view('admin.nasabah.create'); }
    public function store(Request $request)
    {
        $data = $request->validate(['nama_siswa'=>'required|string|max:255','kelas'=>'required|string|max:50','email'=>'required|email|unique:users,email','password'=>'required|string|min:8']);
        DB::transaction(function () use ($data) {
            $user = User::create(['name'=>$data['nama_siswa'],'email'=>$data['email'],'password'=>Hash::make($data['password']),'role'=>'siswa']);
            Nasabah::create(['user_id'=>$user->id,'nama_siswa'=>$data['nama_siswa'],'kelas'=>$data['kelas']]);
        });
        return redirect()->route('admin.nasabah.index')->with('success','Nasabah berhasil ditambahkan.');
    }
    public function show(Nasabah $nasabah) { $nasabah->load('user','tabungan','transaksiSetoran'); return view('admin.nasabah.show', compact('nasabah')); }
    public function edit(Nasabah $nasabah) { $nasabah->load('user'); return view('admin.nasabah.edit', compact('nasabah')); }
    public function update(Request $request, Nasabah $nasabah)
    {
        $data = $request->validate(['nama_siswa'=>'required|string|max:255','kelas'=>'required|string|max:50','email'=>'required|email|unique:users,email,'.$nasabah->user_id]);
        DB::transaction(function () use ($data,$nasabah) { $nasabah->update(['nama_siswa'=>$data['nama_siswa'],'kelas'=>$data['kelas']]); $nasabah->user()->update(['name'=>$data['nama_siswa'],'email'=>$data['email']]); });
        return redirect()->route('admin.nasabah.index')->with('success','Data nasabah diperbarui.');
    }
    public function destroy(Nasabah $nasabah) { if ($nasabah->transaksiSetoran()->exists()) return back()->withErrors('Nasabah memiliki transaksi sehingga tidak dapat dihapus.'); if ($nasabah->tabungan()->exists()) return back()->withErrors('Nasabah memiliki data tabungan sehingga tidak dapat dihapus.'); DB::transaction(function () use ($nasabah) { $user=$nasabah->user; $nasabah->delete(); if ($user) $user->delete(); }); return redirect()->route('admin.nasabah.index')->with('success','Nasabah dihapus.'); }
}
