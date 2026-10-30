<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use Illuminate\Database\Eloquent\Relations\HasOne; 
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama',
        'kelas_id',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function qr(): HasOne
    {
        return $this->hasOne(Qr::class);
    }

    public function presensi(): HasMany
    {
        return $this->hasMany(Presensi::class);
    }
}
