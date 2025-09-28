<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LDP BMKG - Layanan Data Penerbangan')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }

        .sidebar .nav-link {
            color: #ffffff;
            padding: 12px 20px;
            margin: 2px 0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transform: translateX(5px);
        }

        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .navbar-brand {
            font-weight: 700;
            color: #1e3c72;
        }

        .btn-primary {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            border: none;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #2a5298, #1e3c72);
            transform: translateY(-1px);
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            @auth
                <!-- Sidebar -->
                <div class="col-md-3 col-lg-2 px-0">
                    <div class="sidebar p-3">
                        <div class="d-flex align-items-center mb-4">
                            <img src="{{ asset('images/logo-bmkg.png') }}" alt="Logo LDP BMKG" class="me-3"
                                style="width: 45px; height: 45px; object-fit: contain;">
                            <div>
                                <h6 class="text-white fw-bold mb-1">LDP BMKG</h6>
                                <small class="text-light">I Gusti Ngurah Rai</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="text-light opacity-75">Halo, {{ Auth::user()->nama }}</small><br>
                            <small class="text-light opacity-75">{{ ucfirst(Auth::user()->role) }}</small>
                            @if (Auth::user()->maskapai)
                                <br><small class="text-light opacity-75">{{ Auth::user()->maskapai->nama }}</small>
                            @endif
                        </div>

                        <nav class="nav flex-column">
                            @if (Auth::user()->role === 'forecaster')
                                <a class="nav-link {{ request()->routeIs('forecaster.dashboard') ? 'active' : '' }}"
                                    href="{{ route('forecaster.dashboard') }}">
                                    <i class="fas fa-home me-2"></i> Dashboard
                                </a>
                                <a class="nav-link {{ request()->routeIs('forecaster.dokumen.*') ? 'active' : '' }}"
                                    href="{{ route('forecaster.dokumen.index') }}">
                                    <i class="fas fa-file-alt me-2"></i> Dokumen Harian
                                </a>
                                <a class="nav-link {{ request()->routeIs('forecaster.riwayat') ? 'active' : '' }}"
                                    href="{{ route('forecaster.riwayat') }}">
                                    <i class="fas fa-download me-2"></i> Riwayat Unduhan
                                </a>
                                <a class="nav-link {{ request()->routeIs('forecaster.laporan') ? 'active' : '' }}"
                                    href="{{ route('forecaster.laporan') }}">
                                    <i class="fas fa-chart-bar me-2"></i> Laporan Bulanan
                                </a>
                                <a class="nav-link {{ request()->routeIs('forecaster.kontak') ? 'active' : '' }}"
                                    href="{{ route('forecaster.kontak') }}">
                                    <i class="fas fa-address-book me-2"></i> Info Kontak
                                </a>
                            @else
                                <a class="nav-link {{ request()->routeIs('penerbangan.dashboard') ? 'active' : '' }}"
                                    href="{{ route('penerbangan.dashboard') }}">
                                    <i class="fas fa-home me-2"></i> Dashboard
                                </a>
                                <a class="nav-link {{ request()->routeIs('penerbangan.dokumen.*') ? 'active' : '' }}"
                                    href="{{ route('penerbangan.dokumen.index') }}">
                                    <i class="fas fa-file-alt me-2"></i> Dokumen Harian
                                </a>
                                <a class="nav-link {{ request()->routeIs('penerbangan.riwayat') ? 'active' : '' }}"
                                    href="{{ route('penerbangan.riwayat') }}">
                                    <i class="fas fa-download me-2"></i> Riwayat Unduhan
                                </a>
                                <a class="nav-link {{ request()->routeIs('penerbangan.laporan') ? 'active' : '' }}"
                                    href="{{ route('penerbangan.laporan') }}">
                                    <i class="fas fa-chart-bar me-2"></i> Laporan Bulanan
                                </a>
                                <a class="nav-link {{ request()->routeIs('penerbangan.kontak') ? 'active' : '' }}"
                                    href="{{ route('penerbangan.kontak') }}">
                                    <i class="fas fa-address-book me-2"></i> Info Kontak
                                </a>
                            @endif

                            <hr class="text-white opacity-25 my-3">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>
            @endauth

            <!-- Main Content -->
            <div class="@auth col-md-9 col-lg-10 @else col-12 @endauth">
                <div class="main-content p-4">
                    @auth
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h2 class="mb-1">@yield('page-title', 'Dashboard')</h2>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        @yield('breadcrumb')
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    @endauth

                    <!-- Alert Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Page Content -->
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
