@extends('layouts.app')

@section('title', 'Riwayat Unduhan - Forecaster')

@section('page-title', 'Riwayat Unduhan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('forecaster.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Riwayat Unduhan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-download me-2"></i>
                    Monitoring Unduhan Dokumen
                </h5>
            </div>
            <div class="card-body">
                @if($riwayat->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Dokumen</th>
                                    <th>Maskapai</th>
                                    <th>User</th>
                                    <th>Tanggal Unduh</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayat as $index => $item)
                                <tr>
                                    <td>{{ $riwayat->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $item->dokumen->judul }}</strong><br>
                                        <small class="text-muted">
                                            Upload: {{ $item->dokumen->tanggal_upload->format('d M Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $item->maskapai->kode }}</span><br>
                                        <small class="text-muted">{{ $item->maskapai->nama }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $item->user->nama }}</strong><br>
                                        <small class="text-muted">{{ $item->user->email }}</small>
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
                                        @if($item->tanggal_unduh->isToday())
                                            <br><small class="text-success">Hari ini</small>
                                        @elseif($item->tanggal_unduh->isYesterday())
                                            <br><small class="text-info">Kemarin</small>
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
                        <p class="text-muted">Riwayat akan muncul setelah maskapai mengunduh dokumen Anda.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
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
        <div class="card text-white bg-info">
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
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $riwayat->groupBy('maskapai_id')->count() }}</h4>
                        <small>Maskapai Aktif</small>
                    </div>
                    <i class="fas fa-plane fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-filter me-2"></i>
                    Filter Riwayat
                </h6>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label for="maskapai" class="form-label">Maskapai</label>
                        <select class="form-select" id="maskapai" name="maskapai">
                            <option value="">Semua Maskapai</option>
                            @php
                                $maskapai_list = $riwayat->unique('maskapai_id')->pluck('maskapai')->unique('id');
                            @endphp
                            @foreach($maskapai_list as $m)
                                <option value="{{ $m->id }}" {{ request('maskapai') == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama }} ({{ $m->kode }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="tanggal_dari" class="form-label">Dari Tanggal</label>
                        <input type="date" class="form-control" id="tanggal_dari" name="tanggal_dari" 
                               value="{{ request('tanggal_dari') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="tanggal_sampai" class="form-label">Sampai Tanggal</label>
                        <input type="date" class="form-control" id="tanggal_sampai" name="tanggal_sampai" 
                               value="{{ request('tanggal_sampai') }}">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-1"></i>Filter
                        </button>
                        <a href="{{ route('forecaster.riwayat') }}" class="btn btn-secondary">
                            <i class="fas fa-refresh me-1"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection