<x-guest-layout>
  <div class="flex flex-col justify-center items-center gap-3 mb-10">
    <h1 class="text-3xl font-bold mt-8">Pendaftaran Akun</h1>
    <p class="text-gray-600 text-base text-center">Daftarkan diri Anda untuk melanjutkan pembelajaran statistik</p>
  </div>
  <form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div>
      <x-input-label for="name" :value="__('Nama')" />
      <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
        autofocus autocomplete="name" />
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Email Address -->
    <div class="mt-4">
      <x-input-label for="email" :value="__('Email')" />
      <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
        autocomplete="username" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    {{-- Jenis Kelamin --}}
    <div class="mt-4">
      <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
      <select name="jenis_kelamin" id="jenis_kelamin" class="block mt-1 w-full" required>
        <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
      </select>
      <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
    </div>

    <!-- No HP -->
    <div class="mt-4">
      <x-input-label for="no_hp" :value="__('Nomor WhatsApp')" />
      <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp" :value="old('no_hp')" required
        autocomplete="tel" />
      <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
    </div>

    <div class="mt-4">
      <x-input-label for="instansi" :value="__('Sekolah/Perguruan Tinggi/Instansi')" />
      <x-text-input id="instansi" class="block mt-1 w-full" type="text" name="instansi" :value="old('instansi')" required
        autocomplete="organization" />
      <x-input-error :messages="$errors->get('instansi')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
      <x-input-label for="password" :value="__('Password')" />

      <div class="relative">
        <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required
          autocomplete="new-password" />

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

    <!-- Confirm Password -->
    <div class="mt-4">
      <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
      <div class="relative">
        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
          required autocomplete="new-password" />

        <button type="button" onclick="toggleConfirmPassword()"
          class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
          <!-- Mata terbuka -->
          <svg id="eyeIconOpenConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
          </svg>

          <!-- Mata tertutup -->
          <svg id="eyeIconClosedConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a10.05 10.05 0 013.29-4.568m3.522-1.77A9.956 9.956 0 0112 5c4.478 0 8.269 2.943 9.543 7a9.96 9.96 0 01-1.249 2.427M15 12a3 3 0 01-3 3m0 0a3 3 0 01-3-3m3 3L3 3l18 18" />
          </svg>
        </button>
      </div>

      <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="flex flex-col items-center justify-center mt-4">
      <x-primary-button>
        {{ __('Daftar') }}
      </x-primary-button>
      <div class="flex items-center justify-center gap-1 mt-4">
        <p>Sudah punya akun?</p>
        <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">
          Masuk Sekarang
        </a>
      </div>
    </div>
  </form>
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

    function toggleConfirmPassword() {
      const input = document.getElementById("password_confirmation");
      const eyeOpen = document.getElementById("eyeIconOpenConfirm");
      const eyeClosed = document.getElementById("eyeIconClosedConfirm");

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
