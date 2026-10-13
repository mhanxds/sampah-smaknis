<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tabungan;

class TabunganController extends Controller
{
    public function index() { $tabungan = Tabungan::with('nasabah')->orderByDesc('saldo')->paginate(20); return view('admin.tabungan.index', compact('tabungan')); }
    public function show(Tabungan $tabungan) { $tabungan->load('nasabah.transaksiSetoran'); return view('admin.tabungan.show', compact('tabungan')); }
}
