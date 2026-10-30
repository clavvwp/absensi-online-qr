<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class Qr extends Model
{
    protected $table = 'qr';

    protected $fillable = [
        'siswa_id',
        'qr_token',
        'status',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }
}
