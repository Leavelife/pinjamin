@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    :root {
        --color-primary-dark: #308AA5;
        --color-primary: #3AA6B9;
        --color-background: #EAF9F9;
        --color-card: #C5E9EE;
        --color-text-dark: #333;
        --color-text-light: #555;
    }

    body { background: var(--color-background); }

    .profile-page-content { max-width: 700px; margin: 20px auto; padding: 10px; }
    .profile-container { text-align: center; }

    .profile-avatar { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border:2px solid var(--color-text-light); margin-bottom:15px; }
    .profile-name { font-size: 24px; font-weight: 700; color: var(--color-text-dark); margin:0; }
    .profile-study { font-size:16px; color: var(--color-text-light); margin-top:5px; }

    .profile-info-box { background: var(--color-card); border-radius: 20px; padding:25px 30px; margin-bottom:30px; display:inline-block; min-width:300px; }
    .info-row { display:flex; align-items:center; justify-content:flex-start; margin-bottom:12px; font-size:15px; color: var(--color-text-dark); font-weight:500; }
    .info-row i { color: var(--color-primary-dark); margin-right: 15px; font-size:18px; width:20px; text-align:center; }
    .info-row span { flex-grow:1; text-align:left; }
    .edit-profile-link { display:flex; align-items:center; justify-content:center; font-size:14px; color:var(--color-text-light); font-weight:500; text-decoration:none; transition:.2s; margin-top:10px; padding: 8px 16px; border-radius: 10px; }
    .edit-profile-link i { font-size:12px; margin-right:5px; }
    .edit-profile-link:hover { color: var(--color-primary); background: rgba(58, 166, 185, 0.1); }

    .stat-card { background: var(--color-card); border-radius: 20px; padding:20px; width:150px; text-align:center; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
    .stat-card-number { font-size:36px; font-weight:700; color: var(--color-primary-dark); margin-bottom:5px; }
    .stat-card-label { font-size:14px; color: var(--color-text-light); line-height:1.2; }

    .stats-container { display:flex; justify-content:center; gap:20px; margin-bottom:40px; flex-wrap: wrap; }

    .logout-button { background: var(--color-card); border:none; color: var(--color-text-light); font-weight:500; font-size:14px; cursor:pointer; padding:10px 30px; border-radius:15px; display:flex; align-items:center; gap:8px; margin:0 auto; box-shadow:0 2px 5px rgba(0,0,0,0.1); transition:.2s; }
    .logout-button i { color: var(--color-text-light); font-size:16px; }
    .logout-button:hover { background: var(--color-primary); color:white; }
    .logout-button:hover i { color:white; }

    .edit-box { background: var(--color-card); border-radius: 20px; padding:25px; box-shadow:0 4px 10px rgba(0,0,0,0.1); margin-bottom:30px; max-width:600px; margin:25px auto; text-align:center; }
    .input-box { text-align:left; margin-bottom:18px; }
    .input-box label { font-size:13px; font-weight:600; color:var(--color-text-dark); display:block; margin-bottom:5px; }
    .input-field { width:100%; background:#fff; padding:12px 14px; border-radius:12px; border:1.3px solid #9ec8d0; font-size:14px; }
    .input-field:focus { border-color: var(--color-primary-dark); outline:none; }
    .save-btn { width:100%; padding:12px; background: var(--color-primary-dark); border-radius:15px; color:white; font-weight:600; font-size:15px; border:none; cursor:pointer; margin-top:20px; transition:.2s; }
    .save-btn:hover { background: var(--color-primary); }
    .upload-wrapper { border:2px dashed #8ec8d3; padding:40px 20px; border-radius:20px; cursor:pointer; background:#dff7fa; transition:.2s; }
    .upload-wrapper:hover { background:#e7fcff; border-color: var(--color-primary-dark); }
    .upload-wrapper i { font-size:40px; color: var(--color-primary-dark); margin-bottom:10px; }
    .upload-preview { display:none; margin-top:10px; text-align:center; }
    .upload-preview img { width:110px; height:110px; border-radius:50%; object-fit:cover; border:3px solid var(--color-primary-dark); }
</style>

<div class="profile-page-content">

    @if(!$user)
        {{-- JIKA BELUM LOGIN: TAMPIL FORM EDIT PROFIL TANPA DATA --}}
        <h2 style="text-align:center; margin-bottom:20px;">Lengkapi Profil Anda</h2>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="edit-box">
            @csrf
            {{-- AVATAR --}}
            <label for="avatar" class="upload-wrapper" id="uploadArea">
                <i class="fa-solid fa-plus"></i>
                <p>Klik untuk upload foto</p>
                <small style="color: var(--color-text-light)">PNG, JPG maksimal 5MB</small>
            </label>
            <input type="file" id="avatar" name="avatar" hidden accept="image/*">
            <div class="upload-preview" id="previewBox">
                <img id="previewImage" alt="Preview Avatar">
            </div>

            {{-- NAMA --}}
            <div class="input-box">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="input-field" required>
            </div>

            {{-- PROGRAM STUDI --}}
            <div class="input-box">
                <label>Program Studi</label>
                <input type="text" name="program_studi" class="input-field" required>
            </div>

            {{-- LOKASI --}}
            <div class="input-box">
                <label>Lokasi</label>
                <input type="text" name="location" class="input-field" required>
            </div>

            {{-- EMAIL --}}
            <div class="input-box">
                <label>Email</label>
                <input type="email" name="email" class="input-field" required>
            </div>

            {{-- NOMOR HP --}}
            <div class="input-box">
                <label>Nomor HP</label>
                <input type="text" name="phone" class="input-field" required>
            </div>

            <button type="submit" class="save-btn">Simpan Profil</button>
        </form>

    @elseif(empty($user->program_studi) || empty($user->location) || empty($user->phone))
        {{-- JIKA SUDAH LOGIN TAPI PROFIL BELUM LENGKAP: TAMPIL FORM EDIT --}}
        <h2 style="text-align:center; margin-bottom:20px;">Lengkapi Profil Anda</h2>
        <form action="{{ route('profile.edit') }}" method="POST" enctype="multipart/form-data" class="edit-box">
            @csrf
            {{-- AVATAR --}}
            <label for="avatar" class="upload-wrapper" id="uploadArea">
                <i class="fa-solid fa-plus"></i>
                <p>Klik untuk upload foto</p>
                <small style="color: var(--color-text-light)">PNG, JPG maksimal 5MB</small>
            </label>
            <input type="file" id="avatar" name="avatar" hidden accept="image/*">
            <div class="upload-preview" id="previewBox">
                <img id="previewImage" alt="Preview Avatar">
            </div>

            {{-- NAMA --}}
            <div class="input-box">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="input-field" value="{{ old('name', $user->name ?? '') }}" required>
            </div>

            {{-- PROGRAM STUDI --}}
            <div class="input-box">
                <label>Program Studi</label>
                <input type="text" name="program_studi" class="input-field" value="{{ old('program_studi', $user->program_studi ?? '') }}" required>
            </div>

            {{-- LOKASI --}}
            <div class="input-box">
                <label>Lokasi</label>
                <input type="text" name="location" class="input-field" value="{{ old('location', $user->location ?? '') }}" required>
            </div>

            {{-- EMAIL --}}
            <div class="input-box">
                <label>Email</label>
                <input type="email" name="email" class="input-field" value="{{ old('email', $user->email ?? '') }}" required>
            </div>

            {{-- NOMOR HP --}}
            <div class="input-box">
                <label>Nomor HP</label>
                <input type="text" name="phone" class="input-field" value="{{ old('phone', $user->phone ?? '') }}" required>
            </div>

            <button type="submit" class="save-btn">Simpan Profil</button>
        </form>

    @else
        {{-- PROFIL SUDAH LENGKAP: TAMPIL DATA PROFIL --}}
        <div class="profile-container">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="profile-avatar">
            @else
                <img src="https://via.placeholder.com/100?text=Profile" alt="Avatar" class="profile-avatar">
            @endif

            <h1 class="profile-name">{{ $user->name }}</h1>
            <p class="profile-study">{{ $user->program_studi }}</p>

            <div class="profile-info-box">
                <div class="info-row"><i class="fas fa-envelope"></i><span>{{ $user->email }}</span></div>
                <div class="info-row"><i class="fas fa-mobile-alt"></i><span>{{ $user->phone }}</span></div>
                <div class="info-row"><i class="fas fa-map-marker-alt"></i><span>{{ $user->location }}</span></div>
                <a href="{{ route('profile.edit') }}" class="edit-profile-link"><i class="fas fa-pencil-alt"></i> Edit Profil</a>
            </div>

            <div class="stats-container">
                <div class="stat-card"><div class="stat-card-number">5</div><div class="stat-card-label">Barang dipinjam</div></div>
                <div class="stat-card"><div class="stat-card-number">8</div><div class="stat-card-label">Barang dipinjamkan</div></div>
            </div>

            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    @endif

</div>

<script>
    const fileInput = document.getElementById('avatar');
    const previewBox = document.getElementById('previewBox');
    const previewImage = document.getElementById('previewImage');
    const uploadArea = document.getElementById('uploadArea');

    if(uploadArea) {
        uploadArea.addEventListener('click', () => fileInput.click());
    }
    if(fileInput) {
        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if(file) {
                previewImage.src = URL.createObjectURL(file);
                previewBox.style.display = 'block';
            }
        });
    }
</script>

@endsection


