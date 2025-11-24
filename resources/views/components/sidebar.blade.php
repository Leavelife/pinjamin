<nav class="w-full">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">

        <h1 class="text-lg font-bold tracking-wide">Pinjam.in</h1>

        <ul class="flex space-x-6">
            <li><a href="{{ route('dashboard') }}" class="hover:text-yellow-300">Barang Saya</a></li>
            <li><a href="{{ route('items-form') }}" class="hover:text-yellow-300">Tambahkan Barang</a></li>
            <li><a href="{{ route('borrow.status') }}" class="hover:text-yellow-300">Riwayat Pinjam</a></li>
            <li><a href="{{ route('borrow.index') }}" class="hover:text-yellow-300">Pinjam Barang</a></li>
        </ul>

    </div>
</nav>
