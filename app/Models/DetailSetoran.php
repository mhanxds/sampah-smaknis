<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailSetoran extends Model
{
    use HasFactory;

    protected $table = 'detail_setoran';

    protected $fillable = [
        'transaksi_id',
        'kategori_sampah_id',
        'berat_kg',
        'harga_per_kg',
        'subtotal',
    ];

    protected $casts = [
        'berat_kg' => 'decimal:3',
        'harga_per_kg' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(TransaksiSetoran::class, 'transaksi_id');
    }

    public function kategoriSampah(): BelongsTo
    {
        return $this->belongsTo(KategoriSampah::class);
    }
}
