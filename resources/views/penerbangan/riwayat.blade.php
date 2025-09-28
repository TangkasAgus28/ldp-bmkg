@extends('layouts.app')

@section('title', 'Riwayat Unduhan - Penerbangan')

@section('page-title', 'Riwayat Unduhan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('penerbangan.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Riwayat Unduhan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>
                        History Unduhan {{ Auth::user()->maskapai->nama ?? 'Anda' }}
                    </h5>
                </div>
                <div class="card-body">
                    @if ($riwayat->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Dokumen</th>
                                        <th>Deskripsi</th>
                                        <th>Tanggal Upload</th>
                                        <th>Tanggal Unduh</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($riwayat as $index => $item)
                                        <tr>
                                            <td>{{ $riwayat->firstItem() + $index }}</td>
                                            <td>
                                                <strong>{{ $item->dokumen->judul }}</strong>
                                                @if ($item->tanggal_unduh->isToday())
                                                    <span class="badge bg-success ms-2">Baru Diunduh</span>
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($item->dokumen->deskripsi, 60) }}</td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $item->dokumen->tanggal_upload->format('d M Y') }}<br>
                                                    oleh {{ $item->dokumen->forecaster->nama }}
                                                </small>
                                            </td>
                                            <td>
                                                <strong>{{ $item->tanggal_unduh->format('d M Y') }}</strong><br>
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $item->tanggal_unduh->format('H:i') }} WITA
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Berhasil
                                                </span>
                                                @if ($item->tanggal_unduh->diffInDays() <= 3)
                                                    <br><small
                                                        class="text-success">{{ $item->tanggal_unduh->diffForHumans() }}</small>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $riwayat->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-download fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum Ada Riwayat Unduhan</h5>
                            <p class="text-muted">Mulai download dokumen harian untuk melihat riwayat di sini.</p>
                            <a href="{{ route('penerbangan.dokumen.index') }}" class="btn btn-primary">
                                <i class="fas fa-file-alt me-2"></i>Lihat Dokumen Tersedia
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Personal Statistics -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $riwayat->total() }}</h4>
                            <small>Total Unduhan</small>
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
                            <h4>{{ $riwayat->where('created_at', '>=', today())->count() }}</h4>
                            <small>Hari Ini</small>
                        </div>
                        <i class="fas fa-calendar-day fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $riwayat->where('created_at', '>=', now()->startOfWeek())->count() }}</h4>
                            <small>Minggu Ini</small>
                        </div>
                        <i class="fas fa-calendar-week fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $riwayat->where('created_at', '>=', now()->startOfMonth())->count() }}</h4>
                            <small>Bulan Ini</small>
                        </div>
                        <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Timeline (Recent Downloads) -->
    @if ($riwayat->take(5)->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-timeline me-2"></i>
                            Aktivitas Terbaru
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @foreach ($riwayat->take(5) as $item)
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            <i class="fas fa-download text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">{{ $item->dokumen->judul }}</h6>
                                        <p class="mb-1 text-muted small">{{ Str::limit($item->dokumen->deskripsi, 80) }}
                                        </p>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $item->tanggal_unduh->format('d M Y H:i') }} WITA
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
