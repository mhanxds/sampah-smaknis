<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriSampah extends Model
{
    use HasFactory;

    protected $table = 'kategori_sampah';

    protected $fillable = [
        'nama_sampah',
        'harga_per_kg',
    ];

    protected $casts = [
        'harga_per_kg' => 'decimal:2',
    ];

    public function detailSetoran(): HasMany
    {
        return $this->hasMany(DetailSetoran::class);
    }
}
