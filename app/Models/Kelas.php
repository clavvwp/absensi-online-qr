<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use Illuminate\Database\Eloquent\Relations\HasMany; 

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'nama',
        'jurusan',
        'user_id',
    ];

    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }
}
