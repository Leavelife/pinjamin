<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinjam.in - @yield('title')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-light-blue">

    <header class="header-bar text-white py-4 shadow-sm">
        <div class="header-inner-width text-center"> 
            <div class="d-inline-flex align-items-center">
                <div class="logo-box d-inline-block p-2 bg-white rounded-3 me-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Pinjam.in" class="logo-icon"> 
                </div>
                <div class="d-flex flex-column align-items-start">
                    <h1 class="h4 fw-bold mb-0">Pinjam.in</h1>
                    <p class="mb-0 app-tagline">Pinjam barang, bangun kepercayaan</p>
                </div>
            </div>
        </div>
    </header>

    <div class="container d-flex flex-column justify-content-center align-items-center py-5 custom-container-width">
        
        {{-- BAGIAN JUDUL DAN SUBJUDUL (DARI VIEW LOGIN/REGISTER) --}}
        @yield('page-header')

        {{-- CARD FORM --}}
        <div class="card auth-card border-secondary-color mt-3"> {{-- Memberi margin atas untuk memisahkan dari judul --}}
            <div class="card-body p-4 p-md-5">
                @yield('content')
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>