@extends('layouts.app')

@section('title', 'Data Presensi')

@section('content')
    <h1>Data Presensi Hari Ini</h1>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Waktu Scan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($presensi as $p)
                    <tr>
                        <td>{{ $p->siswa->nama ?? '-' }}</td>
                        <td>{{ $p->siswa->nis ?? '-' }}</td>
                        <td>{{ $p->siswa->kelas->nama ?? '-' }}</td>
                        <td>{{ $p->tanggal }}</td>
                        <td>{{ ucfirst($p->status) }}</td>
                        <td>{{ $p->scanned_at ? $p->scanned_at->format('H:i:s') : '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6">Belum ada data presensi hari ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
