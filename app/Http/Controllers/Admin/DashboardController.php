<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailSetoran;
use App\Models\KategoriSampah;
use App\Models\Nasabah;
use App\Models\Tabungan;
use App\Models\TransaksiSetoran;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'jumlahNasabah' => Nasabah::count(),
            'jumlahKategori' => KategoriSampah::count(),
            'jumlahTransaksi' => TransaksiSetoran::count(),
            'totalNilai' => TransaksiSetoran::sum('total_nilai'),
            'totalSaldo' => Tabungan::sum('saldo'),
            'totalBerat' => DetailSetoran::sum('berat_kg'),
            'transaksiTerbaru' => TransaksiSetoran::with(['nasabah', 'petugas'])
                ->latest('tanggal_setoran')
                ->limit(6)
                ->get(),
            'nasabahTerbaru' => Nasabah::with('user')
                ->latest()
                ->limit(5)
                ->get(),
        ]);
    }
}