@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="bg-white p-4 rounded shadow">
       <h3 class="mb-4 font-weight-bold text-center" style="color: #3AA6B9;">Daftar Notifikasi</h3>
        
        @if(isset($notifications) && $notifications->count() > 0)
            <ul class="list-group">
                @foreach($notifications as $n)
                    @php
                        // Logika yang lebih aman untuk mengambil payload JSON 'data'
                        // Untuk objek DatabaseNotification, 'data' akan selalu berupa array/json string
                        try {
                            // Jika $n adalah DatabaseNotification (model), gunakan properti 'data' yang sudah di-cast
                            $data = is_array($n->data) ? $n->data : json_decode($n->data, true); 
                            $data = is_array($data) ? $data : [];
                        } catch (\Exception $e) {
                            $data = ['title' => 'Error', 'message' => 'Data notifikasi tidak valid.'];
                        }
                        
                        $isRead = !is_null($n->read_at);
                        $link = $data['link'] ?? '#';
                        $title = $data['title'] ?? ($n->type ?? 'Notifikasi');
                        $message = $data['message'] ?? 'Tidak ada detail pesan.';

                        // Warna latar belakang berdasarkan status baca/belum baca
                        $bgColor = $isRead ? 'list-group-item-light text-muted' : 'list-group-item-primary bg-opacity-10'; 
                    @endphp
                    
                    <li class="list-group-item d-flex justify-content-between align-items-center mb-2 {{ $bgColor }} rounded shadow-sm">
                        <!-- Konten Notifikasi (Dapat Diklik) -->
                        <a href="{{ $link }}" class="text-decoration-none text-dark flex-grow-1">
                            <div class="d-flex w-100 justify-content-between">
                                <div class="fw-bold {{ $isRead ? 'text-secondary' : 'text-dark' }}">{{ $title }}</div>
                                <small class="text-muted ms-3">
                                    {{ isset($n->created_at) ? \Carbon\Carbon::parse($n->created_at)->diffForHumans() : '' }}
                                </small>
                            </div>
                            <div class="text-sm {{ $isRead ? 'text-secondary' : 'text-primary' }}">{{ $message }}</div>
                        </a>
                        
                        <!-- Tombol Mark as Read -->
                        @if (!$isRead && auth()->check())
                            <form action="{{ route('notifikasi.read', $n->id) }}" method="POST" class="ms-3">
                                @csrf
                                <!-- Metode POST tidak perlu spoofing method jika menggunakan POST -->
                                <button type="submit" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-check"></i> Baca
                                </button>
                            </form>
                        @endif
                    </li>
                @endforeach
            </ul>

            <!-- Tambahkan fitur tandai semua sudah dibaca -->
            <div class="mt-3 text-end">
                <a href="{{ route('notifikasi.markAllRead') }}" onclick="event.preventDefault(); document.getElementById('mark-all-form').submit();" class="btn btn-sm btn-outline-secondary">
                    Tandai Semua Sudah Dibaca
                </a>
                <form id="mark-all-form" action="{{ route('notifikasi.markAllRead') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>

        @else
            <div class="alert alert-info text-center" role="alert">
                <p class="mb-0">Belum ada notifikasi baru untuk Anda saat ini.</p>
            </div>
        @endif
    </div>
</div>
@endsection