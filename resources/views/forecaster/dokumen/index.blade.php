@extends('layouts.app')

@section('title', 'Dokumen Harian - Forecaster')

@section('page-title', 'Dokumen Harian')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('forecaster.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Dokumen Harian</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        Daftar Dokumen Harian
                    </h5>
                    <a href="{{ route('forecaster.dokumen.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Upload Dokumen Baru
                    </a>
                </div>
                <div class="card-body">
                    @if ($dokumen->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Deskripsi</th>
                                        <th>Tanggal Upload</th>
                                        <th>File</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dokumen as $index => $doc)
                                        <tr>
                                            <td>{{ $dokumen->firstItem() + $index }}</td>
                                            <td>
                                                <strong>{{ $doc->judul }}</strong>
                                                @if ($doc->created_at->isToday())
                                                    <span class="badge bg-success ms-2">Baru</span>
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($doc->deskripsi, 100) }}</td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $doc->tanggal_upload->format('d M Y') }}
                                                </small>
                                            </td>
                                            <td>
                                                @if ($doc->file_path)
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-file me-1"></i>
                                                        {{ pathinfo($doc->file_path, PATHINFO_EXTENSION) }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">No File</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('forecaster.dokumen.edit', $doc->id) }}"
                                                        class="btn btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('forecaster.dokumen.delete', $doc->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
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
                            <h5 class="text-muted">Belum Ada Dokumen</h5>
                            <p class="text-muted">Mulai upload dokumen harian untuk maskapai.</p>
                            <a href="{{ route('forecaster.dokumen.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Upload Dokumen Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
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
                            <h4>{{ $dokumen->where('created_at', '>=', today())->count() }}</h4>
                            <small>Upload Hari Ini</small>
                        </div>
                        <i class="fas fa-upload fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $dokumen->where('created_at', '>=', now()->startOfWeek())->count() }}</h4>
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
                            <h4>{{ $dokumen->where('created_at', '>=', now()->startOfMonth())->count() }}</h4>
                            <small>Bulan Ini</small>
                        </div>
                        <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
