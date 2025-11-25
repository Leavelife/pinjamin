<x-app-layout>

    {{-- Top Navbar --}}
    <div class="bg-[#0C8A9A] text-white px-6 py-4 flex justify-between items-center shadow-md rounded-b-3xl">
        <div class="flex items-center gap-3">
            <div class="bg-white w-11 h-11 rounded-md flex items-center justify-center">
                📦
            </div>
            <div>
                <h1 class="font-bold text-xl">Pinjam.in</h1>
                <p class="text-xs opacity-90">Pinjam barang, bangun kepercayaan</p>
            </div>
        </div>

        <div class="flex items-center gap-6 text-sm font-semibold">
            <a href="#" class="hover:text-gray-200">Beranda</a>
            <a href="#" class="hover:text-gray-200">Riwayat</a>
            <a href="#" class="hover:text-gray-200">Notifikasi</a>
        </div>

        <div class="flex items-center gap-4 text-lg">
            🔍 ☰
        </div>
    </div>

    
    <!-- Page Title -->
    <h2 class="text-center text-2xl font-bold text-gray-800 mt-10">Pinjam barang</h2>

    <!-- Search Bar -->
    <div class="max-w-2xl mx-auto mt-6">
        <div class="bg-white p-4 shadow-md rounded-full flex items-center gap-4">
            <input type="text" placeholder="Cari barang atau buku...." class="flex-1 outline-none px-3 text-gray-600" />
            <button class="text-xl">🔍</button>
        </div>
    </div>


    <!-- Content Container -->
    <div class="max-w-5xl mx-auto mt-10 space-y-4">

        @forelse($items as $item)
            <div class="bg-white p-4 rounded-xl shadow-sm flex gap-4 hover:shadow-lg transition cursor-pointer">

                {{-- Image --}}
                <div class="w-24 h-24 rounded-lg overflow-hidden bg-gray-200">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover" />
                    @else
                        <span class="text-gray-400 flex items-center justify-center h-full text-sm">No Image</span>
                    @endif
                </div>

                {{-- Item Info --}}
                <div class="flex-1">
                    <h3 class="font-semibold text-lg text-gray-900">{{ $item->name }}</h3>
                    
                    <p class="text-sm text-gray-700">{{ $item->owner->name }}</p>
                    <p class="text-xs text-gray-500">📍 Asrama / Lokasi</p>

                    <span class="inline-block px-3 py-1 bg-[#B7E4EF] text-[#0C6974] text-xs rounded-md mt-2">
                        Tersedia
                    </span>
                </div>

                {{-- Button --}}
                <div class="flex items-center">
                    <a href="{{ route('borrow.create', $item->id) }}"
                        class="px-4 py-2 rounded-lg bg-[#2DA6B4] hover:bg-[#1b8391] text-white font-semibold text-sm transition">
                        Pinjam
                    </a>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 py-10">Belum ada barang tersedia.</p>
        @endforelse

        <!-- Pagination -->
        <div class="mt-6">
            {{ $items->links() }}
        </div>
    </div>

</x-app-layout>
