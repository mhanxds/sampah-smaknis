<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiSetoran;
use Illuminate\Http\Request;

class TransaksiSetoranController extends Controller
{
    public function index() { $transaksi = TransaksiSetoran::with('nasabah','petugas','detailSetoran.kategoriSampah')->latest('tanggal_setoran')->paginate(20); return view('admin.transaksi.index', compact('transaksi')); }
    public function show(TransaksiSetoran $transaksiSetoran) { $transaksiSetoran->load('nasabah','petugas','detailSetoran.kategoriSampah'); return view('admin.transaksi.show', ['transaksi'=>$transaksiSetoran]); }
}
