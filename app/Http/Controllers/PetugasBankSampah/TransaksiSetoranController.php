<?php

namespace App\Http\Controllers\PetugasBankSampah;

use App\Http\Controllers\Controller;
use App\Models\DetailSetoran;
use App\Models\KategoriSampah;
use App\Models\Nasabah;
use App\Models\Tabungan;
use App\Models\TransaksiSetoran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TransaksiSetoranController extends Controller
{
    public function create(): View
    {
        return view('petugas-bank-sampah.setoran.create', [
            'nasabah' => Nasabah::orderBy('nama_siswa')->get(['id', 'nama_siswa', 'kelas']),
            'kategoriSampah' => KategoriSampah::orderBy('nama_sampah')->get(['id', 'nama_sampah', 'harga_per_kg']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nasabah_id' => ['required', 'integer', Rule::exists('nasabah', 'id')],
            'details' => ['required', 'array', 'min:1'],
            'details.*.kategori_sampah_id' => ['required', 'integer', Rule::exists('kategori_sampah', 'id')],
            'details.*.berat_kg' => ['required', 'numeric', 'gt:0', 'decimal:0,3', 'max:9999999.999'],
        ]);

        $categories = KategoriSampah::query()
            ->whereIn('id', collect($data['details'])->pluck('kategori_sampah_id')->unique())
            ->get()
            ->keyBy('id');

        $details = [];
        $total = 0;

        foreach ($data['details'] as $item) {
            $category = $categories->get((int) $item['kategori_sampah_id']);
            $weight = (float) $item['berat_kg'];
            $price = (float) $category->harga_per_kg;
            $subtotal = round($weight * $price, 2);
            $total += $subtotal;

            $details[] = [
                'kategori_sampah_id' => $category->id,
                'berat_kg' => $weight,
                'harga_per_kg' => $price,
                'subtotal' => $subtotal,
            ];
        }

        $transaction = DB::transaction(function () use ($request, $data, $details, $total) {
            $transaction = TransaksiSetoran::create([
                'nasabah_id' => $data['nasabah_id'],
                'petugas_id' => $request->user()->id,
                'tanggal_setoran' => now(),
                'total_nilai' => $total,
            ]);

            foreach ($details as $detail) {
                $transaction->detailSetoran()->create($detail);
            }

            $savings = Tabungan::firstOrCreate(
                ['nasabah_id' => $data['nasabah_id']],
                ['saldo' => 0]
            );
            $savings = Tabungan::query()->whereKey($savings->getKey())->lockForUpdate()->firstOrFail();
            $savings->increment('saldo', $total);

            return $transaction;
        });

        return redirect()
            ->route('petugas.transaksi.show', $transaction)
            ->with('success', 'Setoran berhasil dicatat dan saldo nasabah diperbarui.');
    }
}
