@extends('layouts.app')
@section('title','Data Siswa')
@section('content')
<h1>Data Siswa</h1>
<div class="card"><h2>Tambah Siswa</h2>
<form method="POST" action="{{ route('admin.siswa.store') }}">@csrf
<div class="row"><div><label>NIS</label><input name="nis" required></div><div><label>Nama Siswa</label><input name="nama" required></div>
<div><label>Kelas</label><select name="kelas_id" required><option value="">Pilih kelas</option>@foreach($kelas as $k)<option value="{{ $k->id }}">{{ $k->nama }}</option>@endforeach</select></div></div><br><button type="submit">Simpan Siswa + QR</button>
</form></div>
<div class="card"><h2>Daftar Siswa</h2><div class="table-wrap"><table><thead><tr><th>NIS</th><th>Nama</th><th>Kelas</th><th>Aksi</th></tr></thead><tbody>
@forelse($siswa as $s)<tr><td>{{ $s->nis }}</td><td>{{ $s->nama }}</td><td>{{ $s->kelas->nama ?? '-' }}</td><td><form method="POST" action="{{ route('admin.siswa.destroy',$s->id) }}" onsubmit="return confirm('Hapus siswa ini?')">@csrf @method('DELETE')<button class="danger" type="submit">Hapus</button></form></td></tr>
@empty<tr><td colspan="4">Belum ada data siswa.</td></tr>@endforelse
</tbody></table></div></div>
@endsection