<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Peminjaman Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    {{-- Item Info --}}
                    <div class="mb-6 pb-6 border-b">
                        <h3 class="text-lg font-semibold mb-4">Detail Barang</h3>
                        
                        <div class="flex gap-4">
                            {{-- Item Image --}}
                            <div class="w-40 h-40 bg-gray-200 rounded flex-shrink-0 flex items-center justify-center">
                                @if($item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-gray-400">No Image</span>
                                @endif
                            </div>

                            {{-- Item Details --}}
                            <div class="flex-1">
                                <h4 class="text-2xl font-bold mb-2">{{ $item->name }}</h4>
                                
                                <dl class="space-y-2 text-sm">
                                    <div>
                                        <dt class="font-semibold text-gray-700">Kategori:</dt>
                                        <dd class="text-gray-600">{{ $item->category }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-semibold text-gray-700">Kondisi:</dt>
                                        <dd class="text-gray-600">{{ ucfirst($item->condition) }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-semibold text-gray-700">Pemilik:</dt>
                                        <dd class="text-gray-600">{{ $item->owner->name }}</dd>
                                    </div>
                                </dl>

                                @if($item->description)
                                    <div class="mt-4">
                                        <dt class="font-semibold text-gray-700 mb-1">Deskripsi:</dt>
                                        <dd class="text-gray-600">{{ $item->description }}</dd>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Borrow Form --}}
                    <h3 class="text-lg font-semibold mb-4">Informasi Peminjaman</h3>

                    <form action="{{ route('borrow.store', $item->id) }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">Tanggal Mulai Peminjaman</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}" required class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('start_date')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">Tanggal Akhir Peminjaman</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}" required class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('end_date')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">Pesan untuk Pemilik (Opsional)</label>
                            <textarea name="message" rows="4" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('message') }}</textarea>
                            @error('message')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                                Kirim Permintaan Peminjaman
                            </button>
                            <a href="{{ route('borrow.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded text-center">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
