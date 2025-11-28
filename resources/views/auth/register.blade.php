@extends('layouts.auth')

@section('title', 'Daftar')

@section('page-header')
    <h2 class="text-center text-primary-color mb-1 fw-bold" id="form-title">Daftar / Sign In</h2>
    <p class="card-subtitle text-center text-muted" id="form-subtitle">Silakan isi dengan identitas yang sesuai</p>
@endsection

@section('content')
    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf
        
        <div id="step-1">
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name') }}" 
                       placeholder="Masukkan nama lengkap Anda" required autocomplete="name" autofocus>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <div class="mb-3">
                <label for="study_program" class="form-label fw-bold">Program Studi</label>
                <input type="text" class="form-control" id="study_program" name="study_program" 
                       placeholder="Masukkan program studi Anda" required value="{{ old('study_program') }}">
            </div>

            <div class="mb-4">
                <label for="location" class="form-label fw-bold">Lokasi Anda</label>
                <input type="text" class="form-control" id="location" name="location" 
                       placeholder="Masukkan lokasi Anda" required value="{{ old('location') }}">
            </div>

            <button type="button" class="btn btn-secondary-color w-100 fw-bold py-2" id="next-step">
                Next &gt;
            </button>
        </div>

        <div id="step-2" style="display: none;">
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email') }}" 
                       placeholder="Masukkan email kampus Anda" required autocomplete="email">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <div class="mb-3">
                <label for="password_register" class="form-label fw-bold">Password / Kata sandi</label>
                <div class="password-toggle-container">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password_register" name="password" 
                           placeholder="Masukkan password Anda" required autocomplete="new-password">

                    {{-- ICON MATA --}}
                    <span class="password-toggle-icon password-show" onclick="togglePasswordVisibility('password_register')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </span>

                    <span class="password-toggle-icon password-hide" style="display: none;" onclick="togglePasswordVisibility('password_register')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.06 18.06 0 0 1 4.38-5.18L2 2m.5 2.5l20 20"></path>
                            <path d="M7.07 7.07A5 5 0 0 1 12 5c2.7 0 4.78 1.34 6 3 2.5 3.15 3.75 5.37 4.5 6.5l-2.43 2.43"></path>
                            <path d="M1 1l22 22"></path>
                        </svg>
                    </span>
                </div>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <div class="mb-4">
                <label for="password-confirm" class="form-label fw-bold">Konfirmasi Password</label>
                <div class="password-toggle-container">
                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation" 
                           placeholder="Ulangi password Anda" required autocomplete="new-password">

                    {{-- ICON MATA --}}
                    <span class="password-toggle-icon password-show" onclick="togglePasswordVisibility('password-confirm')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </span>

                    <span class="password-toggle-icon password-hide" style="display: none;" onclick="togglePasswordVisibility('password-confirm')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.06 18.06 0 0 1 4.38-5.18L2 2m.5 2.5l20 20"></path>
                            <path d="M7.07 7.07A5 5 0 0 1 12 5c2.7 0 4.78 1.34 6 3 2.5 3.15 3.75 5.37 4.5 6.5l-2.43 2.43"></path>
                            <path d="M1 1l22 22"></path>
                        </svg>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn btn-secondary-color w-100 fw-bold py-2">Daftar</button>

            {{-- LINK KE LOGIN --}}
            <div class="text-center mt-3">
                <small class="text-muted">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-primary fw-bold">Masuk di sini</a>
                </small>
            </div>

        </div>
    </form>
@endsection

@section('scripts')
<script>
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
    
    // Logika Step Registration
    const formTitle = document.getElementById('form-title');
    const formSubtitle = document.getElementById('form-subtitle');

    document.getElementById('next-step').addEventListener('click', function() {
        const name = document.getElementById('name').value;
        const studyProgram = document.getElementById('study_program').value;
        const location = document.getElementById('location').value;

        if (name && studyProgram && location) {
            document.getElementById('step-1').style.display = 'none';
            document.getElementById('step-2').style.display = 'block';

            formTitle.textContent = 'Daftar Lanjutan';
            formSubtitle.textContent = 'Masukkan email kampus dan kata sandi Anda';
        } else {
            alert('Harap isi semua kolom di Tahap 1.');
        }
    });
</script>
@endsection
