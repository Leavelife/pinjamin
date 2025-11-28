@extends('layouts.auth')

@section('title', 'Pilih Role')

<style>
    /* Mengambil warna dari CSS Anda */
    :root {
        --primary-color: #3AA6B9; /* Biru-Cyan Utama */
        --secondary-color: #61C4D4; /* Aksen/Tombol */
    }
    
    /* Tombol untuk Admin */
    .btn-primary-custom {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        transition: all 0.2s ease-in-out;
    }

    .btn-primary-custom:hover {
        background-color: #2F92A3;
        border-color: #2F92A3;
    }
    
    /* Tombol untuk User */
    .btn-secondary-color {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
        color: white;
        transition: all 0.2s ease-in-out;
    }

    .btn-secondary-color:hover {
        background-color: #2F92A3;
        border-color: #2F92A3;
    }
</style>

@section('page-header')
    <h2 class="text-center text-primary-color mb-1 fw-bold">Pilih Role</h2>
    <p class="card-subtitle text-center text-muted">Masuk sebagai Admin atau User</p>
@endsection

@section('content')
    <div class="text-center p-3">
        <p class="mb-4">
            Selamat datang! Pilih Role Anda untuk melanjutkan ke halaman login:
        </p>

        <div class="d-grid gap-3">
            {{-- TOMBOL ADMIN --}}
            <a href="{{ route('login', ['role' => 'admin']) }}" 
               class="btn btn-primary-custom w-100 fw-bold py-3 shadow">
                Masuk sebagai Admin
            </a>

            {{-- TOMBOL USER --}}
            <a href="{{ route('login', ['role' => 'user']) }}" 
               class="btn btn-secondary-color w-100 fw-bold py-3 shadow">
                Masuk sebagai User
            </a>
        </div>
    </div>
@endsection
