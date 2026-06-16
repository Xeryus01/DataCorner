<x-guest-layout>
    <div class="text-center mb-8 fade-in-up">
        <div class="mx-auto mb-4">
            <svg class="w-16 h-16 text-blue-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Verifikasi Email</h2>
        <p class="text-gray-600">{{ __('Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email dengan mengklik tautan yang baru saja kami kirimkan kepada Anda? Jika Anda tidak menerima email, kami dengan senang hati akan mengirimkan tautan lagi.') }}</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl fade-in-up delay-100">
            <p class="text-sm text-green-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.') }}
            </p>
        </div>
    @endif

    <div class="space-y-4 fade-in-up delay-200">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="w-full">
                {{ __('Kirim Ulang Email Verifikasi') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full px-6 py-4 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold text-sm rounded-xl transition ease-in-out duration-150">
                {{ __('Keluar') }}
            </button>
        </form>
    </div>
</x-guest-layout>
