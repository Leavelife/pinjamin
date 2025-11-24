<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="rounded-md bg-red-50 p-4">
                        <h3 class="text-sm font-medium text-red-800">Ada {{ count($errors->all()) }} kesalahan:</h3>
                        <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Nama Barang -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Nama Barang <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name"
                        value="{{ old('name', $item->name) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('name') border-red-500 @else border @enderror"
                        required
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">
                        Kategori
                    </label>
                    <select 
                        name="category" 
                        id="category"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border"
                    >
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ $item->category === $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">
                        Deskripsi
                    </label>
                    <textarea 
                        name="description" 
                        id="description"
                        rows="4"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >{{ old('description', $item->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kondisi -->
                <div>
                    <label for="condition" class="block text-sm font-medium text-gray-700">
                        Kondisi <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="condition" 
                        id="condition"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border @error('condition') border-red-500 @enderror"
                        required
                    >
                        <option value="">Pilih Kondisi</option>
                        <option value="baru" @selected(old('condition', $item->condition) == 'baru')>Baru</option>
                        <option value="baik" @selected(old('condition', $item->condition) == 'baik')>Baik</option>
                        <option value="rusak ringan" @selected(old('condition', $item->condition) == 'rusak ringan')>Rusak Ringan</option>
                        <option value="rusak" @selected(old('condition', $item->condition) == 'rusak')>Rusak</option>
                    </select>
                    @error('condition')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">
                        Gambar Barang
                    </label>
                    
                    @if ($item->image)
                        <div class="mt-2 mb-4">
                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="w-32 h-32 object-cover rounded">
                            <p class="text-sm text-gray-500 mt-2">Gambar saat ini</p>
                        </div>
                    @endif

                    <input 
                        type="file" 
                        name="image" 
                        id="image"
                        accept="image/*"
                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >
                    <p class="mt-1 text-sm text-gray-500">Biarkan kosong jika tidak ingin mengubah gambar</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-4">
                    <button 
                        type="submit" 
                        class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
                    >
                        Simpan Perubahan
                    </button>
                    <a 
                        href="{{ route('dashboard') }}" 
                        class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors text-center"
                    >
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
