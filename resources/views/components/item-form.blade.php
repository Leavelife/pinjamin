<div>
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div>
            <label>Nama Barang</label>
            <input type="text" name="name" value="{{ old('name', $item->name ?? '') }}" required>
        </div>

        <div>
            <label for="category">Kategori</label>
            <input type="text" name="category" id="category" class="border rounded w-full">
        </div>

        <div>
            <label>Deskripsi</label>
            <textarea name="description">{{ old('description', $item->description ?? '') }}</textarea>
        </div>

        <div>
            <label>Foto Barang</label>
            <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
        </div>

        <img id="preview" style="width:120px;margin-top:10px;display:none;">

        <div>
            <label>Kondisi Barang</label>
            <select name="condition" required>
                <option value="">--Pilih kondisi--</option>
                <option value="baru">Baru</option>
                <option value="baik">Baik</option>
                <option value="rusak ringan">Rusak Ringan</option>
                <option value="rusak">Rusak</option>
            </select>
        </div>


        @if(isset($item) && $item->image)
            <p>Gambar sekarang:</p>
            <img src="{{ asset('storage/'.$item->image) }}" width="120">
        @endif

        <button type="submit">Simpan</button>
    </form>
</div>

<script>
    function previewImage(event) {
        const img = document.getElementById('preview');
        img.src = URL.createObjectURL(event.target.files[0]);
        img.style.display = 'block';
    }
</script>
