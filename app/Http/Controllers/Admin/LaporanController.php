<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiSetoran;
use App\Models\DetailSetoran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['mulai'=>'nullable|date','sampai'=>'nullable|date|after_or_equal:mulai']);
        $query=TransaksiSetoran::query()->with('nasabah','petugas','detailSetoran.kategoriSampah');
        if ($request->filled('mulai')) $query->whereDate('tanggal_setoran','>=',$request->mulai);
        if ($request->filled('sampai')) $query->whereDate('tanggal_setoran','<=',$request->sampai);
        $transaksi=$query->orderBy('tanggal_setoran')->paginate(30)->withQueryString();
        $ringkasan=(clone $query)->reorder()->selectRaw('COUNT(*) as jumlah_transaksi, COALESCE(SUM(total_nilai),0) as total_nilai')->first();
        $totalBerat=DetailSetoran::whereHas('transaksi',function($q) use ($request){ if($request->filled('mulai'))$q->whereDate('tanggal_setoran','>=',$request->mulai); if($request->filled('sampai'))$q->whereDate('tanggal_setoran','<=',$request->sampai); })->sum('berat_kg');
        return view('admin.laporan.index', compact('transaksi','ringkasan','totalBerat'));
    }
}
