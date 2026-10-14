<?php

namespace App\Http\Controllers\PetugasBankSampah;

use App\Http\Controllers\Controller;
use App\Models\TransaksiSetoran;
use Illuminate\View\View;

class TransaksiController extends Controller
{
    public function index(): View
    {
        return view('petugas-bank-sampah.transaksi.index', [
            'transaksi' => TransaksiSetoran::with(['nasabah', 'petugas'])
                ->latest('tanggal_setoran')
                ->paginate(20),
        ]);
    }

    public function show(TransaksiSetoran $transaksi): View
    {
        $transaksi->load(['nasabah', 'petugas', 'detailSetoran.kategoriSampah']);

        return view('petugas-bank-sampah.transaksi.show', compact('transaksi'));
    }
}
