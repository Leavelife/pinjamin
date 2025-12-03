@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="bg-white p-4 rounded shadow">
       <h3 class="mb-4 font-weight-bold text-center" style="color: #3AA6B9;">Daftar Notifikasi</h3>
        
        @if(isset($notifications) && $notifications->count() > 0)
            <ul class="list-group">
                @forelse($notifications as $notification)
                    <div class="alert alert-info d-flex justify-content-between align-items-start">
                        <div>
                            <strong>{{ $notification->title }}</strong><br>
                            <small class="text-muted">{{ $notification->created_at->format('d/m/Y H:i') }}</small>
                            <p>{{ $notification->message }}</p>
                        </div>
                        <div>
                            {{-- Bisa ditambahkan link ke related resource --}}
                            @if($notification->related_type && $notification->related_id)
                                <a href="{{ route($notification->related_type . '.show', $notification->related_id) }}" class="btn btn-sm btn-primary">Lihat</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted">Belum ada notifikasi.</p>
                @endforelse
            </ul>

        @else
            <div class="alert alert-info text-center" role="alert">
                <p class="mb-0">Belum ada notifikasi baru untuk Anda saat ini.</p>
            </div>
        @endif
    </div>
</div>
@endsection