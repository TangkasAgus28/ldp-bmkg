@extends('layouts.app')

@section('title', 'Dokumen Harian - Penerbangan')

@section('page-title', 'Dokumen Harian')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('penerbangan.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Dokumen Harian</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-file-alt me-2"></i>
                    Dokumen Harian Tersedia
                </h5>
            </div>
            <div class="card-body">
                @if($dokumen->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Upload</th>
                                    <th>Forecaster</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dokumen as $index => $doc)
                                <tr>
                                    <td>{{ $dokumen->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $doc->judul }}</strong>
                                        @if($doc->created_at->isToday())
                                            <span class="badge bg-success ms-2">Baru Hari Ini</span>
                                        @elseif($doc->created_at->isYesterday())
                                            <span class="badge bg-info ms-2">Kemarin</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($doc->deskripsi, 80) }}</td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $doc->tanggal_upload->format('d M Y') }}<br>
                                            <i class="fas fa-clock me-1"></i>{{ $doc->created_at->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $doc->forecaster->nama }}
                                        </small>
                                    </td>
                                    <td>
                                        @php
                                            $sudahDownload = $doc->riwayatUnduhan->where('user_id', Auth::id())->first();
                                        @endphp
                                        
                                        @if($sudahDownload)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Sudah Diunduh
                                            </span><br>
                                            <small class="text-muted">
                                                {{ $sudahDownload->tanggal_unduh->format('d M Y H:i') }}
                                            </small>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-download me-1"></i>Belum Diunduh
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($doc->file_path)
                                            <a href="{{ route('penerbangan.dokumen.download', $doc->id) }}" 
                                               class="btn btn-primary btn-sm">
                                                <i class="fas fa-download me-1"></i>
                                                Download
                                            </a>
                                        @else
                                            <span class="text-muted">No File</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $dokumen->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Dokumen Tersedia</h5>
                        <p class="text-muted">Dokumen akan muncul setelah Tim BMKG mengunggah data penerbangan harian.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $dokumen->total() }}</h4>
                        <small>Total Dokumen</small>
                    </div>
                    <i class="fas fa-file-alt fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        @php
                            $sudahDownload = 0;
                            foreach($dokumen as $doc) {
                                if($doc->riwayatUnduhan->where('user_id', Auth::id())->first()) {
                                    $sudahDownload++;
                                }
                            }
                        @endphp
                        <h4>{{ $sudahDownload }}</h4>
                        <small>Sudah Diunduh</small>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $dokumen->total() - $sudahDownload }}</h4>
                        <small>Belum Diunduh</small>
                    </div>
                    <i class="fas fa-exclamation-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $dokumen->where('created_at', '>=', today())->count() }}</h4>
                        <small>Hari Ini</small>
                    </div>
                    <i class="fas fa-calendar fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Search (Optional Enhancement) -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-filter me-2"></i>
                    Filter & Pencarian
                </h6>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Cari Dokumen</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari berdasarkan judul...">
                    </div>
                    <div class="col-md-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" 
                               value="{{ request('tanggal') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status Download</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua</option>
                            <option value="sudah" {{ request('status') == 'sudah' ? 'selected' : '' }}>Sudah Diunduh</option>
                            <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Diunduh</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-1"></i>Cari
                        </button>
                        <a href="{{ route('penerbangan.dokumen.index') }}" class="btn btn-secondary">
                            <i class="fas fa-refresh me-1"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection