@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h1>Dashboard Admin</h1>

    <div class="stats">
        <div class="card">
            Total Siswa
            <div class="big">{{ $totalSiswa }}</div>
        </div>
        <div class="card">
            Total Kelas
            <div class="big">{{ $totalKelas }}</div>
        </div>
        <div class="card">
            Hadir Hari Ini
            <div class="big">{{ $totalHadirHariIni }}</div>
        </div>
    </div>

    <div class="card">
        <h2>Presensi Hari Ini (20 terakhir)</h2>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($presensiHariIni as $p)
                        <tr>
                            <td>{{ $p->scanned_at?->format('H:i:s') ?? '-' }}</td>
                            <td>{{ $p->siswa->nis ?? '-' }}</td>
                            <td>{{ $p->siswa->nama ?? '-' }}</td>
                            <td>{{ $p->siswa->kelas->nama ?? '-' }}</td>
                            <td>{{ ucfirst($p->status) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada presensi hari ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection