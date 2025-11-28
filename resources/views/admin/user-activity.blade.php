@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #308AA5;
        --secondary: #3AA6B9;
        --light-bg: #EAF9F9;
        --card-bg: #C5E9EE;
    }

    body {
        background: var(--light-bg);
        font-family: 'Poppins', sans-serif;
    }

    .container-activity {
        max-width: 1000px;
        margin: 0 auto;
        padding: 2rem;
    }

    .back-btn {
        color: var(--primary);
        text-decoration: none;
        margin-bottom: 2rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
    }

    .user-header {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .user-header h1 {
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .user-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .info-item {
        color: #666;
    }

    .info-item strong {
        color: var(--primary);
    }

    .activity-table {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: var(--light-bg);
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--primary);
        border-bottom: 2px solid var(--card-bg);
    }

    td {
        padding: 1rem;
        border-bottom: 1px solid #EEE;
    }

    tbody tr:hover {
        background: #F8FFFE;
    }

    .badge {
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-success {
        background: #D4EDDA;
        color: #155724;
    }

    .badge-pending {
        background: #FFF3CD;
        color: #856404;
    }
</style>

<div class="container-activity">
    <a href="{{ route('admin.dashboard') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>

    <div class="user-header">
        <h1>{{ $user->name }}</h1>
        <div class="user-info">
            <div class="info-item">
                <strong>Email:</strong> {{ $user->email }}
            </div>
            <div class="info-item">
                <strong>Program Studi:</strong> {{ $user->program_studi }}
            </div>
            <div class="info-item">
                <strong>No. HP:</strong> {{ $user->phone }}
            </div>
            <div class="info-item">
                <strong>Total Peminjaman:</strong> {{ $peminjamans->total() }}
            </div>
        </div>
    </div>

    <div class="activity-table">
        <h2 style="color: var(--primary); margin-bottom: 1.5rem;">Riwayat Peminjaman</h2>

        @if($peminjamans->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjamans as $pinjam)
                        <tr>
                            <td>{{ $pinjam->barang->name }}</td>
                            <td>{{ $pinjam->quantity }}x</td>
                            <td>{{ $pinjam->created_at->format('d/m/Y') }}</td>
                            <td>{{ $pinjam->return_date ? $pinjam->return_date->format('d/m/Y') : '-' }}</td>
                            <td>
                                <span class="badge badge-{{ strtolower($pinjam->status) }}">
                                    {{ ucfirst($pinjam->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 1.5rem;">
                {{ $peminjamans->links() }}
            </div>
        @else
            <p style="text-align: center; color: #999;">Tidak ada riwayat peminjaman</p>
        @endif
    </div>
</div>

@endsection