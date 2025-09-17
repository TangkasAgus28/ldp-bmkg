@extends('layouts.app')

@section('title', 'Dashboard Penerbangan - LDP BMKG')

@section('page-title', 'Dashboard Penerbangan')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <!-- Statistik Cards -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-1">{{ $totalDokumen }}</h3>
                        <p class="mb-0">Dokumen Tersedia</p>
                        <small class="opacity-75">Yang dapat diunduh</small>
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
                        <small class="opacity-75">Dokumen yang diunduh</small>
                    </div>
                    <div class="text-end">
                        <i class="fas fa-download fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card text-white bg-primary">
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
                        <h3 class="mb-1">{{ Auth::user()->maskapai ? Auth::user()->maskapai->kode : 'N/A' }}</h3>
                        <p class="mb-0">Maskapai</p>
                        <small class="opacity-75">{{ ucfirst(Auth::user()->role) }}</small>
                    </div>
                    <div class="text-end">
                        <i class="fas fa-plane fa-2x opacity-75"></i>
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
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-file-alt me-2"></i>
                    Dokumen Harian
                </h5>
            </div>
            <div class="card-body">
                <p class="card-text">Akses dan unduh dokumen penerbangan harian yang diunggah oleh Tim BMKG.</p>
                <ul class="list-unstyled mb-3">
                    <li><i class="fas fa-check text-success me-2"></i>Lihat daftar dokumen terbaru</li>
                    <li><i class="fas fa-check text-success me-2"></i>Unduh dokumen yang diperlukan</li>
                    <li><i class="fas fa-check text-success me-2"></i>Cari dokumen berdasarkan tanggal</li>
                    <li><i class="fas fa-check text-success me-2"></i>Filter dokumen</li>
                </ul>
                <a href="{{ route('penerbangan.dokumen.index') }}" class="btn btn-info">
                    <i class="fas fa-arrow-right me-2"></i>Lihat Dokumen
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
                <p class="card-text">Lihat histori dokumen yang telah berhasil diunduh oleh maskapai Anda.</p>
                <ul class="list-unstyled mb-3">
                    <li><i class="fas fa-check text-success me-2"></i>History unduhan pribadi</li>
                    <li><i class="fas fa-check text-success me-2"></i>Tanggal dan waktu unduhan</li>
                    <li><i class="fas fa-check text-success me-2"></i>Detail dokumen yang diunduh</li>
                    <li><i class="fas fa-check text-success me-2"></i>Status unduhan</li>
                </ul>
                <a href="{{ route('penerbangan.riwayat') }}" class="btn btn-success">
                    <i class="fas fa-arrow-right me-2"></i>Lihat Riwayat
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Laporan Bulanan
                </h5>
            </div>
            <div class="card-body">
                <p class="card-text">Rekap jumlah total dokumen yang berhasil diunduh dalam periode satu bulan.</p>
                <ul class="list-unstyled mb-3">
                    <li><i class="fas fa-check text-success me-2"></i>Statistik unduhan bulanan</li>
                    <li><i class="fas fa-check text-success me-2"></i>Data untuk audit internal</li>
                    <li><i class="fas fa-check text-success me-2"></i>Evaluasi operasional</li>
                    <li><i class="fas fa-check text-success me-2"></i>Laporan tahunan</li>
                </ul>
                <a href="{{ route('penerbangan.laporan') }}" class="btn btn-primary">
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
                <p class="card-text">Informasi kontak BMKG I Gusti Ngurah Rai untuk koordinasi dan bantuan.</p>
                <ul class="list-unstyled mb-3">
                    <li><i class="fas fa-check text-success me-2"></i>Alamat kantor BMKG</li>
                    <li><i class="fas fa-check text-success me-2"></i>Nomor telepon resmi</li>
                    <li><i class="fas fa-check text-success me-2"></i>Email untuk koordinasi</li>
                    <li><i class="fas fa-check text-success me-2"></i>Jam layanan</li>
                </ul>
                <a href="{{ route('penerbangan.kontak') }}" class="btn btn-warning">
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
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('penerbangan.dokumen.index') }}" class="btn btn-outline-info btn-lg w-100">
                            <i class="fas fa-search fa-2x mb-2"></i><br>
                            Cari Dokumen Terbaru
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('penerbangan.riwayat') }}" class="btn btn-outline-success btn-lg w-100">
                            <i class="fas fa-history fa-2x mb-2"></i><br>
                            Cek Riwayat Unduhan
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('penerbangan.laporan') }}" class="btn btn-outline-primary btn-lg w-100">
                            <i class="fas fa-chart-line fa-2x mb-2"></i><br>
                            Lihat Laporan Bulanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Info Maskapai -->
@if(Auth::user()->maskapai)
<div class="row">
    <div class="col-12">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-plane me-2"></i>
                    Informasi Maskapai
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Nama Maskapai:</h6>
                        <p class="mb-3">{{ Auth::user()->maskapai->nama }}</p>
                        
                        <h6 class="fw-bold">Kode Maskapai:</h6>
                        <p class="mb-0">{{ Auth::user()->maskapai->kode }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">Status Akses:</h6>
                        <span class="badge bg-success mb-3">Aktif</span><br>
                        
                        <h6 class="fw-bold">Role Pengguna:</h6>
                        <span class="badge bg-info">{{ ucfirst(Auth::user()->role) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection