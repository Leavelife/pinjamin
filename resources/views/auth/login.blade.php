<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-[#CDECF0]">

        <!-- Brand Header -->
        <div class="w-full bg-[#0C8A9A] py-4 px-6 flex items-center gap-3">
            <div class="bg-white w-10 h-10 rounded-md flex items-center justify-center">
                📦
            </div>
            <div>
                <h1 class="text-white font-bold text-xl">Pinjam.in</h1>
                <p class="text-white text-xs">Pinjam barang, bangun kepercayaan</p>
            </div>
        </div>

        <!-- Title -->
        <div class="text-center mt-10">
            <h2 class="text-[#0D5D68] font-bold text-3xl">Masuk <span class="text-[#0C8A9A]">/ Log in</span></h2>
            <p class="text-xs text-gray-600 mt-1">Silahkan isi dengan identitas yang sesuai</p>
        </div>

        <!-- Form Card -->
        <div class="bg-transparent shadow-lg rounded-xl p-8 w-[450px] mt-6">

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" required autofocus
                        class="w-full mt-2 px-4 py-3 rounded-lg border focus:ring-2 focus:ring-[#0C8A9A] focus:outline-none"
                        placeholder="Masukkan email Anda" value="{{ old('email') }}">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="text-sm font-medium text-gray-700">Password / Kata sandi</label>
                    <input id="password" type="password" name="password" required
                        class="w-full mt-2 px-4 py-3 rounded-lg border focus:ring-2 focus:ring-[#0C8A9A] focus:outline-none"
                        placeholder="Masukkan password / kata sandi Anda">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Remember + Forgot -->
                <div class="flex justify-between items-center text-sm mb-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember"
                            class="rounded border-gray-300">
                        Ingat saya
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-gray-500 hover:text-[#0C8A9A]">
                            Lupa kata sandi
                        </a>
                    @endif
                </div>

                <!-- Button -->
                <button
                    class="w-full bg-[#2DA6B4] hover:bg-[#238893] text-white py-3 rounded-lg font-semibold transition">
                    Masuk
                </button>

                <!-- Register Link -->
                <p class="text-center text-sm mt-4 text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-[#0C8A9A] font-semibold">Daftar</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
