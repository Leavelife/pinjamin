@extends('layouts.auth')

@section('title', 'Masuk')

@php
    // Ambil parameter 'role' dari URL
    $role = request('role', 'user'); // Default ke 'user' jika tidak ada parameter
    $roleDisplay = ($role == 'admin') ? 'Admin' : 'User';
@endphp

{{-- JUDUL DAN SUBJUDUL DI LUAR CONTAINER/CARD --}}
@section('page-header')
    <h2 class="text-center text-primary-color mb-1 fw-bold">Masuk sebagai {{ $roleDisplay }}</h2>
    <p class="card-subtitle text-center text-muted">Silakan isi dengan identitas yang sesuai</p>
@endsection

@section('content')
    <form method="POST" action="{{ route('login') }}" id="loginForm">
        {{-- Anda mungkin ingin mengirimkan field 'role' tersembunyi jika Anda memerlukannya di controller --}}
        <input type="hidden" name="role" value="{{ $role }}"> 
        @csrf
        
        {{-- ... (Form input Email dan Password tetap sama) ... --}}
        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email') }}" 
                   placeholder="Masukkan email Anda" required autocomplete="email" autofocus>

            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-bold">Password / Kata sandi</label>
            <div class="password-toggle-container"> 
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" 
                       placeholder="Masukkan password / kata sandi Anda" required autocomplete="current-password">
                
                {{-- ICON MATA TERBUKA --}}
                <span class="password-toggle-icon password-show" onclick="togglePasswordVisibility('password')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </span>
                
                {{-- ICON MATA DICORET (AWALNYA TERSEMBUNYI) --}}
                <span class="password-toggle-icon password-hide" style="display: none;" onclick="togglePasswordVisibility('password')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.06 18.06 0 0 1 4.38-5.18L2 2m.5 2.5l20 20"></path>
                        <path d="M7.07 7.07A5 5 0 0 1 12 5c2.7 0 4.78 1.34 6 3 2.5 3.15 3.75 5.37 4.5 6.5l-2.43 2.43"></path>
                        <path d="M1 1l22 22"></path>
                    </svg>
                </span>
            </div>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4 small">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" 
                       {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label text-muted" for="remember">
                    Ingat saya
                </label>
            </div>
            
            <a href="{{ route('password.request') }}" class="forgot-password text-primary-color">Lupa kata sandi?</a>
        </div>

        <button type="submit" class="btn btn-secondary-color w-100 fw-bold py-2">Masuk</button>
    </form>

    <p class="text-center mt-3 mb-0 small">
        Belum punya akun? <a href="{{ route('register') }}" class="text-primary-color fw-bold">Daftar</a>
    </p>
@endsection

@section('scripts')
<script>
    // ... (Fungsi togglePasswordVisibility dan Logika JS Anda tetap sama) ...
    function togglePasswordVisibility(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const container = passwordField.closest('.password-toggle-container');
        const showIcon = container.querySelector('.password-show');
        const hideIcon = container.querySelector('.password-hide');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            showIcon.style.display = 'none';
            hideIcon.style.display = 'inline-block'; 
        } else {
            passwordField.type = 'password';
            showIcon.style.display = 'inline-block'; 
            hideIcon.style.display = 'none';
        }
    }
</script>
@endsection