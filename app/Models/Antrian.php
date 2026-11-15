<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Antrian extends Model
{
    protected $fillable = [
        'kendaraan_id',
        'nomor_antrian',
        'tanggal',
        'waktu',
        'status_antrian',
    ];

    /**
     * Relasi Inverse One-to-Many: Setiap data antrian merujuk pada satu Kendaraan.
     */
    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class);
    }
}