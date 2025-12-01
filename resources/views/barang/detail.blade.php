{{-- resources/views/barang/detail.blade.php --}}

@extends('layouts.app') 

@section('content')

<div class="container mx-auto p-4 max-w-4xl">
    
    {{-- Notifikasi Error/Peringatan di atas --}}
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg border border-red-300">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row items-start bg-white p-6 rounded-xl shadow-lg">
        
        {{-- Kolom Kiri: Gambar --}}
        <div class="md:w-1/3 w-full flex justify-center mb-6 md:mb-0 md:mr-6">
            <img src="{{ asset(path: 'storage/'. $barang->photo) }}" alt="{{ $barang->name }}" class="max-w-xs shadow-xl rounded-lg w-full object-cover">
        </div>
        
        {{-- Kolom Kanan: Detail & Aksi --}}
        <div class="md:w-2/3 w-full">
            
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-3xl font-bold text-gray-800">{{ $barang->name }}</h1>
                {{-- Status --}}
                <span class="inline-block px-4 py-1 text-sm font-semibold rounded-full 
                    {{ strtolower($barang->status) == 'tersedia' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                    {{ ucfirst($barang->status) }}
                </span>

            </div>
            {{-- Deskripsi --}}
            <p class="mt-2 px-4 text-gray-600 mb-6 leading-relaxed">
                {{ $barang->description }}
            </p>

            {{-- Detail Pemilik & Peminjaman Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                {{-- Informasi Pemilik --}}
                <div class="p-4 bg-teal-50/50 rounded-lg border border-teal-100">
                    <h3 class="text-lg font-semibold mb-2 text-teal-700">Informasi pemilik</h3>
                    <ul class="text-sm space-y-1 text-gray-600">
                        <li><i class="fas fa-user mr-2"></i><strong>Nama:</strong> {{ $barang->user->name }}</li>
                        <li><i class="fas fa-phone mr-2"></i><strong>Kontak:</strong> {{ $barang->user->no_hp ?? 'kosong' }}</li>
                        <li><i class="fas fa-envelope mr-2"></i><strong>Email:</strong> {{ $barang->user->email }}</li>
                    </ul>
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