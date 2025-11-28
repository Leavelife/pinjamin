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
            <img src="{{ $barang->gambar ?? asset('images/default-book.png') }}" alt="{{ $barang->nama }}" class="max-w-xs shadow-xl rounded-lg w-full object-cover">
        </div>
        
        {{-- Kolom Kanan: Detail & Aksi --}}
        <div class="md:w-2/3 w-full">
            
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-3xl font-bold text-gray-800">{{ $barang->nama }}</h1>
                {{-- Status --}}
                <span class="inline-block px-4 py-1 text-sm font-semibold rounded-full 
                    @if($barang->status == 'Tersedia') bg-green-200 text-green-800 
                    @else bg-red-200 text-red-800 @endif
                ">
                    {{ $barang->status }}
                </span>
            </div>

            {{-- Deskripsi --}}
            <p class="mt-2 text-gray-600 mb-6 leading-relaxed">
                {{ $barang->deskripsi }}
            </p>

            {{-- Detail Pemilik & Peminjaman Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                {{-- Informasi Pemilik --}}
                <div class="p-4 bg-teal-50/50 rounded-lg border border-teal-100">
                    <h3 class="text-lg font-semibold mb-2 text-teal-700">Informasi pemilik</h3>
                    <ul class="text-sm space-y-1 text-gray-600">
                        <li><i class="fas fa-user mr-2"></i><strong>Nama:</strong> {{ $barang->owner->name }}</li>
                        <li><i class="fas fa-building mr-2"></i><strong>Institusi:</strong> {{ $barang->owner->institution ?? 'Tidak Tersedia' }}</li>
                        <li><i class="fas fa-phone mr-2"></i><strong>Kontak:</strong> {{ $barang->owner->phone_number ?? '-' }}</li>
                        <li><i class="fas fa-envelope mr-2"></i><strong>Email:</strong> {{ $barang->owner->email }}</li>
                    </ul>
                </div>

                {{-- Informasi Peminjaman --}}
                <div class="p-4 bg-teal-50/50 rounded-lg border border-teal-100">
                    <h3 class="text-lg font-semibold mb-2 text-teal-700">Informasi peminjaman</h3>
                    <ul class="text-sm space-y-1 text-gray-600">
                        <li><i class="fas fa-calendar-alt mr-2"></i><strong>Estimasi Pinjam:</strong> 30 hari</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i><strong>Lokasi Pengambilan:</strong> {{ $barang->lokasi }}</li>
                        <li>(Estimasi Kembali: {{ $estimasiPengembalian }})</li>
                    </ul>
                </div>
            </div>

            {{-- Tombol Ajukan Peminjaman --}}
            <div class="mt-8">
                @auth
                    @if($barang->status == 'Tersedia')
                        <form action="{{ route('barang.ajukan', $barang) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-6 rounded-lg text-lg transition duration-300 shadow-md">
                                Ajukan peminjaman
                            </button>
                        </form>
                    @else
                        <button class="w-full bg-gray-400 text-white font-bold py-3 px-6 rounded-lg text-lg cursor-not-allowed" disabled>
                            {{ $barang->status }} (Tidak Dapat Dipinjam)
                        </button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="w-full block text-center bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-6 rounded-lg text-lg transition duration-300">
                        Login untuk Meminjam
                    </a>
                @endauth
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