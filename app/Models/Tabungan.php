<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tabungan extends Model
{
    use HasFactory;

    protected $table = 'tabungan';

    protected $fillable = [
        'nasabah_id',
        'saldo',
    ];

    protected $casts = [
        'saldo' => 'decimal:2',
    ];

    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(Nasabah::class);
    }
}
