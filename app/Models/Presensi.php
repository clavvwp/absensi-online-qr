<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class Presensi extends Model
{
    protected $table = 'presensi';

    protected $fillable = [
        'siswa_id',
        'status',
        'tanggal',
        'scanned_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'scanned_at' => 'datetime',
        ];
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}
