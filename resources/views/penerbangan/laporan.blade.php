@extends('layouts.app')

@section('title', 'Laporan Bulanan - Penerbangan')

@section('page-title', 'Laporan Bulanan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('penerbangan.dashboard') }}">Dashboard</a></li>
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
                    <small class="text-muted">Laporan unduhan {{ Auth::user()->maskapai->nama ?? 'maskapai Anda' }} per bulan</small>
                </form>
            </div>
        </div>
    </div>

    <!-- Monthly Download Report -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Laporan Unduhan {{ Auth::user()->maskapai->nama ?? 'Maskapai' }} - {{ $tahun }}
                </h5>
            </div>
            <div class="card-body">
                @if($laporan->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Bulan</th>
                                    <th>Total Unduhan</th>
                                    <th>Status</th>
                                    <th>Progress</th>
                                    <th>Evaluasi</th>
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
                                                    <i class="fas fa-check me-1"></i>Aktif
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
                                                    @if($total > 0) bg-info 
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
                                        <td>
                                            @if($total >= 15)
                                                <span class="badge bg-success">Sangat Baik</span>
                                            @elseif($total >= 10)
                                                <span class="badge bg-primary">Baik</span>
                                            @elseif($total >= 5)
                                                <span class="badge bg-warning">Cukup</span>
                                            @elseif($total > 0)
                                                <span class="badge bg-secondary">Rendah</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Ada</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-chart-line fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Laporan untuk {{ $tahun }}</h5>
                        <p class="text-muted">Mulai download dokumen untuk melihat laporan bulanan Anda.</p>
                        <a href="{{ route('penerbangan.dokumen.index') }}" class="btn btn-primary">
                            <i class="fas fa-download me-2"></i>Download Dokumen
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Performance Summary -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $laporan->sum('total') }}</h4>
                        <small>Total {{ $tahun }}</small>
                    </div>
                    <i class="fas fa-download fa-2x opacity-75"></i>
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
        <div class="card text-white bg-primary">
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

<!-- Operational Analysis -->
@if($laporan->sum('total') > 0)
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Analisis Operasional
                </h6>
            </div>
            <div class="card-body">
                <h6 class="text-info mb-3">Kinerja {{ $tahun }}</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-download text-info me-2"></i>Total unduhan: <strong>{{ $laporan->sum('total') }} dokumen</strong></li>
                    <li><i class="fas fa-calendar text-info me-2"></i>Bulan aktif: <strong>{{ $laporan->where('total', '>', 0)->count() }} dari 12 bulan</strong></li>
                    <li><i class="fas fa-calculator text-info me-2"></i>Rata-rata bulanan: <strong>{{ number_format($laporan->sum('total') / 12, 1) }} dokumen</strong></li>
                    @if($laporan->max('total') > 0)
                        @php
                            $bulanTertinggi = $laporan->where('total', $laporan->max('total'))->first();
                        @endphp
                        <li><i class="fas fa-star text-info me-2"></i>Puncak aktivitas: <strong>{{ $months[$bulanTertinggi->bulan] ?? 'Unknown' }} ({{ $bulanTertinggi->total }} unduhan)</strong></li>
                    @endif
                </ul>

                @php
                    $performanceScore = 0;
                    if($laporan->sum('total') >= 100) $performanceScore += 25;
                    elseif($laporan->sum('total') >= 50) $performanceScore += 15;
                    elseif($laporan->sum('total') >= 20) $performanceScore += 10;
                    
                    if($laporan->where('total', '>', 0)->count() >= 10) $performanceScore += 25;
                    elseif($laporan->where('total', '>', 0)->count() >= 6) $performanceScore += 15;
                    elseif($laporan->where('total', '>', 0)->count() >= 3) $performanceScore += 10;
                    
                    if($laporan->sum('total') / 12 >= 10) $performanceScore += 25;
                    elseif($laporan->sum('total') / 12 >= 5) $performanceScore += 15;
                    elseif($laporan->sum('total') / 12 >= 2) $performanceScore += 10;
                    
                    $performanceScore += 25; // Base score
                @endphp

                <div class="mt-3">
                    <strong>Skor Kinerja: {{ $performanceScore }}/100</strong>
                    <div class="progress mt-2">
                        <div class="progress-bar 
                            @if($performanceScore >= 80) bg-success
                            @elseif($performanceScore >= 60) bg-primary  
                            @elseif($performanceScore >= 40) bg-warning
                            @else bg-danger
                            @endif" 
                            style="width: {{ $performanceScore }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-lightbulb me-2"></i>
                    Audit & Evaluasi
                </h6>
            </div>
            <div class="card-body">
                <h6 class="text-success mb-3">Untuk Audit Internal</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check-circle text-success me-2"></i>Data siap untuk laporan compliance</li>
                    <li><i class="fas fa-file-alt text-success me-2"></i>History lengkap tersedia di riwayat unduhan</li>
                    <li><i class="fas fa-chart-bar text-success me-2"></i>Tren konsistensi operasional tercatat</li>
                </ul>

                <h6 class="text-warning mb-3 mt-4">Rekomendasi</h6>
                <ul class="list-unstyled">
                    @if($laporan->sum('total') / 12 < 5)
                        <li><i class="fas fa-arrow-up text-warning me-2"></i>Tingkatkan frekuensi download rutin</li>
                    @endif
                    @if($laporan->where('total', 0)->count() > 3)
                        <li><i class="fas fa-calendar-check text-warning me-2"></i>Perbaiki konsistensi akses bulanan</li>
                    @endif
                    <li><i class="fas fa-sync text-warning me-2"></i>Monitor update dokumen harian secara berkala</li>
                    <li><i class="fas fa-users text-warning me-2"></i>Koordinasi rutin dengan tim BMKG</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endif
@endsection