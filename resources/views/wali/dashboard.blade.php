@extends('layouts.app')
@section('title','Dashboard Wali Kelas')
@section('content')
<h1>Dashboard Wali Kelas</h1>
<div class="card"><h2>Kelas: {{ $kelas->nama ?? 'Belum ada kelas' }}</h2>
<form method="GET" class="row"><div><label>Tanggal presensi</label><input type="date" name="tanggal" value="{{ $tanggal }}"></div><div style="align-self:end"><button type="submit">Tampilkan</button></div></form></div>
<div class="stats">
<div class="card">Hadir<div class="big">{{ $stats['hadir'] }}</div></div><div class="card">Izin<div class="big">{{ $stats['izin'] }}</div></div><div class="card">Sakit<div class="big">{{ $stats['sakit'] }}</div></div><div class="card">Belum<div class="big">{{ $stats['belum'] }}</div></div>
</div>
<div class="card"><h2>Daftar Siswa</h2><div class="table-wrap"><table><thead><tr><th>NIS</th><th>Nama</th><th>Status</th><th>Ubah Status</th></tr></thead><tbody>
@forelse($siswa as $s) @php($p = $presensi->get($s->id))
<tr><td>{{ $s->nis }}</td><td>{{ $s->nama }}</td><td>{{ ucfirst($p->status ?? 'belum') }}</td><td><form method="POST" action="{{ route('wali.presensi.update',$s->id) }}" class="row">@csrf<input type="hidden" name="tanggal" value="{{ $tanggal }}"><select name="status"><option value="hadir" @selected(($p->status ?? '')==='hadir')>Hadir</option><option value="izin" @selected(($p->status ?? '')==='izin')>Izin</option><option value="sakit" @selected(($p->status ?? '')==='sakit')>Sakit</option></select><button type="submit">Simpan</button></form></td></tr>
@empty<tr><td colspan="4">Belum ada siswa untuk kelas ini.</td></tr>@endforelse
</tbody></table></div></div>
@endsection