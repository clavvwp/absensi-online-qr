@extends('layouts.app')

@section('title', 'QR Siswa')

@section('content')
    <h1>QR Siswa</h1>
    <p>QR dibuat otomatis dari NIS masing-masing siswa.</p>

    <div>
        @forelse ($qrs as $item)
            <div class="qrbox">
                <strong>{{ $item->siswa->nama ?? 'Siswa' }}</strong>
                <div>NIS: {{ $item->qr_token }}</div>
                <div class="qr-code" data-qr-token="{{ $item->qr_token }}"></div>
            </div>
        @empty
            <p>Belum ada QR. Tambahkan siswa terlebih dahulu.</p>
        @endforelse
    </div>

    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script>
        // Buat satu QR untuk setiap siswa yang ditampilkan.
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-qr-token]').forEach(function (element) {
                const token = element.dataset.qrToken;
                if (window.QRCode) {
                    new QRCode(element, {
                        text: token,
                        width: 200,
                        height: 200,
                        correctLevel: QRCode.CorrectLevel.L
                    });
                } else {
                    element.textContent = 'Library QR tidak termuat.';
                }
            });
        });
    </script>
@endsection
