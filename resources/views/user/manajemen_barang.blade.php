@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #B8E6EC 0%, #D4F1F4 100%);
        min-height: 100vh;
    }

    /* Container */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem 2rem;
    }

    /* Page Title */
    .page-title {
        text-align: center;
        font-size: 1.8rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 2rem;
    }

    /* Search & Filter Section */
    .search-section {
        background: rgba(255,255,255,0.5);
        padding: 1.5rem;
        border-radius: 15px;
        margin-bottom: 2rem;
    }

    .search-box {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .search-box input {
        width: 100%;
        padding: 0.9rem 3.5rem 0.9rem 1rem;
        border: 2px solid #4FB9C8;
        border-radius: 10px;
        font-size: 0.95rem;
        font-family: 'Poppins', sans-serif;
        background: rgba(255,255,255,0.8);
    }

    .search-box input::placeholder {
        color: #999;
    }

    .search-icons {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        gap: 0.5rem;
    }

    .search-icons i {
        color: #4FB9C8;
        cursor: pointer;
        font-size: 1.1rem;
    }

    /* Filter Buttons */
    .filter-group {
        margin-bottom: 1rem;
    }

    .filter-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        display: block;
    }

    .filter-buttons {
        display: flex;
        gap: 0.8rem;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 0.5rem 1.2rem;
        border: none;
        border-radius: 8px;
        background: #8DD4DE;
        color: #333;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        font-family: 'Poppins', sans-serif;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: #4FB9C8;
        color: white;
    }

    /* Add Button */
    .btn-add {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #4FB9C8;
        color: white;
        border: none;
        font-size: 1.8rem;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(79, 185, 200, 0.4);
        transition: all 0.3s;
        z-index: 100;
    }

    .btn-add:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(79, 185, 200, 0.6);
    }

    /* Items Grid */
    .items-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    /* Item Card */
    .item-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }

    .item-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 25px rgba(0,0,0,0.15);
    }

    .item-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: #E8F6F8;
    }

    .item-content {
        padding: 1.2rem;
    }

    .item-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 0.8rem;
    }

    .item-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        flex: 1;
    }

    .status-badge {
        padding: 0.3rem 0.8rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-tersedia {
        background: #8DD4DE;
        color: #333;
    }

    .status-dipinjam {
        background: #FFD700;
        color: #333;
    }

    .status-tidak-tersedia {
        background: #FF6B6B;
        color: white;
    }

    .item-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.8rem;
    }

    .item-category {
        background: #E8F6F8;
        padding: 0.3rem 0.8rem;
        border-radius: 6px;
        color: #4FB9C8;
        font-weight: 500;
    }

    .item-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .btn-action {
        flex: 1;
        padding: 0.6rem;
        border: none;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        font-family: 'Poppins', sans-serif;
    }

    .btn-edit {
        background: #4FB9C8;
        color: white;
    }

    .btn-edit:hover {
        background: #3AA0AE;
    }

    .btn-delete {
        background: #FF6B6B;
        color: white;
    }

    .btn-delete:hover {
        background: #FF5252;
    }

    .btn-detail {
        background: #E8F6F8;
        color: #4FB9C8;
    }

    .btn-detail:hover {
        background: #D4EEF2;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: #CCC;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        color: #666;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #999;
        font-size: 0.9rem;
    }

    /* Sidebar Menu (Mobile) */
    .sidebar {
        position: fixed;
        top: 0;
        right: -300px;
        width: 300px;
        height: 100vh;
        background: linear-gradient(135deg, #4FB9C8 0%, #3AA0AE 100%);
        box-shadow: -2px 0 10px rgba(0,0,0,0.1);
        transition: right 0.3s;
        z-index: 1000;
        padding: 2rem;
    }

    .sidebar.active {
        right: 0;
    }

    .sidebar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        color: white;
    }

    .sidebar-header h3 {
        font-size: 1.3rem;
    }

    .close-sidebar {
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
    }

    .sidebar-menu {
        list-style: none;
    }

    .sidebar-menu li {
        margin-bottom: 1rem;
    }

    .sidebar-menu a {
        color: white;
        text-decoration: none;
        font-size: 1rem;
        display: block;
        padding: 0.8rem;
        border-radius: 8px;
        transition: background 0.3s;
    }

    .sidebar-menu a:hover {
        background: rgba(255,255,255,0.2);
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: rgba(0,0,0,0.5);
        display: none;
        z-index: 999;
    }

    .overlay.active {
        display: block;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .navbar {
            padding: 1rem;
        }

        .navbar-menu {
            display: none;
        }

        .menu-toggle {
            display: block;
        }

        .container {
            padding: 0 1rem 1rem;
        }

        .items-grid {
            grid-template-columns: 1fr;
        }

        .btn-add {
            bottom: 1rem;
            right: 1rem;
            width: 55px;
            height: 55px;
        }

        .filter-buttons {
            gap: 0.5rem;
        }

        .filter-btn {
            font-size: 0.8rem;
            padding: 0.4rem 1rem;
        }
    }
