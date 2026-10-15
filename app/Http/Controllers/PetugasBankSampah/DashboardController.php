<?php

namespace App\Http\Controllers\PetugasBankSampah;

use App\Http\Controllers\Controller;
use App\Models\DetailSetoran;
use App\Models\Nasabah;
use App\Models\Tabungan;
use App\Models\TransaksiSetoran;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('petugas-bank-sampah.dashboard', [
            'jumlahNasabah' => Nasabah::count(),
            'jumlahTransaksi' => TransaksiSetoran::count(),
            'totalBerat' => DetailSetoran::sum('berat_kg'),
            'totalSaldo' => Tabungan::sum('saldo'),
            'transaksiTerbaru' => TransaksiSetoran::with(['nasabah', 'petugas'])
                ->latest('tanggal_setoran')
                ->limit(10)
                ->get(),
        ]);
    }
}
