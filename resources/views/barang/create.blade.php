{{-- resources/views/barang/create.blade.php --}}

@extends('layouts.app')

@push('head')
<style>
    .form-container {
        background: white;
        border-radius: 20px;
        padding: 40px 30px;
        max-width: 750px;
        margin: auto;
        box-shadow: 0px 4px 15px rgba(0,0,0,0.06);
    }

    .form-title {
        font-weight: 700;
        color: #1A1A1A;
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
    }

    .form-label {
        font-weight: 600;
        color: #2D3748;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control, .form-select {
        border: 1px solid #CBD5E0;
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 15px;
        transition: all 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #3AA6B9;
        box-shadow: 0 0 0 3px rgba(58, 166, 185, 0.15);
        outline: none;
    }

    .upload-area {
        border: 2px dashed #CBD5E0;
        border-radius: 15px;
        padding: 40px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background: #F7FAFC;
    }

    .upload-area:hover {
        border-color: #3AA6B9;
        background: #EDF2F7;
    }

    .upload-area:hover .upload-icon {
        transform: translateY(-4px) scale(1.05);
        color: #3AA6B9;
    }

    .upload-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 15px;
        color: #A0AEC0;
        transition: all 0.3s;
    }

    #imagePreview {
        margin-bottom: 15px;
    }

    #previewImg {
        max-width: 100%;
        max-height: 300px;
        border-radius: 10px;
        object-fit: cover;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .btn-submit {
        background: #3AA6B9;
        border: none;
        border-radius: 12px;
        padding: 14px 30px;
        color: white;
        font-weight: 600;
        font-size: 16px;
        width: 100%;
        transition: all 0.3s;
        margin-top: 20px;
    }

    .btn-submit:hover {
        background: #2F8D9B;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(58, 166, 185, 0.3);
    }

    .tips-box {
        background: #CDE6EB;
        padding: 18px 22px;
        border-radius: 12px;
        margin-top: 25px;
        margin-bottom: 10px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .tips-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #2A7E8A;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #2A7E8A;
        font-size: 12px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .tips-box p {
        margin: 0;
        font-size: 14px;
        color: #2D3748;
        line-height: 1.5;
    }

    .error-text {
        color: #E53E3E;
        font-size: 13px;
        margin-top: 5px;
    }

    .auth-warning {
        background: #FED7D7;
        border: 1px solid #FC8181;
        color: #C53030;
        padding: 12px 20px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .auth-warning a {
        color: #C53030;
        font-weight: 700;
        text-decoration: underline;
    }

    .btn-disabled {
        background: #E2E8F0;
        color: #A0AEC0;
        cursor: not-allowed;
        border: none;
        border-radius: 12px;
        padding: 14px 30px;
        font-weight: 600;
        font-size: 16px;
        width: 100%;
    }

    .alert-success {
        background: #C6F6D5;
        border: 1px solid #9AE6B4;
        color: #22543D;
        padding: 14px 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }

    .alert-danger {
        background: #FED7D7;
        border: 1px solid #FC8181;
        color: #C53030;
        padding: 14px 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }

    .alert-icon {
        font-size: 18px;
    }

    /* Modal Notifikasi */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        animation: fadeIn 0.3s ease;
    }

    .modal-content-success {
        background: linear-gradient(135deg, #4FC3DC, #3AA6B9);
        border-radius: 20px;
        padding: 40px 35px;
        max-width: 400px;
        width: 90%;
        text-align: center;
        color: white;
        animation: slideUp 0.3s ease;
    }

    .modal-content-success h3 {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .modal-content-success p {
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 25px;
        opacity: 0.95;
    }

    .modal-btn {
        background: white;
        color: #3AA6B9;
        border: none;
        border-radius: 10px;
        padding: 12px 40px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .modal-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { 
            opacity: 0;
            transform: translateY(30px);
        }
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')

{{-- Modal Success Notification --}}
@if(session('success'))
<div class="modal-overlay" id="successModal">
    <div class="modal-content-success">
        <h3>Penawaran barang berhasil diajukan!</h3>
        <p>Terima kasih telah menawarkan barangmu untuk dipinjam! Cek notifikasi untuk melihat siapa yang akan meminjam barang</p>
        <button class="modal-btn" onclick="closeModal()">Tutup</button>
    </div>
</div>
@endif

<div class="form-container">
    <h2 class="form-title">Tawarkan Barang</h2>
    
    {{-- Notifikasi Success --}}
    @if(session('success'))
        <div class="alert-success">
            <i class="bi bi-check-circle-fill alert-icon"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Notifikasi Error --}}
    @if(session('error'))
        <div class="alert-danger">
            <i class="bi bi-exclamation-triangle-fill alert-icon"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Notifikasi Validation Errors --}}
    @if($errors->any())
        <div class="alert-danger">
            <i class="bi bi-exclamation-triangle-fill alert-icon"></i>
            <div>
                <strong>Terdapat kesalahan:</strong>
                <ul class="mb-0 mt-1" style="padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    
    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 1. Upload Foto --}}
        <div class="mb-4">
            <label class="form-label">Foto Barang <span class="text-danger">*</span></label>
            <div class="upload-area" id="uploadArea" onclick="document.getElementById('photo_input').click()">
                <input type="file" name="photo" id="photo_input" accept="image/png, image/jpeg, image/jpg" class="d-none" onchange="previewImage(this)">
                
                <div id="imagePreview" style="display: none;">
                    <img id="previewImg" src="" alt="Preview">
                </div>

                <svg class="upload-icon" id="uploadIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>

                <p class="mb-1" id="uploadText" style="font-weight: 600; color: #4A5568;">Klik untuk upload foto</p>
                <p class="mb-0" style="font-size: 13px; color: #A0AEC0;">PNG, JPG, JPEG hingga 5MB</p>
            </div>
            @error('photo')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        {{-- 2. Nama Barang --}}
        <div class="mb-4">
            <label for="name" class="form-label">Nama Barang <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control"
                placeholder="Contoh: Kamera Canon EOS M50" value="{{ old('name') }}" required>
            @error('name')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        {{-- 3. Kategori --}}
        <div class="mb-4">
            <label for="category" class="form-label">Kategori Barang <span class="text-danger">*</span></label>
            <select name="category" id="category" class="form-select" required>
                <option value="" disabled selected>Pilih kategori</option>

                @foreach ($kategoris ?? ['Elektronik', 'Buku', 'Peralatan Olahraga', 'Jasa', 'Lain-lain'] as $cat)
                    <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>
                @endforeach

            </select>
            @error('category')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        {{-- 4. Deskripsi --}}
        <div class="mb-4">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="form-control"
                    placeholder="Tulis deskripsi barang di sini...">{{ old('description') }}</textarea>
            @error('description')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        {{-- 5. Lokasi Pengambilan --}}
        <div class="mb-4">
            <label for="pickup_address" class="form-label">Lokasi Pengambilan <span class="text-danger">*</span></label>
            <input type="text" name="pickup_address" id="pickup_address" class="form-control"
                placeholder="Contoh: Gedung Teknik Informatika B302" value="{{ old('pickup_address') }}">
            @error('pickup_address')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        {{-- 6. Jumlah Barang --}}
        <div class="mb-4">
            <label for="qty" class="form-label">Jumlah Barang <span class="text-danger">*</span></label>
            <input type="number" name="qty" id="qty" class="form-control"
                placeholder="1" min="1" value="{{ old('qty', 1) }}">
            @error('qty')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        {{-- 7. Kondisi Barang --}}
        <div class="mb-4">
            <label for="condition" class="form-label">Kondisi Barang <span class="text-danger">*</span></label>
            <select name="condition" id="condition" class="form-select">
                <option value="" disabled selected>Pilih kondisi</option>
                <option value="baru" {{ old('condition') == 'baru' ? 'selected' : '' }}>Baru</option>
                <option value="bekas" {{ old('condition') == 'bekas' ? 'selected' : '' }}>Bekas</option>
                <option value="baik" {{ old('condition') == 'baik' ? 'selected' : '' }}>Baik</option>
            </select>
            @error('condition')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Submit --}}
        <div>
            @guest
                <div class="auth-warning">
                    Anda harus <a href="{{ route('login') }}">Login</a> untuk dapat menambahkan barang.
                </div>
                <button type="button" class="btn-disabled" disabled>Tambahkan Barang</button>
            @else
                <button type="submit" class="btn-submit">Tambahkan Barang</button>
            @endguest
        </div>
    </form>

