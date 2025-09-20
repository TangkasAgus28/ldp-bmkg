@extends('layouts.app')

@section('title', 'Laporan Bulanan - Forecaster')

@section('page-title', 'Laporan Bulanan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('forecaster.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Laporan Bulanan</li>
@endsection

@section('content')
<div class="row">
    <!-- Year Selector -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <form method="GET" class="d-flex align-items-center">
                    <label for="tahun" class="form-label me-3 mb-0">Pilih Tahun:</label>
                    <select name="tahun" id="tahun" class="form-select me-3" style="width: auto;" onchange="this.form.submit()">
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <small class="text-muted">Laporan total unggahan dokumen per bulan</small>
                </form>
            </div>
        </div>
    </div>

    <!-- Monthly Report Chart -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Laporan Unggahan Tahun {{ $tahun }}
                </h5>
            </div>
            <div class="card-body">
                @if($laporan->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Bulan</th>
                                    <th>Total Unggahan</th>
                                    <th>Status</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $months = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                    $maxTotal = $laporan->max('total') ?: 1;
                                @endphp

                                @for($bulan = 1; $bulan <= 12; $bulan++)
                                    @php
                                        $data = $laporan->where('bulan', $bulan)->first();
                                        $total = $data ? $data->total : 0;
                                        $percentage = $maxTotal > 0 ? ($total / $maxTotal) * 100 : 0;
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong>{{ $months[$bulan] }}</strong>
                                            @if($bulan == date('n') && $tahun == date('Y'))
                                                <span class="badge bg-primary ms-2">Bulan Ini</span>
                                            @endif
                                        </td>
                                        <td>
                                            <h5 class="mb-0 
                                                @if($total > 0) text-success 
                                                @else text-muted 
                                                @endif">
                                                {{ $total }}
                                            </h5>
                                        </td>
                                        <td>
                                            @if($total > 0)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Ada Aktivitas
                                                </span>
                                            @elseif($bulan > date('n') && $tahun == date('Y'))
                                                <span class="badge bg-secondary">Belum Tiba</span>
                                            @else
                                                <span class="badge bg-warning">Tidak Ada</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar 
                                                    @if($total > 0) bg-success 
                                                    @else bg-light 
                                                    @endif" 
                                                    role="progressbar" 
                                                    style="width: {{ $percentage }}%"
                                                    aria-valuenow="{{ $total }}" 
                                                    aria-valuemin="0" 
                                                    aria-valuemax="{{ $maxTotal }}">
                                                    @if($total > 0) {{ $total }} @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Laporan untuk {{ $tahun }}</h5>
                        <p class="text-muted">Laporan akan dibuat otomatis setelah Anda mengunggah dokumen.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Summary Statistics -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $laporan->sum('total') }}</h4>
                        <small>Total {{ $tahun }}</small>
                    </div>
                    <i class="fas fa-upload fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $laporan->where('total', '>', 0)->count() }}</h4>
                        <small>Bulan Aktif</small>
                    </div>
                    <i class="fas fa-calendar-check fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $laporan->max('total') ?: 0 }}</h4>
                        <small>Tertinggi</small>
                    </div>
                    <i class="fas fa-arrow-up fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $laporan->sum('total') > 0 ? number_format($laporan->sum('total') / 12, 1) : 0 }}</h4>
                        <small>Rata-rata</small>
                    </div>
                    <i class="fas fa-calculator fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Analysis -->
@if($laporan->sum('total') > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-analytics me-2"></i>
                    Analisis Kinerja {{ $tahun }}
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-success mb-3">Pencapaian</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Total unggahan: <strong>{{ $laporan->sum('total') }} dokumen</strong></li>
                            <li><i class="fas fa-check text-success me-2"></i>Bulan aktif: <strong>{{ $laporan->where('total', '>', 0)->count() }} dari 12 bulan</strong></li>
                            <li><i class="fas fa-check text-success me-2"></i>Rata-rata bulanan: <strong>{{ number_format($laporan->sum('total') / 12, 1) }} dokumen</strong></li>
                            @if($laporan->max('total') > 0)
                                @php
                                    $bulanTertinggi = $laporan->where('total', $laporan->max('total'))->first();
                                    $months = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                @endphp
                                <li><i class="fas fa-check text-success me-2"></i>Bulan tertinggi: <strong>{{ $months[$bulanTertinggi->bulan] ?? 'Unknown' }} ({{ $bulanTertinggi->total }} dokumen)</strong></li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-info mb-3">Rekomendasi</h6>
                        <ul class="list-unstyled">
                            @if($laporan->where('total', 0)->count() > 0)
                                <li><i class="fas fa-lightbulb text-warning me-2"></i>Tingkatkan konsistensi di bulan yang belum ada unggahan</li>
                            @endif
                            @if($laporan->sum('total') / 12 < 5)
                                <li><i class="fas fa-lightbulb text-warning me-2"></i>Pertimbangkan untuk meningkatkan frekuensi unggahan</li>
                            @endif
                            <li><i class="fas fa-lightbulb text-warning me-2"></i>Pantau feedback maskapai untuk kualitas dokumen</li>
                            <li><i class="fas fa-lightbulb text-warning me-2"></i>Dokumentasikan proses untuk efisiensi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection