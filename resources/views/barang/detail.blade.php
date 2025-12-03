{{-- resources/views/barang/detail.blade.php --}}

@extends('layouts.app') 

@section('content')

<div class="container my-5">
    {{-- Notifikasi Error/Peringatan --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-lg rounded-xl p-4 p-md-5">
        <div class="row g-4">
            {{-- Kolom Kiri: Gambar --}}
            <div class="col-md-4 text-center">
                <img src="{{ asset('storage/' . $barang->photo) }}" alt="{{ $barang->name }}" class="img-fluid rounded shadow-lg">
            </div>

            {{-- Kolom Kanan: Detail & Aksi --}}
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h1 class="h3 fw-bold">{{ strtoupper($barang->name) }}</h1>
                    {{-- Status --}}
                    <span class="badge 
                        {{ strtolower($barang->status) == 'tersedia' ? 'bg-success' : 'bg-danger' }} fs-6 py-2 px-3">
                        {{ ucfirst($barang->status) }}
                    </span>
                </div>

                {{-- Deskripsi --}}
                <p class="text-muted mb-4">
                    Deskripsi:
                    {{ $barang->description }}
                </p>

                {{-- Detail Pemilik --}}
                <div class="card border-light bg-light mb-3">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-3">Informasi Pemilik</h5>
                        <ul class="list-unstyled mb-0">
                            <li><i class="fas fa-user me-2"></i><strong>Nama:</strong> {{ $barang->user->name }}</li>
                            <li><i class="fas fa-phone me-2"></i><strong>Kontak:</strong> {{ $barang->user->no_hp ?? 'kosong' }}</li>
                            <li><i class="fas fa-envelope me-2"></i><strong>Email:</strong> {{ $barang->user->email }}</li>
                        </ul>
                    </div>
                </div>

                @if(auth()->id() !== $barang->user_id && strtolower($barang->status) === 'tersedia')
                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                        Pinjam Barang
                    </button>
                @endif

                {{-- MODAL CHECKOUT --}}
                <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <form action="{{ route('loan.request', $barang->id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                            <h5 class="modal-title" id="checkoutModalLabel">Peminjaman: {{ $barang->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                            {{-- Gambar Barang --}}
                            <div class="text-center mb-3">
                                <img src="{{ asset('storage/' . $barang->photo) }}" alt="{{ $barang->name }}" class="img-fluid rounded shadow-sm" style="max-height:200px;">
                            </div>

                            {{-- Tanggal Pinjam --}}
                            <div class="mb-3">
                                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required>
                            </div>

                            {{-- Tanggal Kembali --}}
                            <div class="mb-3">
                                <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                                <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" required>
                            </div>

                            </div>

                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- MODAL NOTIFIKASI SUKSES --}}
@if(session('loan_submitted'))
<div id="successModal" class="fixed inset-0 bg-teal-600 bg-opacity-95 flex items-center justify-center z-50 transition-opacity duration-300" style="opacity: 0; pointer-events: none;">
    <div class="relative max-w-2xl text-center p-20 text-white">
        
        {{-- Pastikan gambar muncul di background seperti di UI --}}
        <div class="absolute inset-0 opacity-20" style="background-image: url('{{ $barang->gambar ?? asset('images/default-book.png') }}'); background-size: contain; background-repeat: no-repeat; background-position: center;"></div>
        <div class="relative z-10">
            
            <h2 class="text-5xl font-extrabold mb-6 leading-tight">
                Peminjaman Anda <br> berhasil diajukan!
            </h2>
            
            <p class="text-xl mb-12">
                Mohon tunggu persetujuan dari pemilik barang. Anda akan menerima notifikasi jika permintaan telah disetujui.
            </p>
            
            <button onclick="closeModal()" class="bg-white text-teal-700 font-bold py-3 px-10 rounded-lg text-lg hover:bg-gray-100 transition duration-300 shadow-xl">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    // Pastikan modal hanya tampil setelah DOM selesai dimuat
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('successModal');
        // Tampilkan modal dengan delay kecil untuk transisi
        setTimeout(() => {
            modal.style.opacity = '1';
            modal.style.pointerEvents = 'auto';
        }, 100);
    });

    function closeModal() {
        const modal = document.getElementById('successModal');
        // Sembunyikan modal dengan transisi
        modal.style.opacity = '0';
        modal.style.pointerEvents = 'none';
        
        // Opsional: Hapus flag sesi setelah ditutup agar tidak muncul lagi pada refresh berikutnya
        // Dalam Laravel, ini biasanya ditangani secara otomatis oleh flash session, 
        // tapi ini bisa ditambahkan jika ingin kontrol lebih lanjut:
        // window.location.href = window.location.href; 
    }
</script>
@endif

@endsection