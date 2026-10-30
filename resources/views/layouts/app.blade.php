<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Presensi Siswa')</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; color: #222; }
        header { padding: 12px 16px; background: #f1f5f9; border-bottom: 1px solid #ddd; }
        nav { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
        nav a { color: #164e80; }
        main { max-width: 1000px; margin: 20px auto; padding: 0 14px; }
        .card { margin: 12px 0; padding: 14px; border: 1px solid #ddd; }
        label { display: block; margin: 10px 0 5px; }
        input, select { padding: 8px; border: 1px solid #aaa; }
        button, .btn { padding: 8px 12px; border: 1px solid #aaa; background: #f1f5f9; color: #222; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        th { background: #f5f5f5; }
        .table-wrap { overflow-x: auto; }
        .msg { margin: 12px 0; padding: 10px; background: #eef8ee; border: 1px solid #c7e3c7; white-space: pre-line; }
        .error { background: #fff0f0; border-color: #e5bcbc; }
        .qrbox { display: inline-block; margin: 8px; padding: 10px; border: 1px solid #ddd; text-align: center; }
        .qr-code { margin: 8px auto; }
    </style>
</head>
<body>
    <header>
        <strong>Presensi Siswa</strong>
        @if (auth()->check())
            <nav>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.scan') }}">Scan QR</a>
                    <a href="{{ route('admin.presensi') }}">Presensi</a>
                    <a href="{{ route('admin.siswa') }}">Data Siswa</a>
                    <a href="{{ route('admin.qr') }}">QR Siswa</a>
                @else
                    <a href="{{ route('wali.dashboard') }}">Dashboard Wali Kelas</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </nav>
        @endif
    </header>

    <main>
        @if (session('success'))
            <div class="msg">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="msg error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
