@extends('layouts.app')

@section('content')
<style>
    .profile-container {
        max-width: 550px;
        margin: 40px auto;
        background: #b7dfe8;
        border-radius: 20px;
        padding: 40px 30px;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .profile-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: #e9f7fb;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto 15px;
        font-size: 40px;
        color: #4a4a4a;
    }

    .profile-name {
        font-size: 24px;
        font-weight: bold;
        color: #1f2d3d;
    }

    .profile-major {
        font-size: 16px;
        color: #4a4a4a;
        margin-bottom: 20px;
    }

    .info-card {
        background: white;
        padding: 22px;
        border-radius: 15px;
        text-align: left;
        margin: 0 auto 20px;
        width: 90%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .info-row {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
        font-size: 15px;
        color: #333;
    }

    .info-row i {
        margin-right: 12px;
        color: #2f6f78;
        width: 20px;
    }

    .edit-profile-link {
        margin-top: 10px;
        text-align: center;
        display: block;
        color: #2b4e69;
        font-weight: 600;
        text-decoration: none;
    }

    .stats-boxes {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin: 25px 0;
    }

    .stat-box {
        background: #d6eff6;
        width: 150px;
        padding: 18px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .stat-number {
        font-size: 26px;
        font-weight: 700;
        color: #1e3c4b;
    }

    .stat-label {
        font-size: 14px;
        color: #345;
    }

    .logout-btn {
        display: inline-block;
        margin-top: 15px;
        padding: 10px 25px;
        background: #0c3b46;
        color: white;
        border-radius: 25px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: 0.2s;
    }

    .logout-btn:hover {
        background: #06232a;
    }
</style>

<div class="profile-container">
    
    {{-- AVATAR BULAT --}}
    <div class="profile-avatar">
        <i class="fas fa-user"></i>
    </div>

    {{-- NAMA --}}
    <div class="profile-name">
        {{ $user->name }}
    </div>

    {{-- JURUSAN --}}
    <div class="profile-major">
        {{ $user->prodi ?? 'Program Studi Tidak Diketahui' }}
    </div>

    {{-- KOTAK INFORMASI --}}
    <div class="info-card">
        <div class="info-row">
            <i class="fas fa-envelope"></i>
            Email: {{ $user->email }}
        </div>

        <div class="info-row">
            <i class="fas fa-phone"></i>
            No. Hp: {{ $user->no_hp ?? 'belum ada' }}
        </div>


        <a href="{{ route('profile.edit.page') }}" class="edit-profile-link">
            <i class="fas fa-pen"></i> Edit profil
        </a>
    </div>

    {{-- STATISTIK --}}
    <div class="stats-boxes">
        <div class="stat-box">
            <div class="stat-number">{{ $totalDipinjam }}</div>
            <div class="stat-label">Barang dipinjam</div>
        </div>

        <div class="stat-box">
            <div class="stat-number">{{ $totalDipinjamkan }}</div>
            <div class="stat-label">Barang dipinjamkan</div>
        </div>
    </div>

    {{-- LOGOUT BUTTON --}}
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="logout-btn">Logout</button>
    </form>

</div>

@endsection
