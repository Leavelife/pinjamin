<x-app-layout>
    <x-slot name="header">
        <h2 class="flex font-semibold text-xl text-gray-800 leading-tight">
            <x-sidebar/>
        </h2>
    </x-slot>

    <div class="">
        <div class="">
            {{-- Items Table --}}
            <!-- ini untuk menampilkan daftar barang milik user yang sedang login -->
            @php
                $items = \App\Models\Item::where('owner_id', auth()->id())->get();
            @endphp

            @if($items->count())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="">
                        <h3 class="text-lg font-semibold mb-4">Daftar Barang Saya</h3>
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full border">
                                <tr class="bg-gray-200">
                                    <th class="p-2 text-left">Nama</th>
                                    <th class="p-2 text-left">Kategori</th>
                                    <th class="p-2 text-left">Kondisi</th>
                                    <th class="p-2 text-left">Gambar</th>
                                    <th class="p-2 text-left">Status</th>
                                    <th class="p-2 text-center">Aksi</th>
                                </tr>
                                
                                <!-- ini untuk menampilkan list bangnya -->
                                @foreach($items as $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-2">{{ $item->name }}</td>
                                    <td class="p-2">{{ $item->category }}</td>
                                    <td class="p-2">
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                                            @if($item->condition == 'baru') bg-green-100 text-green-800
                                            @elseif($item->condition == 'baik') bg-blue-100 text-blue-800
                                            @elseif($item->condition == 'rusak ringan') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif
                                        ">{{ $item->condition }}</span>
                                    </td>
                                    <td class="p-2">
                                        @if($item->image)
                                            <img src="{{ asset('storage/'.$item->image) }}" width="60" class="rounded">
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="p-2">
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                                            @if($item->status == 'available') bg-green-100 text-green-800
                                            @elseif($item->status == 'borrowed') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800
                                            @endif
                                        ">
                                            @if($item->status == 'available') Tersedia
                                            @elseif($item->status == 'borrowed') Dipinjam
                                            @else Tidak Aktif
                                            @endif
                                        </span>
                                    </td>
                                    <td class="p-2">
                                        <div class="flex gap-2 justify-center">
                                            <a 
                                                href="{{ route('items.edit', $item->id) }}" 
                                                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm transition"
                                            >
                                                Edit
                                            </a>
                                            <form 
                                                action="{{ route('items.destroy', $item->id) }}" 
                                                method="POST" 
                                                style="display:inline;"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit" 
                                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm transition"
                                                >
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-600">
                        Belum ada barang. <a href="{{ url('/items-form') }}" class="text-blue-600 hover:underline">Tambah barang baru</a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
