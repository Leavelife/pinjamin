@extends('layouts.app')

@section('content')

<style>
    .dashboard-box {
        background: white;
        border-radius: 20px;
        padding: 40px 30px;
        max-width: 950px;
        margin: auto;
        box-shadow: 0px 4px 15px rgba(0,0,0,0.06);
    }

    .title-section h2 {
        font-weight: 700;
        color: #1A1A1A;
    }

    .menu-wrapper {
        margin-top: 40px;
        gap: 25px;
    }

    .menu-option {
        background: linear-gradient(135deg, #308AA5, #2FA7B3);
        border-radius: 25px;
        padding: 45px 25px;
        text-align: center;
        color: white;
        transition: 0.25s ease;
        cursor: pointer;
    }

    .menu-option:hover {
        transform: scale(1.03);
    }

    .icon-circle {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        margin-bottom: 15px;
    }

    .icon-circle i {
        font-size: 40px;
        color: #2FA7B3;
    }

    .tips-box {
        background: #CDE6EB;
        padding: 20px 25px;
        border-radius: 14px;
        margin-top: 50px;
        display: flex;
        align-items: center;
        gap: 12px;
        text-align: center;
    }

    .tips-icon {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        border: 2px solid #2A7E8A;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #2A7E8A;
        font-size: 13px;
    }
</style>

<div class="dashboard-box">

    <div class="text-center title-section">
        <h2>Halo, {{ auth()->user()->name }}!</h2>
        <p>Selamat datang di dashboard Pinjam.in</p>
        <p class="mt-3" style="font-size: 14px;">Silahkan pilih menu yang Anda inginkan:</p>
    </div>

    <div class="row justify-content-center menu-wrapper">
        <div class="col-md-4 col-10">
            <a href={{ route('items.index') }} class="menu-link">
                <div class="menu-option">
                    <div class="icon-circle">
                        <i class="bi bi-search"></i>
                    </div>
                    <h5>Pinjam Barang</h5>
                    <p>Cari & pinjam barang</p>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-10">
            <a href="/barang/create" class="menu-link">
                <div class="menu-option">
                    <div class="icon-circle">
                        <i class="bi bi-plus-lg"></i>
                    </div>
                    <h5>Tawarkan Barang</h5>
                    <p>Upload dan bagikan</p>
                </div>
            </a>
        </div>
    </div>

    <div class="tips-box mt-5">
        <div class="tips-icon">
            <i class="bi bi-lightbulb"></i>
        </div>
        <p class="m-0">
             Tips :
             Pastikan barang yang dipinjam dikembalikan tepat waktu untuk menjaga kepercayaan komunitas.
        </p>
    </div>

</div>

@endsection
