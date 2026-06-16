<x-guest-layout>
    <div class="text-center mb-8 fade-in-up">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Lupa Password?</h2>
        <p class="text-gray-600">Tidak masalah. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan link reset password.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-6 fade-in-up delay-100">
            <x-input-label for="email" :value="__('Email')" />
            <div class="relative mt-2">
                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <x-text-input id="email" class="block w-full pl-12" type="email" name="email" :value="old('email')" required autofocus placeholder="example@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center justify-between mt-6 fade-in-up delay-200">
            <a href="{{ route('loginUser') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                Kembali ke Login
            </a>
            <x-primary-button>
                {{ __('Kirim Link Reset') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
