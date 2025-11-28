@extends('layouts.auth')

@section('title', 'Reset Password')

@section('page-header')
    <h2 class="text-center text-primary-color mb-1 fw-bold">Reset Kata Sandi</h2>
    <p class="card-subtitle text-center text-muted">Masukkan kata sandi baru Anda</p>
@endsection

@section('content')
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        {{-- EMAIL --}}
        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email', $email) }}" 
                   required autocomplete="email" autofocus>

            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- PASSWORD BARU --}}
        <div class="mb-3">
            <label for="password" class="form-label fw-bold">Kata Sandi Baru</label>
            <div class="input-group">
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" placeholder="Masukkan kata sandi baru" 
                       required autocomplete="new-password">
                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password')">
                    <i class="bi bi-eye"></i>
                </button>
            </div>

            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- KONFIRMASI PASSWORD --}}
        <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Kata Sandi</label>
            <div class="input-group">
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                       id="password_confirmation" name="password_confirmation" 
                       placeholder="Konfirmasi kata sandi baru" required autocomplete="new-password">
                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password_confirmation')">
                    <i class="bi bi-eye"></i>
                </button>
            </div>

            @error('password_confirmation')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-secondary-color w-100 fw-bold py-2">
            Reset Kata Sandi
        </button>
    </form>

    <p class="text-center mt-3 mb-0 small">
        Kembali ke <a href="{{ route('login') }}" class="text-primary-color fw-bold">login</a>
    </p>
@endsection

@section('scripts')
<script>
    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = event.target.closest('button').querySelector('i');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>
@endsection