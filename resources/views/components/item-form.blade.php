<div class="bg-gray-50 p-6 rounded-lg">
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div>
            <label class="block font-semibold text-gray-700 mb-2">Nama Barang</label>
            <input type="text" name="name" value="{{ old('name', $item->name ?? '') }}" required class="w-full border border-gray-300 rounded px-3 py-2">
            @error('name')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="category" class="block font-semibold text-gray-700 mb-2">Kategori</label>
            <select name="category" id="category" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="">--Pilih Kategori--</option>
                @if(isset($categories) && $categories->count())
                    @foreach($categories as $cat)
                        <option value="{{ $cat->name }}" {{ old('category') == $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                @endif
            </select>
            @error('category')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block font-semibold text-gray-700 mb-2">Deskripsi</label>
            <textarea name="description" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description', $item->description ?? '') }}</textarea>
            @error('description')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block font-semibold text-gray-700 mb-2">Foto Barang</label>
            <input type="file" name="image" accept="image/*" onchange="previewImage(event)" class="w-full border border-gray-300 rounded px-3 py-2">
            @error('image')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <img id="preview" style="width:120px;margin-top:10px;display:none;" class="rounded">

        <div>
            <label class="block font-semibold text-gray-700 mb-2">Kondisi Barang</label>
            <select name="condition" required class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="">--Pilih kondisi--</option>
                <option value="baru" {{ old('condition') == 'baru' ? 'selected' : '' }}>Baru</option>
                <option value="baik" {{ old('condition') == 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="rusak ringan" {{ old('condition') == 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                <option value="rusak" {{ old('condition') == 'rusak' ? 'selected' : '' }}>Rusak</option>
            </select>
            @error('condition')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        @if(isset($item) && $item->image)
            <div>
                <p class="font-semibold text-gray-700 mb-2">Gambar sekarang:</p>
                <img src="{{ asset('storage/'.$item->image) }}" width="120" class="rounded">
            </div>
        @endif

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
            {{ $isEdit ? 'Update' : 'Simpan' }}
        </button>
    </form>
</div>

<script>
    function previewImage(event) {
        const img = document.getElementById('preview');
        img.src = URL.createObjectURL(event.target.files[0]);
        img.style.display = 'block';
    }
</script>
