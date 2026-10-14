<?php

namespace App\Http\Controllers\PetugasBankSampah;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NasabahController extends Controller
{
    public function index(Request $request): View
    {
        $query = Nasabah::query()->with(['user', 'tabungan']);

        if ($search = $request->string('q')->trim()->toString()) {
            $query->where(function ($query) use ($search) {
                $query->where('nama_siswa', 'like', "%{$search}%")
                    ->orWhere('kelas', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($userQuery) => $userQuery->where('email', 'like', "%{$search}%"));
            });
        }

        return view('petugas-bank-sampah.nasabah.index', [
            'nasabah' => $query->latest()->paginate(20)->withQueryString(),
        ]);
    }

    public function show(Nasabah $nasabah): View
    {
        $nasabah->load(['user', 'tabungan', 'transaksiSetoran.petugas']);

        return view('petugas-bank-sampah.nasabah.show', compact('nasabah'));
    }
}
