<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; 
use App\Models\Kelas; 
use App\Models\Siswa; 
use App\Models\Qr; 

class DatabaseSeeder extends Seeder
{
    public function run(): void
{
    User::create([
        'nama' => 'Administrator',
        'email' => 'admin@absensi.com',
        'password' => 'admin123',
        'role' => 'admin',
    ]);

    $wali1 = User::create([
        'nama' => 'Budi Santoso',
        'email' => 'budi@absensi.com',
        'password' => 'budi01',
        'role' => 'wali_kelas',
    ]);

    $kelas1 = Kelas::create([
        'nama' => 'XII RPL 1',
        'jurusan' => 'RPL',
        'user_id' => $wali1->id,
    ]);

    foreach ([
        ['2024001', 'Ahmad Fauzi'],
        ['2024002', 'Dewi Lestari'],
    ] as $s) {
        $siswa = Siswa::create([
            'nis' => $s[0],
            'nama' => $s[1],
            'kelas_id' => $kelas1->id,
        ]);

        Qr::create([
            'siswa_id' => $siswa->id,
            'qr_token' => $siswa->nis,
            'status' => 'aktif',
        ]);
    }
}
}
