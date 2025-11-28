@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary: #308AA5;
        --primary-dark: #246b80;
        --secondary: #3AA6B9;
        --danger: #FF6B6B;
        --warning: #FFD700;
        --success: #51CF66;
        --light-bg: #F0F8FA;
        --card-bg: #E0F0F5;
        --white: #FFFFFF;
        --text-dark: #1a1a1a;
        --text-light: #666666;
        --border-color: #D4E8ED;
    }

    body {
        background: linear-gradient(135deg, var(--light-bg) 0%, #E8F4F8 100%);
        font-family: 'Poppins', sans-serif;
        min-height: 100vh;
        color: var(--text-dark);
    }

    .admin-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 3rem 2rem;
    }

    /* Header Section */
    .admin-header {
        margin-bottom: 3rem;
        animation: slideDown 0.5s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .admin-header h1 {
        font-size: 2.8rem;
        color: var(--primary);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .admin-header p {
        color: var(--text-light);
        margin-top: 0.5rem;
        font-size: 1rem;
    }

    /* Alert */
    .alert {
        padding: 1.2rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        animation: slideDown 0.3s ease-out;
        border-left: 4px solid;
    }

    .alert-success {
        background: #D4EDDA;
        color: #155724;
        border-left-color: #28a745;
    }

    .alert i {
        font-size: 1.5rem;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: var(--white);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(48, 138, 165, 0.15);
    }

    .stat-card-content h3 {
        color: var(--text-light);
        font-size: 0.95rem;
        margin-bottom: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card-content .number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary);
        line-height: 1;
    }

    .stat-card-icon {
        font-size: 2.5rem;
        background: var(--light-bg);
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        color: var(--secondary);
    }

    /* Section Card */
    .section-card {
        background: var(--white);
        border-radius: 16px;
        padding: 2.5rem;
        margin-bottom: 3rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border-color);
        animation: slideDown 0.5s ease-out;
    }

    .section-title {
        font-size: 1.6rem;
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--card-bg);
    }

    .section-title i {
        font-size: 1.8rem;
        background: var(--light-bg);
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }

    /* Table Styling */
    .table-responsive {
        overflow-x: auto;
        border-radius: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: linear-gradient(135deg, var(--light-bg), var(--card-bg));
    }

    th {
        padding: 1.2rem;
        text-align: left;
        font-weight: 600;
        color: var(--primary);
        border-bottom: 2px solid var(--border-color);
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    td {
        padding: 1.2rem;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-dark);
    }

    tbody tr {
        transition: all 0.2s ease;
    }

    tbody tr:hover {
        background: var(--light-bg);
        box-shadow: inset 0 0 10px rgba(48, 138, 165, 0.05);
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    /* Badge */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
        min-width: 100px;
        text-align: center;
    }

    .badge-pending {
        background: #fff3cd;
        color: #856404;
    }

    .badge-approved {
        background: #d4edda;
        color: #155724;
    }

    .badge-rejected {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-blocked {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-active {
        background: #d4edda;
        color: #155724;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.8rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 0.6rem 1.2rem;
        border: none;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        white-space: nowrap;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-approve {
        background: linear-gradient(135deg, #51CF66, #40C057);
        color: white;
    }

    .btn-approve:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(81, 207, 102, 0.3);
    }

    .btn-reject {
        background: linear-gradient(135deg, #FF6B6B, #FF5252);
        color: white;
    }

    .btn-reject:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
    }

    .btn-block {
        background: linear-gradient(135deg, #FF6B6B, #FF5252);
        color: white;
    }

    .btn-unblock {
        background: linear-gradient(135deg, #51CF66, #40C057);
        color: white;
    }

    .btn-view {
        background: linear-gradient(135deg, var(--secondary), #2EACC4);
        color: white;
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(58, 166, 185, 0.3);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--card-bg);
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        color: var(--text-light);
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #999;
        font-size: 1rem;
    }

    /* Pagination */
    .pagination {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .pagination a,
    .pagination span {
        padding: 0.6rem 0.9rem;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        color: var(--primary);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .pagination a:hover {
        background: var(--light-bg);
    }

    .pagination .active span {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background-color: var(--white);
        padding: 2.5rem;
        border-radius: 16px;
        width: 90%;
        max-width: 800px;
        max-height: 80vh;
        overflow-y: auto;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        animation: slideUp 0.3s ease-out;
        position: relative;
    }

    @keyframes slideUp {
        from {
            transform: translateY(30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--card-bg);
    }

    .modal-header h2 {
        color: var(--primary);
        font-size: 1.8rem;
        margin: 0;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 1.8rem;
        cursor: pointer;
        color: var(--text-light);
        transition: all 0.2s ease;
    }

    .close-modal:hover {
        color: var(--primary);
        transform: rotate(90deg);
    }

    .modal-body {
        margin-bottom: 2rem;
    }

    .modal-body h3 {
        color: var(--primary);
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .modal-body p {
        color: var(--text-dark);
        line-height: 1.8;
        margin-bottom: 0.8rem;
    }

    .modal-body strong {
        color: var(--primary);
    }

    .modal-footer {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .btn-modal-close {
        padding: 0.8rem 1.5rem;
        background: var(--light-bg);
        color: var(--primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-modal-close:hover {
        background: var(--card-bg);
    }

    /* User Data Table in Modal */
    .user-data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .user-data-table thead {
        background: var(--light-bg);
    }

    .user-data-table th {
        padding: 0.8rem;
        text-align: left;
        font-weight: 600;
        color: var(--primary);
        border-bottom: 2px solid var(--border-color);
        font-size: 0.85rem;
    }

    .user-data-table td {
        padding: 0.8rem;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.9rem;
    }

    .user-data-table tbody tr:hover {
        background: var(--light-bg);
    }

    .user-data-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Stats Summary */
    .stats-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin: 1.5rem 0;
    }

    .summary-item {
        background: var(--light-bg);
        padding: 1rem;
        border-radius: 8px;
        border-left: 4px solid var(--primary);
    }

    .summary-item .label {
        font-size: 0.85rem;
        color: var(--text-light);
        margin-bottom: 0.5rem;
    }

    .summary-item .value {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .admin-header h1 {
            font-size: 2.2rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .admin-container {
            padding: 1.5rem 1rem;
        }

        .admin-header h1 {
            font-size: 1.8rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .stat-card {
            flex-direction: column;
            text-align: center;
        }

        .stat-card-icon {
            width: 70px;
            height: 70px;
            font-size: 2rem;
        }

        .section-card {
            padding: 1.5rem;
        }

        .section-title {
            font-size: 1.3rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
            padding: 0.7rem 1rem;
        }

        table {
            font-size: 0.9rem;
        }

        th, td {
            padding: 0.8rem 0.6rem;
        }

        .stat-card-content .number {
            font-size: 2rem;
        }

        .modal-content {
            width: 95%;
            padding: 1.5rem;
        }

        .stats-summary {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .admin-header h1 {
            font-size: 1.5rem;
            gap: 0.5rem;
        }

        .section-title {
            font-size: 1.1rem;
        }

        .badge {
            font-size: 0.7rem;
            padding: 0.4rem 0.8rem;
        }

        .modal-footer {
            flex-direction: column;
        }

        .btn-modal-close {
            width: 100%;
        }

        .user-data-table th,
        .user-data-table td {
            padding: 0.6rem;
            font-size: 0.8rem;
        }

        .stats-summary {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="admin-container">
    {{-- Header --}}
    <div class="admin-header">
        <h1><i class="fas fa-chart-line"></i> Admin Dashboard</h1>
        <p>Pantau semua aktivitas user dan kelola persetujuan peminjaman</p>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card" onclick="openModal('usersModal')">
            <div class="stat-card-content">
                <h3>Total Users</h3>
                <div class="number">{{ $stats['total_users'] }}</div>
            </div>
            <div class="stat-card-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>

        <div class="stat-card" onclick="openModal('barangsModal')">
            <div class="stat-card-content">
                <h3>Total Barang</h3>
                <div class="number">{{ $stats['total_barangs'] }}</div>
            </div>
            <div class="stat-card-icon">
                <i class="fas fa-box"></i>
            </div>
        </div>

        <div class="stat-card" onclick="openModal('peminjamansModal')">
            <div class="stat-card-content">
                <h3>Total Peminjaman</h3>
                <div class="number">{{ $stats['total_peminjaman'] }}</div>
            </div>
            <div class="stat-card-icon">
                <i class="fas fa-exchange-alt"></i>
            </div>
        </div>

        <div class="stat-card" onclick="openModal('pendingModal')">
            <div class="stat-card-content">
                <h3>Menunggu Persetujuan</h3>
                <div class="number">{{ $stats['peminjaman_pending'] }}</div>
            </div>
            <div class="stat-card-icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    {{-- Pending Peminjaman --}}
    <div class="section-card">
        <div class="section-title">
            <i class="fas fa-clock"></i> Peminjaman Menunggu Persetujuan
        </div>

        @if($peminjamans->count() > 0)
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>👤 User</th>
                            <th>📦 Barang</th>
                            <th>Qty</th>
                            <th>📅 Tanggal Permintaan</th>
                            <th>Status</th>
                            <th>⚙️ Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjamans as $pinjam)
                            <tr>
                                <td><strong>{{ $pinjam->user->name ?? 'User Terhapus' }}</strong></td>
                                <td>{{ $pinjam->barang->name ?? 'Barang Terhapus' }}</td>
                                <td>{{ $pinjam->quantity }}x</td>
                                <td>{{ $pinjam->created_at->format('d/m/Y H:i') }}</td>
                                <td><span class="badge badge-pending">⏳ Pending</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <form action="{{ route('admin.approve-peminjaman', $pinjam->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-action btn-approve">
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.reject-peminjaman', $pinjam->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-action btn-reject">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="pagination">
                {{ $peminjamans->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>Tidak ada peminjaman yang menunggu</h3>
                <p>Semua permohonan peminjaman telah diproses</p>
            </div>
        @endif
    </div>

    {{-- Irresponsible Users --}}
    <div class="section-card">
        <div class="section-title">
            <i class="fas fa-exclamation-circle"></i> User Dengan Banyak Peminjaman
        </div>

        @if($users_irresponsible->count() > 0)
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>👤 Nama User</th>
                            <th>📧 Email</th>
                            <th>Peminjaman</th>
                            <th>Program Studi</th>
                            <th>Status</th>
                            <th>⚙️ Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users_irresponsible as $user)
                            <tr>
                                <td><strong>{{ $user->name }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td><span style="background: #ffe6e6; color: #c41e3a; padding: 0.4rem 0.8rem; border-radius: 8px; font-weight: 600;">{{ $user->peminjamans_count }}x</span></td>
                                <td>{{ $user->program_studi }}</td>
                                <td>
                                    @if($user->is_blocked)
                                        <span class="badge badge-blocked">🚫 Diblokir</span>
                                    @else
                                        <span class="badge badge-active">✅ Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.user-activity', $user->id) }}" class="btn-action btn-view">
                                            <i class="fas fa-eye"></i> Aktivitas
                                        </a>
                                        @if($user->is_blocked)
                                            <form action="{{ route('admin.unblock-user', $user->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn-action btn-unblock">
                                                    <i class="fas fa-unlock"></i> Buka
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.block-user', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin memblokir user ini?');">
                                                @csrf
                                                <button type="submit" class="btn-action btn-block">
                                                    <i class="fas fa-ban"></i> Blokir
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-thumbs-up"></i>
                <h3>Semua user bertanggung jawab</h3>
                <p>Tidak ada user dengan peminjaman berlebihan</p>
            </div>
        @endif
    </div>
</div>

<!-- Modals -->

<!-- Users Modal -->
<div id="usersModal" class="modal" onclick="closeModalOnBackdrop(event, 'usersModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h2><i class="fas fa-users"></i> Data Pengguna</h2>
            <button class="close-modal" onclick="closeModal('usersModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="stats-summary">
                <div class="summary-item">
                    <div class="label">Total Pengguna</div>
                    <div class="value">{{ $stats['total_users'] }}</div>
                </div>
            </div>

            <h3>📋 Daftar Semua Pengguna</h3>
            @php
                $allUsers = \App\Models\User::where('role', 'user')->get();
            @endphp

            @if($allUsers->count() > 0)
                <table class="user-data-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Program Studi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allUsers as $user)
                            <tr>
                                <td><strong>{{ $user->name }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->program_studi ?? '-' }}</td>
                                <td>
                                    @if($user->is_blocked)
                                        <span class="badge badge-blocked">Diblokir</span>
                                    @else
                                        <span class="badge badge-active">Aktif</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: #999; padding: 2rem;">Tidak ada pengguna</p>
            @endif
        </div>
        <div class="modal-footer">
            <button class="btn-modal-close" onclick="closeModal('usersModal')">Tutup</button>
        </div>
    </div>
</div>

<!-- Barangs Modal -->
<div id="barangsModal" class="modal" onclick="closeModalOnBackdrop(event, 'barangsModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h2><i class="fas fa-box"></i> Data Barang</h2>
            <button class="close-modal" onclick="closeModal('barangsModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="stats-summary">
                <div class="summary-item">
                    <div class="label">Total Barang</div>
                    <div class="value">{{ $stats['total_barangs'] }}</div>
                </div>
            </div>

            <h3>📋 Daftar Semua Barang</h3>
            @php
                $allBarangs = \App\Models\Barang::all();
            @endphp

            @if($allBarangs->count() > 0)
                <table class="user-data-table">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Pemilik</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allBarangs as $barang)
                            <tr>
                                <td><strong>{{ $barang->name }}</strong></td>
                                <td>{{ $barang->category ?? '-' }}</td>
                                <td>{{ $barang->stock ?? '-' }}</td>
                                <td>{{ $barang->user->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: #999; padding: 2rem;">Tidak ada barang</p>
            @endif
        </div>
        <div class="modal-footer">
            <button class="btn-modal-close" onclick="closeModal('barangsModal')">Tutup</button>
        </div>
    </div>
</div>

<!-- Peminjamans Modal -->
<div id="peminjamansModal" class="modal" onclick="closeModalOnBackdrop(event, 'peminjamansModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h2><i class="fas fa-exchange-alt"></i> Data Peminjaman</h2>
            <button class="close-modal" onclick="closeModal('peminjamansModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="stats-summary">
                <div class="summary-item">
                    <div class="label">Total Peminjaman</div>
                    <div class="value">{{ $stats['total_peminjaman'] }}</div>
                </div>
            </div>

            <h3>📋 Daftar Semua Peminjaman</h3>
            @php
                $allPeminjamans = \App\Models\Peminjaman::with(['user', 'barang'])->latest()->get();
            @endphp

            @if($allPeminjamans->count() > 0)
                <table class="user-data-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Barang</th>
                            <th>Qty</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allPeminjamans as $pinjam)
                            <tr>
                                <td>{{ $pinjam->user->name ?? '-' }}</td>
                                <td>{{ $pinjam->barang->name ?? '-' }}</td>
                                <td>{{ $pinjam->quantity }}x</td>
                                <td>{{ $pinjam->created_at->format('d/m/Y') }}</td>
                                <td><span class="badge badge-{{ strtolower($pinjam->status) }}">{{ ucfirst($pinjam->status) }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: #999; padding: 2rem;">Tidak ada peminjaman</p>
            @endif
        </div>
        <div class="modal-footer">
            <button class="btn-modal-close" onclick="closeModal('peminjamansModal')">Tutup</button>
        </div>
    </div>
</div>

<!-- Pending Modal -->
<div id="pendingModal" class="modal" onclick="closeModalOnBackdrop(event, 'pendingModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h2><i class="fas fa-hourglass-half"></i> Permohonan Menunggu</h2>
            <button class="close-modal" onclick="closeModal('pendingModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="stats-summary">
                <div class="summary-item">
                    <div class="label">Menunggu Persetujuan</div>
                    <div class="value">{{ $stats['peminjaman_pending'] }}</div>
                </div>
            </div>

            <h3>📋 Peminjaman yang Memerlukan Persetujuan</h3>
            @php
                $pendingPeminjamans = \App\Models\Peminjaman::with(['user', 'barang'])->where('status', 'pending')->latest()->get();
            @endphp

            @if($pendingPeminjamans->count() > 0)
                <table class="user-data-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Barang</th>
                            <th>Qty</th>
                            <th>Tanggal Permintaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingPeminjamans as $pinjam)
                            <tr>
                                <td>{{ $pinjam->user->name ?? '-' }}</td>
                                <td>{{ $pinjam->barang->name ?? '-' }}</td>
                                <td>{{ $pinjam->quantity }}x</td>
                                <td>{{ $pinjam->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: #999; padding: 2rem;">Tidak ada peminjaman yang menunggu</p>
            @endif
        </div>
        <div class="modal-footer">
            <button class="btn-modal-close" onclick="closeModal('pendingModal')">Tutup</button>
        </div>
    </div>
</div>

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('show');
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('show');
    }

    function closeModalOnBackdrop(event, modalId) {
        if (event.target.id === modalId) {
            closeModal(modalId);
        }
    }

    // Close modal on ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.modal.show').forEach(modal => {
                modal.classList.remove('show');
            });
        }
    });
</script>

@endsection