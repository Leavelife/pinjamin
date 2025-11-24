<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pinjam Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Success/Error Messages --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Items Grid --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Barang Tersedia untuk Dipinjam</h3>

                    @if($items->count())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($items as $item)
                                <div class="border rounded-lg overflow-hidden hover:shadow-lg transition">
                                    {{-- Item Image --}}
                                    <div class="bg-gray-200 h-48 flex items-center justify-center">
                                        @if($item->image)
                                            <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-gray-400">No Image</span>
                                        @endif
                                    </div>

                                    {{-- Item Info --}}
                                    <div class="p-4">
                                        <h4 class="font-semibold text-lg mb-2">{{ $item->name }}</h4>
                                        
                                        <div class="text-sm text-gray-600 mb-2">
                                            <p><strong>Kategori:</strong> {{ $item->category }}</p>
                                            <p><strong>Kondisi:</strong> {{ ucfirst($item->condition) }}</p>
                                        </div>

                                        @if($item->description)
                                            <p class="text-sm text-gray-700 mb-3 line-clamp-2">{{ $item->description }}</p>
                                        @endif

                                        <p class="text-sm text-gray-600 mb-4">
                                            <strong>Pemilik:</strong> {{ $item->owner->name }}
                                        </p>

                                        <a href="{{ route('borrow.create', $item->id) }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded text-center">
                                            Pinjam Barang Ini
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-6">
                            {{ $items->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-600 mb-4">Belum ada barang yang tersedia untuk dipinjam.</p>
                            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Kembali ke Dashboard</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
