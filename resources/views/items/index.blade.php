@extends('layouts.app')

@section('content')
@push('head')
<style>
    /* CSS Kustom dari Desain Gambar Anda */
    .page-title { font-weight: 700; color: #0f1720; text-align: center; margin-bottom: 24px; font-size: 1.8rem; }
    .search-box-container { background-color: #C8E6EE; padding: 12px 24px; border-radius: 35px; max-width: 980px; margin: 10px auto 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .search-box-container input { border: none; background: transparent; outline: none; width: 100%; font-size: 1.1rem; color: #0f1720; }
    .search-icons i { font-size: 1.4rem; color: #37474f; margin-left: 10px; cursor: pointer; }
    .filter-box { background: #D0EEF2; padding: 26px; border-radius: 14px; margin: 20px auto 30px; max-width: 980px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .filter-title { font-weight: 600; color: #0f1720; margin-bottom: 8px; font-size: 1.1rem; }
    .filter-btn { background: #2FA7B3; color: white; padding: 6px 16px; border-radius: 20px; font-size: 14px; font-weight: 600; border: none; margin-right: 8px; margin-top: 8px; cursor: pointer; transition: all 0.2s; opacity: 0.85; }
    .filter-btn.active { box-shadow: 0 0 0 3px rgba(47, 167, 179, 0.4); opacity: 1; transform: scale(1.02); }
    .item-card { background: #D0EEF2; border-radius: 12px; padding: 15px; display: flex; align-items: center; gap: 15px; margin-bottom: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: box-shadow 0.3s; cursor: pointer; max-width: 980px; margin-left: auto; margin-right: auto; text-decoration: none; color: inherit; }
    .item-card:hover { box-shadow: 0 4px 14px rgba(0,0,0,0.12); }
    .item-img-container { width: 80px; height: 80px; flex-shrink: 0; border-radius: 8px; overflow: hidden; }
    .item-img-container img { width: 100%; height: 100%; object-fit: cover; }
    .item-details .title { font-weight: 700; font-size: 16px; margin-bottom: 2px; }
    .item-details .sub-info { font-size: 13px; color: #37474f; margin-bottom: 2px; display: flex; align-items: center; }
    .item-details .sub-info i { margin-right: 4px; font-size: 11px; }
    .status-badge { font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 12px; margin-top: 5px; display: inline-block; }
    .status-badge.tersedia { background: #E0F7FA; color: #00838F; }
    .status-badge.dipinjam { background: #FFE0B2; color: #E65100; }
    .status-badge.tidak-tersedia { background: #FBEFF2; color: #CC3333; }
    .no-data{ text-align:center; padding:30px; color:#6b7280; }
</style>
@endpush

<div class="text-center">
    <h2 class="page-title">Pinjam barang</h2>
</div>

<form id="filterForm" method="get" action="{{ route('barang.index') }}">
    <div class="search-box-container">
        <div class="d-flex align-items-center">
            <input type="text" name="q" id="q" placeholder="Cari barang atau buku...." 
                   value="{{ old('q', $q) ?? request('q') }}">
            <div class="d-flex align-items-center search-icons">
                <button type="submit" class="btn btn-sm" style="background:transparent; border:none;" title="Cari">
                    <i class="fas fa-search"></i>
                </button>
                <i class="fas fa-sliders-h" id="toggleFilterBtn" title="Filter Tambahan"></i>
            </div>
        </div>
    </div>

    <input type="hidden" name="jenis" id="jenis" value="{{ $jenis ?? '' }}">
    <input type="hidden" name="status" id="status" value="{{ $status ?? '' }}">

    {{-- Kotak Filter Jenis dan Status --}}
    <div class="filter-box" id="filterBox">
        <div>
            <p class="filter-title mb-2">Jenis barang</p>
            <div id="jenisButtons" class="d-flex flex-wrap">
                @foreach($jenisList as $j)
                    @php $isActive = (isset($jenis) && $jenis === $j); @endphp
                    <button type="button"
                            class="filter-btn {{ $isActive ? 'active' : '' }}"
                            data-type="jenis"
                            data-value="{{ $j }}">{{ $j }}</button>
                @endforeach
            </div>
        </div>

        <div class="mt-4">
            <p class="filter-title mb-2">Status</p>
            <div id="statusButtons" class="d-flex flex-wrap">
                @foreach($statusList as $s)
                    @php $isActive = (isset($status) && $status === $s); @endphp
                    <button type="button"
                            class="filter-btn {{ $isActive ? 'active' : '' }}"
                            data-type="status"
                            data-value="{{ $s }}">{{ $s }}</button>
                @endforeach
            </div>
        </div>
    </div>
</form>

<div class="container mt-3">
    <div class="cards-row">
        @forelse($barangs as $item)
            @php
                $statusSlug = strtolower(str_replace(' ', '-', $item->status));
                $statusClass = in_array($statusSlug, ['tersedia', 'dipinjam', 'tidak-tersedia']) ? $statusSlug : '';
                
                // Mengambil nama pemilik dan lokasi (penting: pastikan relasi 'owner' di model Barang berfungsi)
                $pemilikNama = $item->owner->name ?? 'Pemilik Tidak Diketahui';
                $lokasi = $item->lokasi ?? 'Lokasi Tidak Diketahui';
            @endphp
            
            <a href="{{ url('/barang/'.$item->id) }}" class="item-card">
                <div class="item-img-container">
                    @if($item->gambar && file_exists(public_path('uploads/'.$item->gambar)))
                        <img src="{{ asset('uploads/'.$item->gambar) }}" alt="{{ $item->nama }}">
                    @else
                        <div style="background:#e0f7fa; display:flex; align-items:center; justify-content:center; height:100%;">
                            <i class="fas fa-box-open" style="font-size:30px; color:#a7c8cf;"></i>
                        </div>
                    @endif
                </div>

                <div class="item-details">
                    <div class="title">{{ $item->nama }}</div>
                    <div class="sub-info">Pemilik: {{ $pemilikNama }}</div>
                    <div class="sub-info">
                        <i class="fas fa-map-marker-alt"></i>{{ $lokasi }}
                    </div>
                    
                    <span class="status-badge {{ $statusClass }}">
                        {{ $item->status }}
                    </span>
                </div>
            </a>
        @empty
            <div class="no-data">Belum ada barang sesuai filter atau pencarian.</div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $barangs->links() }}
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logika Tombol Filter (Mengatur hidden input dan submit form)
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function(e){
                e.preventDefault(); // Mencegah submit default
                const type = this.getAttribute('data-type');
                const value = this.getAttribute('data-value');

                const currently = document.getElementById(type).value;
                if (currently === value) {
                    document.getElementById(type).value = '';
                } else {
                    document.getElementById(type).value = value;
                }

                document.getElementById('filterForm').submit();
            });
        });

        // Logika Toggle Filter Box (Menampilkan/Menyembunyikan kotak filter)
        const filterBox = document.getElementById('filterBox');
        const toggleBtn = document.getElementById('toggleFilterBtn');

        // Awalnya, sembunyikan jika tidak ada filter aktif
        let hasActiveFilter = document.getElementById('jenis').value || document.getElementById('status').value;
        if (!hasActiveFilter) {
            filterBox.style.display = 'none';
        }

        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (filterBox.style.display === 'none' || filterBox.style.display === '') {
                filterBox.style.display = 'block';
            } else {
                filterBox.style.display = 'none';
            }
        });
        
    });
</script>
@endpush

@endsection