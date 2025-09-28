@extends('layouts.app')

@section('title', 'Dashboard Forecaster - LDP BMKG')

@section('page-title', 'Dashboard Forecaster')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="row">
        <!-- Statistik Cards -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">{{ $totalDokumen }}</h3>
                            <p class="mb-0">Total Dokumen</p>
                            <small class="opacity-75">Yang telah diunggah</small>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-file-alt fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">{{ $totalUnduhan }}</h3>
                            <p class="mb-0">Total Unduhan</p>
                            <small class="opacity-75">Dari semua maskapai</small>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-download fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">{{ date('d') }}</h3>
                            <p class="mb-0">Hari Ini</p>
                            <small class="opacity-75">{{ date('M Y') }}</small>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-calendar fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">{{ Auth::user()->maskapai ? 'BMKG' : 'BMKG' }}</h3>
                            <p class="mb-0">Role</p>
                            <small class="opacity-75">{{ ucfirst(Auth::user()->role) }}</small>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-user-tie fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Cards -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        Dokumen Harian
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Kelola dokumen penerbangan harian yang akan diakses oleh maskapai.</p>
                    <ul class="list-unstyled mb-3">
                        <li><i class="fas fa-check text-success me-2"></i>Upload dokumen baru</li>
                        <li><i class="fas fa-check text-success me-2"></i>Edit dokumen yang ada</li>
                        <li><i class="fas fa-check text-success me-2"></i>Hapus dokumen lama</li>
                        <li><i class="fas fa-check text-success me-2"></i>Lihat daftar lengkap</li>
                    </ul>
                    <a href="{{ route('forecaster.dokumen.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-2"></i>Kelola Dokumen
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-download me-2"></i>
                        Riwayat Unduhan
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Pantau aktivitas unduhan dokumen oleh setiap maskapai.</p>
                    <ul class="list-unstyled mb-3">
                        <li><i class="fas fa-check text-success me-2"></i>Lihat siapa yang download</li>
                        <li><i class="fas fa-check text-success me-2"></i>Waktu unduhan</li>
                        <li><i class="fas fa-check text-success me-2"></i>Status per maskapai</li>
                        <li><i class="fas fa-check text-success me-2"></i>History lengkap</li>
                    </ul>
                    <a href="{{ route('forecaster.riwayat') }}" class="btn btn-success">
                        <i class="fas fa-arrow-right me-2"></i>Lihat Riwayat
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        Laporan Bulanan
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Lihat rekap total unggahan dokumen per bulan.</p>
                    <ul class="list-unstyled mb-3">
                        <li><i class="fas fa-check text-success me-2"></i>Statistik unggahan</li>
                        <li><i class="fas fa-check text-success me-2"></i>Data per bulan</li>
                        <li><i class="fas fa-check text-success me-2"></i>Laporan tahunan</li>
                        <li><i class="fas fa-check text-success me-2"></i>Analisis aktivitas</li>
                    </ul>
                    <a href="{{ route('forecaster.laporan') }}" class="btn btn-info">
                        <i class="fas fa-arrow-right me-2"></i>Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-address-book me-2"></i>
                        Info Kontak
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Informasi kontak BMKG I Gusti Ngurah Rai.</p>
                    <ul class="list-unstyled mb-3">
                        <li><i class="fas fa-check text-success me-2"></i>Alamat kantor</li>
                        <li><i class="fas fa-check text-success me-2"></i>Nomor telepon</li>
                        <li><i class="fas fa-check text-success me-2"></i>Email resmi</li>
                        <li><i class="fas fa-check text-success me-2"></i>Jam operasional</li>
                    </ul>
                    <a href="{{ route('forecaster.kontak') }}" class="btn btn-warning">
                        <i class="fas fa-arrow-right me-2"></i>Lihat Kontak
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-lightning-bolt me-2"></i>
                        Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('forecaster.dokumen.create') }}"
                                class="btn btn-outline-primary btn-lg w-100">
                                <i class="fas fa-plus-circle fa-2x mb-2"></i><br>
                                Upload Dokumen Baru
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('forecaster.dokumen.index') }}"
                                class="btn btn-outline-success btn-lg w-100">
                                <i class="fas fa-list fa-2x mb-2"></i><br>
                                Lihat Semua Dokumen
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('forecaster.riwayat') }}" class="btn btn-outline-info btn-lg w-100">
                                <i class="fas fa-history fa-2x mb-2"></i><br>
                                Cek Riwayat Terbaru
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('forecaster.laporan') }}" class="btn btn-outline-warning btn-lg w-100">
                                <i class="fas fa-chart-line fa-2x mb-2"></i><br>
                                Generate Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
