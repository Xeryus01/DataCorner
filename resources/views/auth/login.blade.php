<x-guest-layout>
  <!-- Session Status -->
  <x-auth-session-status :status="session('status')" />
  <div class="flex flex-col justify-center items-center gap-3 mb-10">
    <h1 class="text-3xl font-bold mt-4">Selamat Datang!</h1>
    <p class="text-gray-600 text-base text-center">Masuk ke akun Anda untuk melanjutkan pembelajaran statistik</p>
  </div>
  <form method="POST" action="{{ route('login') }}">
    @csrf
    <!-- Email Address -->
    <div>
      <x-input-label for="email" :value="__('Email')" />
      <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
        autofocus autocomplete="username" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
      <x-input-label for="password" :value="__('Password')" />
      <div class="relative">
        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
          autocomplete="current-password" />
        <button type="button" onclick="togglePassword()"
          class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
          <!-- Mata terbuka -->
          <svg id="eyeIconOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
          </svg>
          <!-- Mata tertutup -->
          <svg id="eyeIconClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a10.05 10.05 0 013.29-4.568m3.522-1.77A9.956 9.956 0 0112 5c4.478 0 8.269 2.943 9.543 7a9.96 9.96 0 01-1.249 2.427M15 12a3 3 0 01-3 3m0 0a3 3 0 01-3-3m3 3L3 3l18 18" />
          </svg>
        </button>
      </div>

      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Remember Me -->
    <div class="flex items-center justify-between mt-4">
      <label for="remember_me" class="inline-flex items-center">
        <input id="remember_me" type="checkbox" class="rounded border-black text-button shadow-sm focus:ring-button"
          name="remember">
        <span class="ms-2 text-sm">{{ __('Remember me') }}</span>
      </label>
      {{-- @if (Route::has('password.request'))
        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          href="{{ route('password.request') }}">
          {{ __('Forgot your password?') }}
        </a>
      @endif --}}
    </div>

    <div class="flex items-center justify-end gap-4 mt-4">
      <x-primary-button>
        {{ __('Masuk') }}
      </x-primary-button>
    </div>
  </form>
  <div class="flex items-center justify-center gap-1 mt-4">
    <p>Belum punya akun?</p>
    <a href="{{ route('register') }}" class="text-primary font-semibold hover:underline">
      Daftar Sekarang
    </a>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById("password");
      const eyeOpen = document.getElementById("eyeIconOpen");
      const eyeClosed = document.getElementById("eyeIconClosed");

      if (input.type === "password") {
        input.type = "text";
        eyeOpen.classList.add("hidden");
        eyeClosed.classList.remove("hidden");
      } else {
        input.type = "password";
        eyeOpen.classList.remove("hidden");
        eyeClosed.classList.add("hidden");
      }
    }
  </script>
</x-guest-layout>
