<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Bulanan Unduhan - {{ $maskapai->nama ?? 'Unknown' }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .summary { background-color: #f9f9f9; padding: 15px; margin: 20px 0; border-left: 4px solid #007bff; }
        .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #666; }
        .status-aktif { color: #28a745; font-weight: bold; }
        .status-tidak { color: #6c757d; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN BULANAN UNDUHAN DOKUMEN</h1>
        <h2>BMKG Kelas I I Gusti Ngurah Rai</h2>
        <h3>Sistem Layanan Data Penerbangan (LDP)</h3>
    </div>

    <div class="info">
        <table>
            <tr>
                <td><strong>Maskapai</strong></td>
                <td>{{ $maskapai->nama ?? 'Unknown' }} ({{ $maskapai->kode ?? 'N/A' }})</td>
            </tr>
            <tr>
                <td><strong>Periode Laporan</strong></td>
                <td>{{ $tahun }}</td>
            </tr>
            <tr>
                <td><strong>User</strong></td>
                <td>{{ $user->nama }}</td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Dicetak</strong></td>
                <td>{{ $tanggalGenerate }}</td>
            </tr>
        </table>
    </div>

    <div class="summary">
        <h3>RINGKASAN LAPORAN {{ $tahun }}</h3>
        <table>
            <tr>
                <td><strong>Total Unduhan</strong></td>
                <td>{{ $totalUnduhan }} dokumen</td>
            </tr>
            <tr>
                <td><strong>Bulan Aktif</strong></td>
                <td>{{ $bulanAktif }} dari 12 bulan</td>
            </tr>
            <tr>
                <td><strong>Status</strong></td>
                <td>{{ $totalUnduhan > 0 ? 'Aktif' : 'Tidak Aktif' }}</td>
            </tr>
        </table>
    </div>

    <h3>DETAIL LAPORAN BULANAN</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Total Unduhan</th>
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
                        <span class="status-aktif">Aktif</span>
                    @else
                        <span class="status-tidak">Tidak Ada</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dihasilkan secara otomatis oleh Sistem LDP BMKG</p>
        <p>Jl. Raya Ngurah Rai, Tuban, Kabupaten Badung, Bali 80362</p>
        <p>© {{ date('Y') }} BMKG Kelas I I Gusti Ngurah Rai</p>
    </div>

    <script>
        // Auto print dialog ketika halaman dibuka
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>