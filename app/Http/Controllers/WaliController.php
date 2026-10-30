<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Siswa; 
use App\Models\Presensi;

class WaliController extends Controller
{
    public function dashboard(Request $request)
{
    $kelas = Auth::user()->kelas;
    $tanggal = $request->tanggal ?? today()->toDateString();

    if (!$kelas) {
        return view('wali.dashboard', [
            'kelas' => null,
            'siswa' => collect(),
            'presensi' => collect(),
            'tanggal' => $tanggal,
            'stats' => [
                'hadir' => 0,
                'izin' => 0,
                'sakit' => 0,
                'belum' => 0,
            ],
        ]);
    }

    $siswa = Siswa::where('kelas_id', $kelas->id)
        ->orderBy('nama')
        ->get();

    $presensi = Presensi::whereIn('siswa_id', $siswa->pluck('id'))
        ->whereDate('tanggal', $tanggal)
        ->get()
        ->keyBy('siswa_id');

    $stats = [
        'hadir' => $presensi->where('status', 'hadir')->count(),
        'izin' => $presensi->where('status', 'izin')->count(),
        'sakit' => $presensi->where('status', 'sakit')->count(),
        'belum' => $siswa->count() - $presensi->count(),
    ];

    return view('wali.dashboard', compact(
        'kelas',
        'siswa',
        'presensi',
        'tanggal',
        'stats'
    ));
}

public function updateStatus(Request $request, $siswaId)
{
    $kelas = Auth::user()->kelas;

    $siswa = Siswa::where('id', $siswaId)
        ->where('kelas_id', $kelas->id)
        ->firstOrFail();

    $request->validate([
        'status' => 'required|in:hadir,izin,sakit',
        'tanggal' => 'required|date',
    ]);

    Presensi::updateOrCreate(
        [
            'siswa_id' => $siswa->id,
            'tanggal' => $request->tanggal,
        ],
        [
            'status' => $request->status,
            'scanned_at' => $request->status === 'hadir' ? now() : null,
        ]
    );

    return back()->with(
        'success',
        'Status ' . $siswa->nama . ' diupdate.'
    );
}
}
