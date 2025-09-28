@extends('layouts.app')

@section('title', 'Info Kontak - LDP BMKG')

@section('page-title', 'Info Kontak')

@section('breadcrumb')
    @if (Auth::user()->role === 'forecaster')
        <li class="breadcrumb-item"><a href="{{ route('forecaster.dashboard') }}">Dashboard</a></li>
    @else
        <li class="breadcrumb-item"><a href="{{ route('penerbangan.dashboard') }}">Dashboard</a></li>
    @endif
    <li class="breadcrumb-item active">Info Kontak</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-building me-2"></i>
                        BMKG Kelas I I Gusti Ngurah Rai
                    </h5>
                </div>
                <div class="card-body">
                    @if ($kontak)
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card bg-light h-100">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary">
                                            <i class="fas fa-map-marker-alt me-2"></i>
                                            Alamat
                                        </h6>
                                        <p class="card-text">{{ $kontak->alamat }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card bg-light h-100">
                                    <div class="card-body">
                                        <h6 class="card-title text-success">
                                            <i class="fas fa-phone me-2"></i>
                                            Telepon
                                        </h6>
                                        <p class="card-text">
                                            <a href="tel:{{ $kontak->telepon }}" class="text-decoration-none">
                                                {{ $kontak->telepon }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title text-info">
                                            <i class="fas fa-envelope me-2"></i>
                                            Email
                                        </h6>
                                        <p class="card-text">
                                            <a href="mailto:{{ $kontak->email }}" class="text-decoration-none">
                                                {{ $kontak->email }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-clock me-2"></i>
                                    Jam Operasional
                                </h6>
                                <ul class="list-unstyled">
                                    <li><strong>Senin - Jumat:</strong> 08:00 - 16:00 WITA</li>
                                    <li><strong>Sabtu & Minggu:</strong> Tidak Beroprasi</li>
                                    <li class="mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Untuk layanan darurat 24 jam hubungi nomor telepon di atas
                                        </small>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-md-6">
                                <h6 class="text-success mb-3">
                                    <i class="fas fa-users me-2"></i>
                                    Layanan LDP
                                </h6>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success me-2"></i>Upload dokumen harian</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Download data penerbangan</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Monitoring riwayat unduhan</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Laporan bulanan</li>
                                    <li class="mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-headset me-1"></i>
                                            Untuk bantuan teknis sistem LDP hubungi IT Support
                                        </small>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="alert alert-info mt-4">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-info-circle fa-lg me-3 mt-1"></i>
                                <div>
                                    <h6 class="alert-heading mb-2">Informasi Penting</h6>
                                    <ul class="mb-0">
                                        <li>Sistem LDP beroperasi 24/7 untuk akses dokumen</li>
                                        <li>Data cuaca dan penerbangan diperbarui setiap hari</li>
                                        <li>Untuk koordinasi khusus, hubungi langsung via telepon</li>
                                        <li>Akun pengguna dikelola oleh administrator sistem</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                            <h5 class="text-muted">Informasi Kontak Tidak Tersedia</h5>
                            <p class="text-muted">Silakan hubungi administrator untuk informasi kontak.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="text-center mt-4">
                @if (Auth::user()->role === 'forecaster')
                    <a href="{{ route('forecaster.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                @else
                    <a href="{{ route('penerbangan.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
