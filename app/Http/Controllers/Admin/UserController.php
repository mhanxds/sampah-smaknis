<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() { $users=User::latest()->paginate(20); return view('admin.users.index',compact('users')); }
    public function create() { return view('admin.users.create'); }
    public function store(Request $request) { $data=$request->validate(['name'=>'required|string|max:255','email'=>'required|email|unique:users,email','password'=>'required|string|min:8','role'=>'required|in:admin_bank,petugas_sarpras,petugas_timbangan,siswa']); User::create($data); return redirect()->route('admin.users.index')->with('success','Akun dibuat.'); }
    public function edit(User $user) { return view('admin.users.edit',compact('user')); }
    public function update(Request $request, User $user) { $data=$request->validate(['name'=>'required|string|max:255','email'=>'required|email|unique:users,email,'.$user->getKey(),'role'=>'required|in:admin_bank,petugas_sarpras,petugas_timbangan,siswa','password'=>'nullable|string|min:8']); if(!empty($data['password']))$data['password']=Hash::make($data['password']);else unset($data['password']); if($user->getKey()===Auth::id() && !in_array($data['role'], ['admin', 'admin_bank'], true)) return back()->withErrors('Role akun admin yang sedang digunakan tidak dapat diturunkan.'); $user->update($data); return redirect()->route('admin.users.index')->with('success','Akun diperbarui.'); }
    public function destroy(User $user) { if($user->getKey()===Auth::id())return back()->withErrors('Tidak dapat menghapus akun yang sedang digunakan.'); if($user->nasabah()->exists())return back()->withErrors('Akun masih terhubung dengan data nasabah.'); if($user->transaksiSetoranPetugas()->exists())return back()->withErrors('Akun masih tercatat sebagai petugas transaksi.'); $user->delete(); return redirect()->route('admin.users.index')->with('success','Akun dihapus.'); }
}
