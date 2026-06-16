<x-guest-layout>
    <div class="text-center mb-8 fade-in-up">
        <div class="mx-auto mb-4">
            <svg class="w-16 h-16 text-blue-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Konfirmasi Password</h2>
        <p class="text-gray-600">{{ __('Ini adalah area aman dari aplikasi. Harap konfirmasi password Anda sebelum melanjutkan.') }}</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-6 fade-in-up delay-100">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative mt-2">
                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <x-text-input id="password" class="block w-full pl-12"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="Masukkan password Anda" />
            </div>

            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="flex justify-end fade-in-up delay-200">
            <x-primary-button>
                {{ __('Konfirmasi') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