</div>

@endsection

@push('scripts')
<script>
    // Preview gambar sebelum upload
    function previewImage(input) {
        const file = input.files[0];
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const uploadIcon = document.getElementById('uploadIcon');
        const uploadText = document.getElementById('uploadText');
        const uploadArea = document.getElementById('uploadArea');

        if (file) {
            // Validasi ukuran file (5MB = 5 * 1024 * 1024 bytes)
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 5MB.');
                input.value = '';
                return;
            }

            // Validasi tipe file
            const validTypes = ['image/png', 'image/jpeg', 'image/jpg'];
            if (!validTypes.includes(file.type)) {
                alert('Format file tidak didukung! Hanya PNG, JPG, dan JPEG yang diizinkan.');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
                uploadIcon.style.display = 'none';
                uploadText.textContent = 'Klik untuk mengganti foto';
                uploadArea.style.borderColor = '#3AA6B9';
                uploadArea.style.background = '#EDF2F7';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            uploadIcon.style.display = 'block';
            uploadText.textContent = 'Klik untuk upload foto';
            uploadArea.style.borderColor = '#CBD5E0';
            uploadArea.style.background = '#F7FAFC';
        }
    }

    // Close modal function
    function closeModal() {
        const modal = document.getElementById('successModal');
        if (modal) {
            modal.style.animation = 'fadeOut 0.3s ease';
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }
    }

    // Close modal when clicking outside
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('successModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        }
    });
</script>

<style>
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
</style>
@endpush