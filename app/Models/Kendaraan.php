<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kendaraan extends Model
{
    // Kolom yang diizinkan untuk diisi secara massal (mass assignment)
    protected $fillable = [
        'user_id',
        'nomor_polisi',
        'jenis_kendaraan',
        'nama_pemilik',
    ];

    /**
     * Relasi Inverse One-to-Many: Setiap kendaraan terhubung ke satu User penginput.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi One-to-Many: Satu kendaraan dapat memiliki banyak riwayat antrian.
     */
    public function antrians(): HasMany
    {
        return $this->hasMany(Antrian::class);
    }
}