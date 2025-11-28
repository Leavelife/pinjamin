@extends('layouts.app')

@section('content')

<style>
    .page-title {
        font-weight: 700;
        color: #1A1A1A;
        margin-bottom: 25px;
    }

    /* Search Box (TINGGI DIPERKECIL) */
    .search-box {
        background: #C8E6EE;
        padding: 4px 18px;        /* lebih pendek */
        border-radius: 35px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 900px;
        margin: auto;
    }

    .search-box input {
        border: none;
        background: transparent;
        width: 100%;
        outline: none;
        height: 32px;             /* tinggi input lebih kecil */
        font-size: 14px;
        color: #1a1a1a;
    }

    .search-icons i {
        font-size: 20px;          /* ikon ikut kecil */
        color: #1a1a1a;
        margin-left: 12px;
        cursor: pointer;
    }

    .filter-box {
        background: #B7DEE8;
        padding: 30px;
        border-radius: 20px;
        margin-top: 30px;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
    }

    .filter-title {
        font-weight: 600;
        color: #1A1A1A;
    }

    .filter-btn {
        background: #2FA7B3;
        color: white;
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        margin-right: 10px;
        margin-top: 10px;
        cursor: pointer;
    }

    .filter-btn:hover {
        opacity: .85;
    }
</style>

<div class="text-center">
    <h2 class="page-title">Pinjam barang</h2>
</div>

<!-- SEARCH BAR -->
<div class="search-box">
    <input type="text" placeholder="Cari barang atau buku....">
    <div class="search-icons">
        <i class="bi bi-search"></i>

    </div>
</div>

<!-- FILTER SECTION -->
<div class="filter-box mt-4">

    <p class="filter-title">Jenis barang</p>

    <div class="mb-3">
        <button class="filter-btn">Buku</button>
        <button class="filter-btn">Alat</button>
        <button class="filter-btn">Pakaian</button>
        <button class="filter-btn">Elektronik</button>
    </div>

    <p class="filter-title mt-4">Status</p>

    <div>
        <button class="filter-btn">Tersedia</button>
        <button class="filter-btn">Dipinjam</button>
        <button class="filter-btn">Tidak tersedia</button>
    </div>

</div>

@endsection
