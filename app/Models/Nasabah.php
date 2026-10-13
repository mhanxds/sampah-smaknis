<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Nasabah extends Model
{
    use HasFactory;

    protected $table = 'nasabah';

    protected $fillable = [
        'user_id',
        'nama_siswa',
        'kelas',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaksiSetoran(): HasMany
    {
        return $this->hasMany(TransaksiSetoran::class);
    }

    public function tabungan(): HasOne
    {
        return $this->hasOne(Tabungan::class);
    }
}