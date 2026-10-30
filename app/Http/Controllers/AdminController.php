<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas; 
use App\Models\Siswa; 
use App\Models\Qr; 
use App\Models\Presensi; 

class AdminController extends Controller
{
    public function dashboard()
{
    $totalSiswa = Siswa::count();
    $totalKelas = Kelas::count();

    $totalHadirHariIni = Presensi::whereDate('tanggal', today())
        ->where('status', 'hadir')
        ->count();

    $presensiHariIni = Presensi::with('siswa.kelas')
        ->whereDate('tanggal', today())
        ->latest('scanned_at')
        ->take(20)
        ->get();

    return view('admin.dashboard', compact(
        'totalSiswa',
        'totalKelas',
        'totalHadirHariIni',
        'presensiHariIni'
    ));
}

public function siswa()
{
    $siswa = Siswa::with('kelas')
        ->orderBy('nama')
        ->get();

    $kelas = Kelas::all();

    return view('admin.siswa', compact('siswa', 'kelas'));
}

public function siswaStore(Request $request)
{
    $request->validate([
        'nis' => 'required|unique:siswa,nis',
        'nama' => 'required',
        'kelas_id' => 'required|exists:kelas,id',
    ]);

    $siswa = Siswa::create(
        $request->only('nis', 'nama', 'kelas_id')
    );

    Qr::create([
        'siswa_id' => $siswa->id,
        'qr_token' => $siswa->nis,
        'status' => 'aktif',
    ]);

    return back()->with('success', 'Siswa + QR berhasil ditambah.');
}

public function siswaDestroy(int $id)
{
    Siswa::findOrFail($id)->delete();
    return back()->with('success', 'Siswa dihapus.');
}

public function qr()
{
    $qrs = Qr::with('siswa.kelas')->get();

    return view('admin.qr', compact('qrs'));
}

public function scan()
{
    return view('admin.scan');
}

public function scanProcess(Request $request)
{
    $token = trim($request->qr_token ?? '');

    $qr = Qr::where('qr_token', $token)
        ->with('siswa.kelas')
        ->first();

    if (!$qr) {
        $siswa = Siswa::where('nis', $token)
            ->with('kelas', 'qr')
            ->first();

        if (!$siswa || !$siswa->qr) {
            return response()->json([
                'success' => false,
                'message' => 'NIS / QR tidak valid',
            ], 404);
        }

        $qr = $siswa->qr;
        $qr->load('siswa.kelas');
    }

    if ($qr->status !== 'aktif') {
        return response()->json([
            'success' => false,
            'message' => 'QR nonaktif',
        ], 400);
    }

    $siswa = $qr->siswa;
    $today = today()->toDateString();

    if (
        Presensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', $today)
            ->exists()
    ) {
        return response()->json([
            'success' => false,
            'message' => $siswa->nama . ' sudah absen hari ini',
        ], 400);
    }

    $presensi = Presensi::create([
        'siswa_id' => $siswa->id,
        'status' => 'hadir',
        'tanggal' => $today,
        'scanned_at' => now(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Absensi berhasil!',
        'data' => [
            'nama' => $siswa->nama,
            'nis' => $siswa->nis,
            'kelas' => $siswa->kelas->nama ?? '-',
            'waktu' => $presensi->scanned_at->format('H:i:s'),
        ],
    ]);
}

public function presensi(Request $request)
{
    $tanggal = $request->tanggal ?? today()->toDateString();

    $presensi = Presensi::with('siswa.kelas')
        ->whereDate('tanggal', $tanggal)
        ->orderBy('scanned_at', 'desc')
        ->get();

    return view('admin.presensi', compact('presensi', 'tanggal'));
}
}
