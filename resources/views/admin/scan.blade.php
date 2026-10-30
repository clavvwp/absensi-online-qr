@extends('layouts.app')

@section('title', 'Scan QR')

@section('content')

    <style>
    #reader video {
        transform: scaleX(-1);   /* batalkan efek mirror */
    }
</style>

    <h1>Scan QR Presensi</h1>
    <p>Kamera akan terbuka otomatis. Arahkan QR siswa ke kamera.</p>

    <div class="card">
        <div id="reader" style="width: 100%; max-width: 560px; margin: 0 auto;"></div>
        <div id="scan-result" class="msg" role="status" aria-live="polite">Membuka kamera...</div>
    </div>

    <div id="scan-config" data-endpoint="{{ url('/admin/scan') }}"></div>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        const resultBox = document.getElementById('scan-result');
        const scanEndpoint = document.getElementById('scan-config').dataset.endpoint;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        let scanner = null;
        let requestIsRunning = false;
        let lastToken = '';
        let lastScanTime = 0;

        function showResult(message, success) {
            resultBox.textContent = message;
            resultBox.className = success ? 'msg' : 'msg error';
        }

        // Kirim QR ke Laravel. Satu scan diproses dalam satu waktu.
        async function onScanSuccess(token) {
            token = String(token || '').trim();
            if (!token || requestIsRunning) return;

            const now = Date.now();
            if (token === lastToken && now - lastScanTime < 2500) return;
            lastToken = token;
            lastScanTime = now;
            requestIsRunning = true;
            showResult('QR terbaca. Memproses presensi...', true);

            try {
                const response = await fetch(scanEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ qr_token: token })
                });

                const data = await response.json();
                let message = data.message || 'Presensi gagal.';
                if (data.data) {
                    message += '\nNama: ' + data.data.nama;
                    message += '\nNIS: ' + data.data.nis;
                    message += '\nKelas: ' + data.data.kelas;
                    message += '\nWaktu: ' + data.data.waktu;
                }
                showResult(message, response.ok && data.success === true);
            } catch (error) {
                showResult('Tidak bisa menghubungi server. Pastikan Laravel masih berjalan.', false);
            } finally {
                requestIsRunning = false;
            }
        }

        // Kamera langsung dimulai ketika halaman scan dibuka.
        async function startCamera() {
            if (!window.Html5Qrcode) {
                showResult('Library scan tidak termuat. Periksa koneksi internet.', false);
                return;
            }

            scanner = new Html5Qrcode('reader', {
                formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE],
                verbose: false
            });

            try {
                await scanner.start(
                    { facingMode: 'environment' },
                    {
                        fps: 20,
                        qrbox: function (width, height) {
                            const size = Math.floor(Math.min(width, height) * 0.85);
                            return { width: size, height: size };
                        },
                        aspectRatio: 1.0,
                        disableFlip: false
                    },
                    onScanSuccess,
                    function () { /* QR belum terbaca; lanjut memindai. */ }
                );
                showResult('Kamera aktif. Dekatkan QR ke kamera dan pastikan QR terlihat jelas.', true);
            } catch (error) {
                showResult('Kamera gagal dibuka. Izinkan akses kamera dan buka lewat localhost.', false);
            }
        }

        document.addEventListener('DOMContentLoaded', startCamera);
    </script>
@endsection
