@extends('layouts.app')

@section('title', 'Laporan Bulanan - Forecaster')

@section('page-title', 'Laporan Bulanan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('forecaster.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Laporan Bulanan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Filter Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-filter me-2"></i>
                        Filter Laporan
                    </h6>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select class="form-select" id="tahun" name="tahun">
                                @for ($year = date('Y'); $year >= date('Y') - 5; $year--)
                                    <option value="{{ $year }}" {{ $tahun == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-8 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search me-1"></i>Tampilkan
                            </button>
                            <button type="submit" name="export" value="pdf" class="btn btn-success me-2">
                                <i class="fas fa-print me-1"></i>Print PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Card -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-upload me-2"></i>
                        Ringkasan Laporan {{ $tahun }} - Tim BMKG
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                <h3 class="text-success">{{ $laporan->sum('total') }}</h3>
                                <small class="text-muted">Total Unggahan</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h3 class="text-primary">{{ $laporan->where('total', '>', 0)->count() }}</h3>
                                <small class="text-muted">Bulan Aktif</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h3 class="text-warning">BMKG</h3>
                                <small class="text-muted">Forecaster</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Report Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-table me-2"></i>
                        Detail Laporan Bulanan Unggahan
                    </h5>
                </div>
                <div class="card-body">
                    @if ($laporan->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Tahun</th>
                                        <th>Total Unggahan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laporan as $item)
                                        <tr>
                                            <td>
                                                <strong>{{ DateTime::createFromFormat('!m', $item->bulan)->format('F') }}</strong>
                                            </td>
                                            <td>{{ $item->tahun }}</td>
                                            <td>
                                                <span class="badge bg-success fs-6">{{ $item->total }}</span>
                                                dokumen
                                            </td>
                                            <td>
                                                @if ($item->total > 0)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Tidak Ada</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum Ada Data Laporan</h5>
                            <p class="text-muted">Laporan akan muncul setelah Anda mulai mengunggah dokumen.</p>
                            <a href="{{ route('forecaster.dokumen.create') }}" class="btn btn-success">
                                <i class="fas fa-upload me-2"></i>Upload Dokumen Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Visualization -->
    @if ($laporan->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-chart-line me-2"></i>
                            Grafik Tren Unggahan {{ $tahun }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <canvas id="uploadChart" width="400" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Info Card -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informasi Laporan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-success">Kegunaan Laporan:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Evaluasi kinerja tim</li>
                                <li><i class="fas fa-check text-success me-2"></i>Monitoring produktivitas</li>
                                <li><i class="fas fa-check text-success me-2"></i>Laporan ke supervisor</li>
                                <li><i class="fas fa-check text-success me-2"></i>Analisis tren unggahan</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-warning">Catatan Penting:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-info text-primary me-2"></i>Data diperbarui real-time</li>
                                <li><i class="fas fa-info text-primary me-2"></i>Export tersedia dalam format PDF</li>
                                <li><i class="fas fa-info text-primary me-2"></i>Hanya menampilkan unggahan Anda</li>
                                <li><i class="fas fa-info text-primary me-2"></i>Filter tahunan untuk analisis detail</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @if ($laporan->count() > 0)
        <script>
            const ctx = document.getElementById('uploadChart').getContext('2d');
            const chartData = {
                labels: [
                    @foreach ($laporan as $item)
                        '{{ DateTime::createFromFormat('!m', $item->bulan)->format('M') }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Jumlah Unggahan',
                    data: [
                        @foreach ($laporan as $item)
                            {{ $item->total }},
                        @endforeach
                    ],
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.2)',
                    tension: 0.1,
                    fill: true
                }]
            };

            const config = {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Tren Unggahan Dokumen per Bulan'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            };

            new Chart(ctx, config);
        </script>
    @endif
@endpush
