@extends('layouts.app')

@section('title', 'Login - LDP BMKG')

@section('content')
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center"
        style="background: linear-gradient(rgba(30, 60, 114, 0.4), rgba(42, 82, 152, 0.4), rgba(102, 126, 234, 0.4)), url('{{ asset('images/background-login.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed; position: relative;">
        <!-- Background Pattern Overlay -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.05; background-image: url('data:image/svg+xml,<svg width="60"
            height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg">
            <g fill="none" fill-rule="evenodd">
                <g fill="%23ffffff" fill-opacity="0.3">
                    <circle cx="30" cy="30" r="2" />
                    <circle cx="10" cy="10" r="1" />
                    <circle cx="50" cy="10" r="1" />
                    <circle cx="10" cy="50" r="1" />
                    <circle cx="50" cy="50" r="1" />
                </g></svg>');">
        </div>

        <div class="row w-100">
            <div class="col-12 col-md-6 col-lg-4 mx-auto">
                <div class="card shadow-lg border-0"
                    style="border-radius: 16px; backdrop-filter: blur(15px); background: rgba(255, 255, 255, 0.75);">
                    <div class="card-body p-4">
                        <!-- Header Section -->
                        <div class="text-center mb-4">
                            <div class="mb-3 position-relative">
                                <div class="d-inline-block p-2 rounded-circle"
                                    style="background: linear-gradient(135deg, #1e3c72, #2a5298); box-shadow: 0 8px 20px rgba(30, 60, 114, 0.3);">
                                    <img src="{{ asset('images/logo-bmkg.png') }}" alt="Logo LDP BMKG"
                                        style="width: 50px; height: 50px; object-fit: contain;">
                                </div>
                            </div>
                            <h3 class="fw-bold mb-1" style="color: #1e3c72;">LDP BMKG</h3>
                            <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.4;">
                                Layanan Data Penerbangan<br>
                                <span style="color: #6c757d; font-size: 0.8rem;">BMKG Kelas I I Gusti Ngurah Rai</span>
                            </p>
                        </div>

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf

                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold"
                                    style="color: #1e3c72; margin-bottom: 6px; font-size: 0.9rem;">Email Address</label>
                                <div class="input-group" style="border-radius: 10px; overflow: hidden;">
                                    <span class="input-group-text border-0"
                                        style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); color: #1e3c72; padding: 10px 14px;">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control border-0 @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}"
                                        placeholder="Enter your email address"
                                        style="padding: 10px 14px; background: #f8f9fa; font-size: 0.9rem;" required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold"
                                    style="color: #1e3c72; margin-bottom: 6px; font-size: 0.9rem;">Password</label>
                                <div class="input-group" style="border-radius: 10px; overflow: hidden;">
                                    <span class="input-group-text border-0"
                                        style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); color: #1e3c72; padding: 10px 14px;">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password"
                                        class="form-control border-0 @error('password') is-invalid @enderror" id="password"
                                        name="password" placeholder="Enter your password"
                                        style="padding: 10px 14px; background: #f8f9fa; font-size: 0.9rem;" required>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Login Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-lg border-0 fw-semibold"
                                    style="background: linear-gradient(135deg, #1e3c72, #2a5298, #667eea); color: white; padding: 12px; border-radius: 10px; box-shadow: 0 6px 20px rgba(30, 60, 114, 0.3); transition: all 0.3s ease;"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 30px rgba(30, 60, 114, 0.4)'"
                                    onmouseout="this.style.transform='translateY(0px)'; this.style.boxShadow='0 6px 20px rgba(30, 60, 114, 0.3)'">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    Sign In to Continue
                                </button>
                            </div>
                        </form>

                        <!-- User Roles Section -->
                        <div class="text-center">
                            <div class="mb-3">
                                <div
                                    style="height: 1px; background: linear-gradient(to right, transparent, #dee2e6, transparent);">
                                </div>
                                <small class="px-3 text-muted bg-white position-relative"
                                    style="top: -8px; font-size: 0.8rem;">Access Roles</small>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="p-2 rounded-3 h-100"
                                        style="background: linear-gradient(135deg, #f8f9ff, #e8f0fe); border: 1px solid rgba(30, 60, 114, 0.1); transition: all 0.3s ease;"
                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(30, 60, 114, 0.15)'"
                                        onmouseout="this.style.transform='translateY(0px)'; this.style.boxShadow='none'">
                                        <div class="mb-1">
                                            <i class="fas fa-user-tie fa-lg" style="color: #1e3c72;"></i>
                                        </div>
                                        <h6 class="fw-bold mb-0" style="color: #1e3c72; font-size: 0.85rem;">Forecaster</h6>
                                        <small class="text-muted" style="font-size: 0.75rem;">BMKG Staff</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 rounded-3 h-100"
                                        style="background: linear-gradient(135deg, #f0f9ff, #e0f2fe); border: 1px solid rgba(34, 197, 94, 0.1); transition: all 0.3s ease;"
                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(34, 197, 94, 0.15)'"
                                        onmouseout="this.style.transform='translateY(0px)'; this.style.boxShadow='none'">
                                        <div class="mb-1">
                                            <i class="fas fa-plane fa-lg" style="color: #22c55e;"></i>
                                        </div>
                                        <h6 class="fw-bold mb-0" style="color: #22c55e; font-size: 0.85rem;">Airlines</h6>
                                        <small class="text-muted" style="font-size: 0.75rem;">Airline Staff</small>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2 rounded-3"
                                style="background: rgba(30, 60, 114, 0.05); border: 1px solid rgba(30, 60, 114, 0.1);">
                                <small class="text-muted d-block" style="line-height: 1.4; font-size: 0.8rem;">
                                    <i class="fas fa-info-circle me-1" style="color: #1e3c72;"></i>
                                    System akan mengarahkan sesuai role akun
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-3">
                    <div class="d-inline-block px-3 py-1 rounded-pill"
                        style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
                        <small class="text-white" style="font-size: 0.8rem;">
                            © 2025 BMKG Kelas I I Gusti Ngurah Rai
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Additional Professional Styling */
        .form-control:focus {
            background: #ffffff !important;
            box-shadow: 0 0 0 3px rgba(30, 60, 114, 0.1) !important;
            border-color: transparent !important;
        }

        .input-group-text {
            border: none !important;
        }

        .card {
            animation: slideInUp 0.6s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem !important;
            }
        }
    </style>
@endsection
