<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permintaan Peminjaman Barang Saya') }}
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
                    <h3 class="text-lg font-semibold mb-4">Permintaan Peminjaman Menunggu</h3>

                    @if($requests->count())
                        <div class="space-y-4">
                            @foreach($requests as $request)
                                <div class="border rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h4 class="text-lg font-semibold">{{ $request->item->name }}</h4>
                                            <p class="text-sm text-gray-600">Peminjam: <strong>{{ $request->borrower->name }}</strong></p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-3 gap-4 mb-4 text-sm">
                                        <div>
                                            <span class="text-gray-600">Mulai:</span>
                                            <p class="font-semibold">{{ $request->start_date->format('d M Y') }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Hingga:</span>
                                            <p class="font-semibold">{{ $request->end_date->format('d M Y') }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Durasi:</span>
                                            <p class="font-semibold">{{ $request->end_date->diffInDays($request->start_date) }} hari</p>
                                        </div>
                                    </div>

                                    @if($request->message)
                                        <div class="mb-4 p-3 bg-gray-50 rounded border-l-4 border-blue-500">
                                            <p class="text-sm text-gray-700"><strong>Pesan:</strong> {{ $request->message }}</p>
                                        </div>
                                    @endif

                                    <div class="flex gap-2 pt-3 border-t">
                                        <form action="{{ route('borrow.approve', $request->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                                                ✓ Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('borrow.reject', $request->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded"
                                                onclick="return confirm('Yakin ingin menolak permintaan ini?')">
                                                ✗ Tolak
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-6">
                            {{ $requests->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-600">Tidak ada permintaan peminjaman yang menunggu.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
