<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Bulanan Unggahan - {{ $user->nama }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #16a34a; padding-bottom: 20px; }
        .info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #dcfce7; font-weight: bold; }
        .summary { background-color: #f0fdf4; padding: 15px; margin: 20px 0; border-left: 4px solid #16a34a; }
        .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #666; }
        .status-aktif { color: #16a34a; font-weight: bold; }
        .status-tidak { color: #6c757d; }
        .forecaster-header { color: #16a34a; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="forecaster-header">LAPORAN BULANAN UNGGAHAN DOKUMEN</h1>
        <h2>BMKG Kelas I I Gusti Ngurah Rai</h2>
        <h3>Sistem Layanan Data Penerbangan (LDP)</h3>
    </div>

    <div class="info">
        <table>
            <tr>
                <td><strong>Forecaster</strong></td>
                <td>{{ $user->nama }}</td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <td><strong>Role</strong></td>
                <td>{{ ucfirst($user->role) }} - Tim BMKG</td>
            </tr>
            <tr>
                <td><strong>Periode Laporan</strong></td>
                <td>{{ $tahun }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Generate</strong></td>
                <td>{{ $tanggalGenerate }}</td>
            </tr>
        </table>
    </div>

    <div class="summary">
        <h3>RINGKASAN LAPORAN {{ $tahun }}</h3>
        <table>
            <tr>
                <td><strong>Total Unggahan</strong></td>
                <td>{{ $totalUnggahan }} dokumen</td>
            </tr>
            <tr>
                <td><strong>Bulan Aktif</strong></td>
                <td>{{ $bulanAktif }} dari 12 bulan</td>
            </tr>
            <tr>
                <td><strong>Status Produktivitas</strong></td>
                <td>{{ $totalUnggahan > 0 ? 'Aktif' : 'Perlu Peningkatan' }}</td>
            </tr>
        </table>
    </div>

    <h3>DETAIL LAPORAN BULANAN UNGGAHAN</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Total Unggahan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ DateTime::createFromFormat('!m', $item->bulan)->format('F') }}</td>
                <td>{{ $item->tahun }}</td>
                <td>{{ $item->total }}</td>
                <td>
                    @if($item->total > 0)
                        <span class="status-aktif">Produktif</span>
                    @else
                        <span class="status-tidak">Tidak Ada</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h4>CATATAN KINERJA:</h4>
        <ul>
            <li><strong>Konsistensi:</strong> {{ $bulanAktif }} bulan dari {{ $laporan->count() }} bulan menunjukkan aktivitas</li>
            <li><strong>Produktivitas:</strong> {{ $totalUnggahan }} dokumen total yang diunggah</li>
            <li><strong>Rata-rata:</strong> {{ number_format($laporan->avg('total'), 1) }} dokumen per bulan</li>
            @if($totalUnggahan > 0)
                <li><strong>Evaluasi:</strong> Kinerja menunjukkan kontribusi positif untuk layanan penerbangan</li>
            @else
                <li><strong>Rekomendasi:</strong> Perlu peningkatan aktivitas unggahan dokumen</li>
            @endif
        </ul>
    </div>

    <div class="footer">
        <p>Laporan ini dihasilkan secara otomatis oleh Sistem LDP BMKG</p>
        <p>Jl. Raya Ngurah Rai, Tuban, Kabupaten Badung, Bali 80362</p>
        <p>© {{ date('Y') }} BMKG Kelas I I Gusti Ngurah Rai</p>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>