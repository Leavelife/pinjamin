<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pinjam.in</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body{ background:#D7EEF2; font-family: 'Poppins', sans-serif; }

        .navbar-custom {
            background: linear-gradient(90deg,#308AA5,#3AA6B9);
            padding: 12px 25px;
        }

        .logo-box{ background:white; padding:6px 10px; border-radius:10px; display:flex; align-items:center; gap:8px;}
        .logo-box img{ height:30px; }
        .logo-text{ color:#FFFFFF; font-weight:700; font-size:18px; }

        .nav-menu a{ color:white; text-decoration:none; margin-left:22px; font-size:16px; font-weight:500; }
        .nav-menu a.active{ font-weight:700; border-bottom:3px solid rgba(94,200,255,0.9); padding-bottom:5px; }
        .nav-icons i{ color:white; font-size:20px; margin-left:16px; cursor:pointer; }
        .nav-icons a{ text-decoration:none; }

        /* Dropdown Menu Styling */
        .dropdown-menu-custom {
            background: white;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            padding: 8px 0;
            min-width: 200px;
        }

        .dropdown-menu-custom .dropdown-item {
            padding: 10px 20px;
            color: #308AA5;
            font-weight: 500;
            transition: all 0.2s;
        }

        .dropdown-menu-custom .dropdown-item:hover {
            background: #D7EEF2;
            color: #308AA5;
        }

        .dropdown-menu-custom .dropdown-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .dropdown-divider {
            margin: 5px 0;
            border-color: #e0e0e0;
        }

        /* Moving Underline Indicator */
        .nav-menu {
            position: relative;
        }

        .nav-underline{
            position: absolute;
            bottom: -6px;
            height: 3px;
            background: linear-gradient(90deg,#2FA7B3,#308AA5);
            border-radius: 3px;
            transition: left .25s ease, width .25s ease;
            left: 0;
            width: 0;
        }

        .nav-menu a:hover .nav-underline {
            transform: scaleX(1.2);
        }

        .notification-badge {
            font-size: 0.8rem !important;
            width: 16px;
            height: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: -5px;
            right: -5px;
            background: #FF6B6B;
            border-radius: 50%;
            color: white;
        }

        .notification-icon {
            position: relative;
            display: inline-block;
        }
    </style>
    @stack('head')
</head>
<body>

<nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
        <div class="logo-box">
            <img src="{{ asset('images/logo.png') }}" alt="logo">
        </div>
        <span class="logo-text">Pinjam.in</span>
    </div>

    <div class="nav-menu d-none d-md-flex align-items-center position-relative">
        @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="nav-link px-3">
                <i class="fas fa-chart-line me-2"></i>Admin Dashboard
            </a>
        @endif
        <a href="{{ route('dashboard') }}" 
           class="nav-link px-3 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
           Dashboard
        </a>

        <a href="{{ route('loan.history.page') }}" 
           class="nav-link px-3 {{ request()->routeIs('loan.history') ? 'active' : '' }}">
           Riwayat
        </a>

        <!-- moving underline indicator -->
        <span class="nav-underline"></span>
    </div>

    <div class="d-flex align-items-center nav-icons">
        {{-- Notifikasi --}}
        <a href="{{ route(name: 'notifications.page') }}" 
           class="position-relative mx-2" aria-label="Notifikasi">
            <i class="bi bi-bell"></i>
            <span class="badge bg-danger position-absolute rounded-circle" 
                  style="width:8px;height:8px;top:0;right:-2px;padding:0;"></span>
        </a>

        {{-- Profile --}}
        <a href="{{ route('profile.view.page') }}">
            <i class="bi bi-person"></i>
        </a>

        {{-- Desktop Dropdown --}}
        <div class="dropdown d-none d-md-inline-block">
            <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Menu">
                <i class="bi bi-list"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                <li>
                    <a class="dropdown-item" href="{{ route('items.mine') }}">
                        <i class="bi bi-box-seam"></i> Manajemen Barang
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        {{-- Mobile Hamburger --}}
        <a href="#" class="d-md-none" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
            <i class="bi bi-list"></i>
        </a>
    </div>
</nav>
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Pinjam.in</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <ul class="list-unstyled">
            <li class="mb-2">
                <a href="{{ route('dashboard') }}" class="text-decoration-none">Beranda</a>
            </li>
            <li class="mb-2">
                <a href="{{ route('loan.history.page') }}" class="text-decoration-none">Riwayat</a>
            </li>
            @if(Auth::check() && Auth::user()->role === 'admin')
                <li class="mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-primary">
                        <i class="fas fa-chart-line me-2"></i>Admin Dashboard
                    </a>
                </li>
            @endif
            <li class="mb-2">
                <a href="{{ route('notifications.page') }}" class="text-decoration-none">Notifikasi</a>
            </li>

            <li><hr></li>

            <li class="mb-2">
                <a href="{{ route('profile.view.page') }}" class="text-decoration-none">
                    <i class="bi bi-gear me-2"></i>Pengaturan Profil
                </a>
            </li>

            <li class="mb-2">
                <a href="{{ route('items.mine') }}" class="text-decoration-none">
                    <i class="bi bi-box-seam me-2"></i>Manajemen Barang
                </a>
            </li>

            <li><hr></li>

            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm w-100">
                        <i class="bi bi-box-arrow-right me-2"></i>Keluar
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>


<div class="container mt-4 mb-5">
    @yield('content')
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navMenu = document.querySelector('.nav-menu');
        const links = Array.from(navMenu?.querySelectorAll('.nav-link') || []);
        const indicator = navMenu?.querySelector('.nav-underline');
        if (!navMenu || !indicator || links.length === 0) return;
        function updateIndicator(el) {
            const rect = el.getBoundingClientRect();
            const parentRect = navMenu.getBoundingClientRect();
            const left = rect.left - parentRect.left + navMenu.scrollLeft;
            indicator.style.left = left + 'px';
            indicator.style.width = rect.width + 'px';
        }
        const active = links.find(l => l.classList.contains('active')) || links[0];
        updateIndicator(active);
        links.forEach(link => {
            link.addEventListener('click', function () {
                links.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                updateIndicator(this);
            });
        });
        let resizeTimeout;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                const current = navMenu.querySelector('.nav-link.active') || links[0];
                updateIndicator(current);
            }, 80);
        });
    });
</script>
</body>
</html>