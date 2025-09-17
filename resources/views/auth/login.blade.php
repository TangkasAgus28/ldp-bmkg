@extends('layouts.app')

@section('title', 'Login - LDP BMKG')

@section('content')
<div class="container-fluid vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="row w-100">
        <div class="col-12 col-md-6 col-lg-4 mx-auto">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="fas fa-cloud-sun fa-3x text-primary"></i>
                        </div>
                        <h3 class="fw-bold text-dark">LDP BMKG</h3>
                        <p class="text-muted">Layanan Data Penerbangan<br>
                        <small>BMKG Kelas I I Gusti Ngurah Rai</small></p>
                    </div>

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="Masukkan email Anda"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Masukkan password Anda"
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Login
                            </button>
                        </div>
                    </form>

                    <div class="text-center">
                        <hr class="my-4">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="p-3 bg-light rounded">
                                    <i class="fas fa-user-tie fa-2x text-primary mb-2"></i>
                                    <h6 class="fw-bold">Forecaster</h6>
                                    <small class="text-muted">Tim BMKG</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-light rounded">
                                    <i class="fas fa-plane fa-2x text-success mb-2"></i>
                                    <h6 class="fw-bold">Penerbangan</h6>
                                    <small class="text-muted">Staf Maskapai</small>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted mt-3 d-block">
                            <i class="fas fa-info-circle me-1"></i>
                            Sistem akan mengarahkan Anda sesuai dengan role akun
                        </small>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <small class="text-white-50">
                    © 2025 BMKG Kelas I I Gusti Ngurah Rai
                </small>
            </div>
        </div>
    </div>
</div>
@endsection