</style>

<div class="container">
    <h1 class="page-title">Manajemen Barang</h1>

    <!-- Search & Filter Section -->
    <div class="search-section">
        <div class="search-box">
            <input type="text" placeholder="Cari barang..." id="searchInput">
            <div class="search-icons">
                <i class="fas fa-search"></i>
                <i class="fas fa-filter"></i>
            </div>
        </div>

        <div class="filter-group">
            <span class="filter-label">Kategori</span>
            <div class="filter-buttons" id="categoryFilter">
                <button class="filter-btn active" data-category="all">Semua</button>
                <button class="filter-btn" data-category="buku">Buku</button>
                <button class="filter-btn" data-category="alat">Alat</button>
                <button class="filter-btn" data-category="pakaian">Pakaian</button>
                <button class="filter-btn" data-category="elektronik">Elektronik</button>
            </div>
        </div>

        <div class="filter-group">
            <span class="filter-label">Status</span>
            <div class="filter-buttons" id="statusFilter">
                <button class="filter-btn active" data-status="all">Semua</button>
                <button class="filter-btn" data-status="tersedia">Tersedia</button>
                <button class="filter-btn" data-status="dipinjam">Dipinjam</button>
                <button class="filter-btn" data-status="rusak">Rusak</button>
            </div>
        </div>
    </div>

    <!-- Items Grid -->
<div class="items-grid" id="itemsGrid">
    @forelse($barangs as $barang)
        <div class="item-card">

            {{-- Foto --}}
            <img src="{{ $barang->photo ? asset('storage/' . $barang->photo) : 'https://via.placeholder.com/300x200' }}" 
                alt="{{ $barang->name }}" 
                class="item-image">

            <div class="item-content">
                <div class="item-header">
                    <h3 class="item-title">{{ $barang->name }}</h3>

                    <span class="status-badge status-{{ strtolower($barang->status) }}">
                        {{ ucfirst($barang->status) }}
                    </span>
                </div>

                <div class="item-meta">
                    <span>Total: {{ $barang->qty }} Barang</span>
                    <span class="item-category">{{ ucfirst($barang->category) }}</span>
                </div>

                <div class="item-actions">
                    @auth
                        {{-- Hanya pemilik barang atau admin --}}
                        @if(Auth::id() === $barang->user_id || Auth::user()->role === 'admin')

                            {{-- Hapus barang --}}
                            <form action="{{ route('items.delete', $barang->id) }}"
                                  method="POST"
                                  style="display:inline;"
                                  onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn-action btn-delete">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @endif
                    @endauth

                    {{-- Detail --}}
                    <a href="{{ route('items.show.page', $barang->id) }}" class="btn-action btn-detail">
                        Detail
                    </a>
                </div>
            </div>
        </div>

    @empty
        <div class="empty-state" style="grid-column: 1/-1;">
            <i class="fas fa-box-open"></i>
            <h3>Belum ada barang</h3>
            <p>Mulai tambahkan barang yang ingin kamu pinjamkan</p>
        </div>
    @endforelse
</div>

<!-- Floating Add Button -->
<a href="{{ route('barang.create.page') }}" class="btn-add">
    <i class="fas fa-plus"></i>
</a>



<script>
    // Filter Button Active State
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.parentElement.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    function filterItems() {
        // TODO: Implementasi filter items
    }
</script>

@endsection