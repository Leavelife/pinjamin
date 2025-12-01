@extends('layouts.app')

@section('content')
<style>
    :root {
        --color-primary-dark: #308AA5;
        --color-primary: #3AA6B9;
        --color-background: #EAF9F9;
        --color-card: #C5E9EE;
        --color-text-dark: #333;
        --color-text-light: #555;
    }

    body {
        background: var(--color-background) !important;
    }

    .edit-profile-container {
        max-width: 600px;
        margin: 25px auto;
        padding: 10px;
        text-align: center;
    }

    .edit-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--color-text-dark);
        margin-bottom: 20px;
    }

    .edit-box {
        background: var(--color-card);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    .upload-wrapper {
        border: 2px dashed #8ec8d3;
        padding: 40px 20px;
        border-radius: 20px;
        cursor: pointer;
        background: #dff7fa;
        transition: .2s;
    }
    .upload-wrapper:hover {
        background: #e7fcff;
        border-color: var(--color-primary-dark);
    }

    .upload-wrapper i {
        font-size: 40px;
        color: var(--color-primary-dark);
        margin-bottom: 10px;
    }

    .upload-preview {
        display: none;
        margin-top: 10px;
        text-align: center;
    }
    .upload-preview img {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--color-primary-dark);
    }

    .input-box {
        text-align: left;
        margin-bottom: 18px;
    }

    .input-box label {
        font-size: 13px;
        font-weight: 600;
        color: var(--color-text-dark);
        display: block;
        margin-bottom: 5px;
    }

    .input-field {
        width: 100%;
        background: #fff;
        padding: 12px 14px;
        border-radius: 12px;
        border: 1.3px solid #9ec8d0;
        font-size: 14px;
        transition: .2s;
    }
    .input-field:focus {
        border-color: var(--color-primary-dark);
        outline: none;
    }

    .tips-box {
        background: #e4f4f7;
        border-left: 5px solid var(--color-primary-dark);
        padding: 12px;
        border-radius: 12px;
        text-align: left;
        font-size: 13px;
        margin-top: 10px;
        color: var(--color-text-dark);
    }

    .save-btn {
        width: 100%;
        padding: 12px;
        background: var(--color-primary-dark);
        border-radius: 15px;
        color: white;
        font-weight: 600;
        font-size: 15px;
        border: none;
        cursor: pointer;
        transition: .2s;
        margin-top: 20px;
    }
    .save-btn:hover {
        background: var(--color-primary);
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

@if($user)
<div class="edit-profile-container">

    <h2 class="edit-title">Edit Profil</h2>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="edit-box">
        @csrf

        {{-- AVATAR UPLOAD --}}
        <label for="avatar" class="upload-wrapper" id="uploadArea">
            <i class="fa-solid fa-upload"></i>
            <p>Klik untuk upload foto</p>
            <small style="color: var(--color-text-light)">PNG, JPG maksimal 5MB</small>
        </label>

        <input type="file" id="avatar" name="avatar" hidden accept="image/*">

        {{-- Preview Foto --}}
        <div class="upload-preview" id="previewBox">
            <img id="previewImage" alt="Preview Avatar">
        </div>

        {{-- INPUT NAMA --}}
        <div class="input-box">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="input-field"
                   value="{{ old('name', $user->name ?? '') }}" required>
        </div>
        
        {{-- EMAIL --}}
        <div class="input-box">
            <label>Email</label>
            <input type="email" name="email" class="input-field"
            value="{{ old('email', $user->email ?? '') }}" required>
        </div>

        {{-- PROGRAM STUDI --}}
        <div class="input-box">
            <label>Program Studi</label>
            <input type="text" name="prodi" class="input-field"
                   value="{{ old('prodi', $user->prodi ?? '') }}" required>
        </div>

        {{-- NOMOR HP --}}
        <div class="input-box">
            <label>Nomor HP</label>
            <input type="text" name="no_hp" class="input-field"
                   value="{{ old('no_hp', $user->no_hp ?? '') }}" required>
        </div>

        {{-- TIPS --}}
        <div class="tips-box">
            <b><i class="fa-solid fa-lightbulb"></i> Tips</b><br>
            Periksa ulang data yang Anda isi. Pastikan semua informasi sudah benar.
        </div>

        <button type="submit" class="save-btn">Simpan</button>
    </form>
</div>
@else
    <div style="text-align: center; padding: 50px; color: #555;">
        <p>Silakan <a href="{{ route('login') }}">login</a> untuk melanjutkan</p>
    </div>
@endif

{{-- PREVIEW SCRIPT --}}
<script>
    const fileInput = document.getElementById('avatar');
    const previewBox = document.getElementById('previewBox');
    const previewImage = document.getElementById('previewImage');
    const uploadArea = document.getElementById('uploadArea');

    if(uploadArea) {
        uploadArea.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                previewImage.src = URL.createObjectURL(file);
                previewBox.style.display = 'block';
            }
        });
    }
</script>

@endsection
