@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('page-header')
    <h2 class="text-center text-primary-color mb-1 fw-bold">Lupa Kata Sandi?</h2>
    <p class="card-subtitle text-center text-muted">Masukkan email Anda untuk reset password</p>
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email') }}" 
                   placeholder="Masukkan email Anda" required autocomplete="email" autofocus>

            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-secondary-color w-100 fw-bold py-2">
            Kirim Link Reset
        </button>
    </form>

    <p class="text-center mt-3 mb-0 small">
        Ingat password Anda? <a href="{{ route('login') }}" class="text-primary-color fw-bold">Masuk</a>
    </p>
@endsection

