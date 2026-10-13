<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransaksiSetoran extends Model
{
    use HasFactory;

    protected $table = 'transaksi_setoran';

    protected $fillable = [
        'nasabah_id',
        'petugas_id',
        'tanggal_setoran',
        'total_nilai',
    ];

    protected $casts = [
        'tanggal_setoran' => 'datetime',
        'total_nilai' => 'decimal:2',
    ];

    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(Nasabah::class);
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function detailSetoran(): HasMany
    {
        return $this->hasMany(DetailSetoran::class, 'transaksi_id');
    }
}
