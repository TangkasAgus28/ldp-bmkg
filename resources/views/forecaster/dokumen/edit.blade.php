@extends('layouts.app')

@section('title', 'Edit Dokumen - Forecaster')

@section('page-title', 'Edit Dokumen')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('forecaster.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('forecaster.dokumen.index') }}">Dokumen Harian</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Edit Dokumen: {{ $dokumen->judul }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('forecaster.dokumen.update', $dokumen->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Dokumen <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('judul') is-invalid @enderror" 
                               id="judul" 
                               name="judul" 
                               value="{{ old('judul', $dokumen->judul) }}" 
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
                                  required>{{ old('deskripsi', $dokumen->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Current File Info -->
                    @if($dokumen->file_path)
                    <div class="mb-3">
                        <label class="form-label">File Saat Ini</label>
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-alt fa-2x me-3"></i>
                                <div>
                                    <strong>{{ basename($dokumen->file_path) }}</strong><br>
                                    <small class="text-muted">
                                        Diupload: {{ $dokumen->tanggal_upload->format('d M Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="mb-4">
                        <label for="file" class="form-label">
                            @if($dokumen->file_path)
                                Ganti File (Opsional)
                            @else
                                File Dokumen <span class="text-danger">*</span>
                            @endif
                        </label>
                        <input type="file" 
                               class="form-control @error('file') is-invalid @enderror" 
                               id="file" 
                               name="file" 
                               accept=".pdf,.doc,.docx"
                               @if(!$dokumen->file_path) required @endif>
                        @error('file')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            @if($dokumen->file_path)
                                Kosongkan jika tidak ingin mengganti file. Format: PDF, DOC, DOCX. Maksimal: 10MB
                            @else
                                Format yang didukung: PDF, DOC, DOCX. Maksimal ukuran: 10MB
                            @endif
                        </div>
                    </div>

                    <!-- New File Preview -->
                    <div id="filePreview" class="mb-3" style="display: none;">
                        <div class="alert alert-warning">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-alt fa-2x me-3"></i>
                                <div>
                                    <strong>File Baru Dipilih:</strong><br>
                                    <span id="fileName"></span><br>
                                    <small class="text-muted">Ukuran: <span id="fileSize"></span></small>
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                File lama akan diganti dengan file baru ini
                            </small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-info-circle text-info me-2"></i>
                                        Informasi Dokumen:
                                    </h6>
                                    <ul class="list-unstyled mb-0 small">
                                        <li><strong>Tanggal Upload:</strong> {{ $dokumen->tanggal_upload->format('d M Y') }}</li>
                                        <li><strong>Diupload Oleh:</strong> {{ $dokumen->forecaster->nama }}</li>
                                        <li><strong>Terakhir Diupdate:</strong> {{ $dokumen->updated_at->format('d M Y H:i') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                        Perhatian:
                                    </h6>
                                    <ul class="list-unstyled mb-0 small">
                                        <li><i class="fas fa-check text-success me-2"></i>Perubahan akan langsung terlihat</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Maskapai akan melihat versi terbaru</li>
                                        <li><i class="fas fa-check text-success me-2"></i>File lama akan dihapus jika diganti</li>
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
                        <div>
                            <button type="button" class="btn btn-danger me-2" onclick="confirmDelete()">
                                <i class="fas fa-trash me-2"></i>Hapus Dokumen
                            </button>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Hidden Delete Form -->
                <form id="deleteForm" action="{{ route('forecaster.dokumen.delete', $dokumen->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
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

function confirmDelete() {
    if (confirm('Yakin ingin menghapus dokumen ini? Tindakan ini tidak dapat dibatalkan dan akan menghapus file dari server.')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endpush