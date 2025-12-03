@extends('layouts.app')

@section('content')
<style>
    .riwayat-container {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .page-title {
        text-align: center;
        font-weight: 700;
        font-size: 24px;
        color: #308AA5;
        margin-bottom: 20px;
    }

    .search-filter-section {
        background: #E8F6F8;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .search-box {
        position: relative;
        margin-bottom: 15px;
    }

    .search-box input {
        width: 100%;
        padding: 12px 45px 12px 15px;
        border: 1px solid #B8E3EA;
        border-radius: 10px;
        background: white;
        font-size: 14px;
    }

    .search-box .search-icon {
        position: absolute;
        right: 35px;
        top: 50%;
        transform: translateY(-50%);
        color: #308AA5;
        cursor: pointer;
    }

    .search-box .filter-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #308AA5;
        cursor: pointer;
        font-size: 18px;
    }

    .filter-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }

    .filter-section-title {
        font-size: 13px;
        font-weight: 600;
        color: #308AA5;
        margin-bottom: 8px;
        margin-top: 10px;
    }

    .filter-pill {
        background: #3AA6B9;
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .filter-pill:hover {
        background: #308AA5;
        transform: translateY(-2px);
    }

    .riwayat-table {
        width: 100%;
        margin-top: 20px;
    }

    .riwayat-header {
        display: grid;
        grid-template-columns: 1.5fr 1.2fr 1fr 1fr 1fr;
        padding: 12px 15px;
        background: #308AA5;
        color: white;
        font-weight: 600;
        font-size: 14px;
        border-radius: 10px 10px 0 0;
        gap: 10px;
    }

    .riwayat-row {
        display: grid;
        grid-template-columns: 1.5fr 1.2fr 1fr 1fr 1fr;
        padding: 15px;
        border-bottom: 1px solid #E0F4F7;
        align-items: center;
        gap: 10px;
        transition: background 0.2s;
    }

    .riwayat-row:hover {
        background: #F5FCFD;
    }

    .barang-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .barang-img {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #E0F4F7;
    }

    .barang-text h4 {
        font-size: 14px;
        font-weight: 600;
        color: #308AA5;
        margin: 0;
    }

    .barang-text p {
        font-size: 12px;
        color: #666;
        margin: 2px 0 0 0;
    }

    .keterangan-info p {
        margin: 0;
        font-size: 13px;
        color: #555;
        line-height: 1.4;
    }

    .tanggal-info p {
        margin: 0;
        font-size: 12px;
        color: #555;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
    }

    .status-sedang-berjalan {
        background: #FFF3CD;
        color: #856404;
    }

    .status-selesai {
        background: #D1F2D9;
        color: #0F5132;
    }

    .status-ditolak {
        background: #F8D7DA;
        color: #842029;
    }

    .status-diajukan {
        background: #CCE5FF;
        color: #004085;
    }

    .aksi-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-aksi {
        padding: 6px 12px;
        border: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-chat {
        background: #3AA6B9;
        color: white;
    }

    .btn-chat:hover {
        background: #308AA5;
    }

    .btn-detail {
        background: #6C757D;
        color: white;
    }

    .btn-detail:hover {
        background: #5A6268;
    }

    .btn-ulasan {
        background: #3AA6B9;
        color: white;
    }

    .btn-ulasan:hover {
        background: #308AA5;
    }

    /* Modal Styles */
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        align-items: center;
        justify-content: center;
    }

    .custom-modal.show {
        display: flex;
    }

    .modal-content-custom {
        background: white;
        border-radius: 20px;
        padding: 30px;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        animation: modalFadeIn 0.3s;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    .modal-header-custom {
        text-align: center;
        margin-bottom: 20px;
    }

    .modal-header-custom h3 {
        color: #308AA5;
        font-weight: 700;
        font-size: 22px;
        margin-bottom: 10px;
    }

    .modal-body-custom {
        text-align: center;
        color: #555;
        line-height: 1.6;
    }

    .contact-info {
        background: #E8F6F8;
        padding: 15px;
        border-radius: 12px;
        margin: 15px 0;
    }

    .contact-info p {
        margin: 8px 0;
        font-size: 14px;
        color: #308AA5;
        font-weight: 500;
    }

    .detail-info-box {
        background: #E8F6F8;
        padding: 15px;
        border-radius: 12px;
        margin: 15px 0;
        text-align: left;
    }

    .detail-info-box .info-row {
        display: flex;
        margin-bottom: 10px;
    }

    .detail-info-box .info-label {
        width: 140px;
        font-weight: 600;
        color: #308AA5;
        font-size: 14px;
    }

    .detail-info-box .info-value {
        color: #555;
        font-size: 14px;
    }

    .star-rating {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin: 20px 0;
    }

    .star {
        font-size: 40px;
        color: #DDD;
        cursor: pointer;
        transition: all 0.2s;
    }

    .star:hover,
    .star.active {
        color: #FFD700;
        transform: scale(1.1);
    }

    .modal-footer-custom {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 25px;
    }

    .btn-modal {
        padding: 10px 30px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-primary-modal {
        background: #3AA6B9;
        color: white;
    }

    .btn-primary-modal:hover {
        background: #308AA5;
    }

    .btn-secondary-modal {
        background: #6C757D;
        color: white;
    }

    .btn-secondary-modal:hover {
        background: #5A6268;
    }

    .btn-success-modal {
        background: #28A745;
        color: white;
    }

    .btn-success-modal:hover {
        background: #218838;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .riwayat-header,
        .riwayat-row {
            grid-template-columns: 1fr;
        }

        .riwayat-header {
            display: none;
        }

        .riwayat-row {
            border: 1px solid #E0F4F7;
            border-radius: 12px;
            margin-bottom: 15px;
            padding: 15px;
        }

        .riwayat-row > div::before {
            content: attr(data-label);
            font-weight: 600;
            color: #308AA5;
            display: block;
            margin-bottom: 5px;
        }
    }
</style>
<table class="riwayat-table">
    <tr>
        <th>Nama Peminjam</th>
        <th>Nama Barang</th>
        <th>Jumlah</th>
        <th>Tanggal Pinjam</th>
        <th>Status Pinjaman</th>
        <th>Aksi</th>
    </tr>
</table>
@forelse($loans as $it)
    @php
        $tanggalPinjam = isset($it['tanggal_pinjam'])
            ? \Carbon\Carbon::parse($it['tanggal_pinjam'])->format('d/m/Y')
            : '-';
    @endphp
<table class="riwayat-table">
    
    <tr>
        {{-- Nama Peminjam --}}
        <td>{{ $it['user_name'] ?? 'N/A' }}</td>

        {{-- Nama Barang --}}
        <td>{{ $it['barang_name'] ?? 'N/A' }}</td>

        {{-- Jumlah --}}
        <td>{{ $it['qty'] ?? 1 }}</td>

        {{-- Tanggal Pinjam --}}
        <td>{{ $tanggalPinjam }}</td>

        {{-- Status Pinjaman --}}
        <td>
            @php
                $status = $it['status'] ?? '';
            @endphp

            @switch($status)
                @case('diajukan')
                    <span class="badge bg-warning">Pending</span>
                    @break

                @case('dipinjam')
                    <span class="badge bg-success">Dipinjam</span>
                    @break

                @case('ditolak')
                    <span class="badge bg-danger">Ditolak</span>
                    @break

                @case('dikembalikan')
                    <span class="badge bg-secondary">Dikembalikan</span>
                    @break

                @default
                    <span class="badge bg-dark">Unknown</span>
            @endswitch
        </td>

        {{-- Aksi --}}
        <td>
            @if(($it['status'] ?? null) == 'diajukan' && auth()->id() == ($it['owner_id'] ?? null))
                
                {{-- Setujui --}}
                <form action="{{ route('loan.approve', $it['id']) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">
                        Setujui
                    </button>
                </form>

                {{-- Tolak --}}
                <form action="{{ route('loan.reject', $it['id']) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">
                        Tolak
                    </button>
                </form>

            @else
                <span class="text-muted">-</span>
            @endif
        </td>
    </tr>
</table>
@empty
    <tr>
        <td colspan="6" class="text-center text-muted py-4">
            Belum ada riwayat.
        </td>
    </tr>
@endforelse



@endsection

@push('scripts')
<script>
    // Toggle Filter
    document.getElementById('toggleFilter').addEventListener('click', function() {
        const filterSection = document.getElementById('filterSection');
        filterSection.style.display = filterSection.style.display === 'none' ? 'block' : 'none';
    });

    // Modal Functions
    function openChatModal() {
        document.getElementById('chatModal').classList.add('show');
    }

    function openDetailModal() {
        document.getElementById('detailModal').classList.add('show');
    }

    function openApproveModal() {
        document.getElementById('approveModal').classList.add('show');
    }

    function openRatingModal() {
        document.getElementById('ratingModal').classList.add('show');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('show');
    }

    function approveRequest() {
        closeModal('approveModal');
        setTimeout(() => {
            document.getElementById('successModal').classList.add('show');
        }, 300);
    }

    function confirmDelete() {
        closeModal('deleteModal');
        alert('Permintaan berhasil dihapus!');
    }

    // Star Rating
    let selectedRating = 0;
    const stars = document.querySelectorAll('.star');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            selectedRating = parseInt(this.getAttribute('data-rating'));
            updateStars(selectedRating);
        });

        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            updateStars(rating);
        });
    });

    document.getElementById('starRating').addEventListener('mouseleave', function() {
        updateStars(selectedRating);
    });

    function updateStars(rating) {
        stars.forEach(star => {
            const starRating = parseInt(star.getAttribute('data-rating'));
            if (starRating <= rating) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });
    }

    function submitRating() {
        if (selectedRating > 0) {
            alert(`Terima kasih! Anda memberikan rating ${selectedRating} bintang`);
            closeModal('ratingModal');
        } else {
            alert('Silakan pilih rating terlebih dahulu');
        }
    }

    // Close modal when clicking outside
    document.querySelectorAll('.custom-modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('show');
            }
        });
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('.riwayat-row');

        rows.forEach(row => {
            const barangText = row.querySelector('.barang-text h4').textContent.toLowerCase();
            if (barangText.includes(searchTerm)) {
                row.style.display = 'grid';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Filter functionality
    document.querySelectorAll('.filter-pill').forEach(pill => {
        pill.addEventListener('click', function() {
            // Toggle active state (optional visual feedback)
            this.classList.toggle('active');
            
            // In real application, you would filter the data here
            console.log('Filter:', this.getAttribute('data-filter'), '=', this.getAttribute('data-value'));
        });
    });
</script>
@endpush