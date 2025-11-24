<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status Peminjaman Saya') }}
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Riwayat Peminjaman Saya</h3>

                    @if($requests->count())
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-100 border-b">
                                    <tr>
                                        <th class="px-4 py-2">Barang</th>
                                        <th class="px-4 py-2">Pemilik</th>
                                        <th class="px-4 py-2">Tanggal Mulai</th>
                                        <th class="px-4 py-2">Tanggal Akhir</th>
                                        <th class="px-4 py-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requests as $request)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3">
                                                <strong>{{ $request->item->name }}</strong>
                                            </td>
                                            <td class="px-4 py-3">{{ $request->owner->name }}</td>
                                            <td class="px-4 py-3">{{ $request->start_date->format('d M Y') }}</td>
                                            <td class="px-4 py-3">{{ $request->end_date->format('d M Y') }}</td>
                                            <td class="px-4 py-3">
                                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                                    @if($request->status === 'pending')
                                                        bg-yellow-100 text-yellow-800
                                                    @elseif($request->status === 'approved')
                                                        bg-blue-100 text-blue-800
                                                    @elseif($request->status === 'borrowed')
                                                        bg-purple-100 text-purple-800
                                                    @elseif($request->status === 'returned')
                                                        bg-green-100 text-green-800
                                                    @else
                                                        bg-red-100 text-red-800
                                                    @endif
                                                ">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-6">
                            {{ $requests->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-600 mb-4">Anda belum meminjam barang apapun.</p>
                            <a href="{{ route('borrow.index') }}" class="text-blue-600 hover:underline">Lihat barang yang tersedia</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
