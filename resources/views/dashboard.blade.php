<x-app-layout>
    <x-sidebar/>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-6">
                <x-item-form 
                    :categories="$categories" 
                    action="{{ route('borrow-items.store') }}" 
                />
            </div>
            @php
                $items = \App\Models\Item::where('owner_id', auth()->id())->get();
            @endphp

            @if($items->count())
                <div class="mt-8">
                    <table class="table-auto w-full border">
                        <tr class="bg-gray-200">
                            <th class="p-2">Nama</th>
                            <th>Kategori</th>
                            <th>Kondisi</th>
                            <th>Gambar</th>
                        </tr>
                        @foreach($items as $item)
                        <tr>
                            <td class="p-2">{{ $item->name }}</td>
                            <td>{{ $item->category }}</td>
                            <td>{{ $item->condition }}</td>
                            <td>
                                @if($item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}" width="60">
                                @endif
                            </td>
                    </tr>
                    @endforeach
                </table>
            @endif

        </div>
    </div>
</x-app-layout>
