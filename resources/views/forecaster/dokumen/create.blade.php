@extends('layouts.app')

@section('title', 'Upload Dokumen - Forecaster')

@section('page-title', 'Upload Dokumen Baru')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('forecaster.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('forecaster.dokumen.index') }}">Dokumen Harian</a></li>
    <li class="breadcrumb-item active">Upload Baru</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-upload me-2"></i>
                    Upload Dokumen Penerbangan Harian
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('forecaster.dokumen.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Dokumen <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('judul') is-invalid @enderror" 
                               id="judul" 
                               name="judul" 
                               value="{{ old('judul') }}" 
                               placeholder="Contoh: Laporan Cuaca Harian 17 September 2025"
                               maxlength="150" 
                               required>
                        @error('judul')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">Maksimal 150 karakter</div>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" 
                                  name="deskripsi" 
                                  rows="4" 
                                  placeholder="Jelaskan isi dokumen dan informasi penting untuk maskapai..."
                                  required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">Berikan deskripsi yang jelas agar maskapai memahami isi dokumen</div>
                    </div>

                    <div class="mb-4">
                        <label for="file" class="form-label">File Dokumen <span class="text-danger">*</span></label>
                        <input type="file" 
                               class="form-control @error('file') is-invalid @enderror" 
                               id="file" 
                               name="file" 
                               accept=".pdf,.doc,.docx"
                               required>
                        @error('file')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Format yang didukung: PDF, DOC, DOCX. Maksimal ukuran: 10MB
                        </div>
                    </div>

                    <!-- File Preview (akan muncul setelah memilih file) -->
                    <div id="filePreview" class="mb-3" style="display: none;">
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-alt fa-2x me-3"></i>
                                <div>
                                    <strong>File Dipilih:</strong><br>
                                    <span id="fileName"></span><br>
                                    <small class="text-muted">Ukuran: <span id="fileSize"></span></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-lightbulb text-warning me-2"></i>
                                        Tips Upload Dokumen:
                                    </h6>
                                    <ul class="list-unstyled mb-0 small">
                                        <li><i class="fas fa-check text-success me-2"></i>Gunakan nama file yang jelas</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Pastikan file tidak corrupt</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Periksa isi dokumen sebelum upload</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Berikan deskripsi yang informatif</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-users text-info me-2"></i>
                                        Akan Diakses Oleh:
                                    </h6>
                                    <ul class="list-unstyled mb-0 small">
                                        <li><i class="fas fa-plane text-primary me-2"></i>Garuda Indonesia</li>
                                        <li><i class="fas fa-plane text-primary me-2"></i>Lion Air</li>
                                        <li><i class="fas fa-plane text-primary me-2"></i>Sriwijaya Air</li>
                                        <li><i class="fas fa-plane text-primary me-2"></i>Dan maskapai lainnya</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('forecaster.dokumen.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-upload me-2"></i>Upload Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    
    if (file) {
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
});

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Auto-generate judul berdasarkan tanggal hari ini
document.addEventListener('DOMContentLoaded', function() {
    const judulInput = document.getElementById('judul');
    if (!judulInput.value) {
        const today = new Date();
        const options = { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        const formattedDate = today.toLocaleDateString('id-ID', options);
        judulInput.placeholder = `Laporan Cuaca Harian ${formattedDate}`;
    }
});
</script>
@endpush