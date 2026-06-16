<x-layout-web>
  <section class="w-full px-4 md:px-8 lg:px-36 py-16 bg-[#EEF0F2] min-h-screen">
    <div class="max-w-4xl mx-auto">
      <!-- Header with Navigation -->
      <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Edit Profil</h1>
        <p class="text-gray-600">Perbarui informasi profil dan preferensi akun Anda</p>
      </div>

      <form action="{{ route('profil.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Main Edit Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
          <!-- Profile Photo Section -->
          <div class="relative bg-primary px-8 py-5">
            <div class="relative flex flex-col items-center gap-6">
              <!-- Current Profile Photo -->
              <div class="flex flex-col items-center justify-center gap-4">
                <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg overflow-hidden bg-white">
                  @if ($user->foto)
                    <img src="{{ asset('storage/' . $user->foto) }}" class="w-full h-full object-cover"
                      alt="Profile Photo" id="preview-image">
                  @else
                    <img src="{{ Avatar::create($user->name)->toBase64() }}" class="w-full h-full object-cover"
                      alt="Generated Avatar" id="preview-image">
                  @endif
                </div>

                <label for="foto"
                  class="cursor-pointer inline-flex items-center gap-2 bg-white bg-opacity-20 hover:bg-opacity-30 backdrop-blur-sm border border-white border-opacity-30 px-6 py-3 rounded-xl text-white font-medium transition-all duration-300 hover:scale-105">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                  </svg>
                  Unggah Foto Baru
                </label>
                <input type="file" id="foto" name="foto" class="hidden" accept="image/*"
                  onchange="previewImage(this)">
              </div>
            </div>
          </div>

          <!-- Form Fields -->
          <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <!-- Personal Information -->
              <div class="space-y-6">
                <div class="flex items-center gap-3 mb-6">
                  <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                  </div>
                  <h3 class="text-lg font-semibold text-gray-900">Informasi Personal</h3>
                </div>

                <!-- Name -->
                <div>
                  <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <x-input-label for="name" :value="__('Nama Lengkap')" />
                  </div>
                  <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$user->name"
                    required autocomplete="name" />
                  <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                  <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                      </path>
                    </svg>
                    <x-input-label for="name" :value="__('Email')" />
                  </div>
                  <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$user->email"
                    required autocomplete="email" />
                  <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Jenis Kelamin --}}
                <div class="mt-4">
                  <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                      </path>
                    </svg>
                    <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                  </div>
                  <select name="jenis_kelamin" id="jenis_kelamin" class="block mt-1 w-full" required>
                    <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-laki" {{ $user->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                    </option>
                    <option value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan
                    </option>
                  </select>
                  <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                </div>
              </div>

              <!-- Contact & Organization -->
              <div class="space-y-6">
                <div class="flex items-center gap-3 mb-6">
                  <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                      </path>
                    </svg>
                  </div>
                  <h3 class="text-lg font-semibold text-gray-900">Kontak & Organisasi</h3>
                </div>

                <!-- WhatsApp -->
                <div>
                  <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                      </path>
                    </svg>
                    <x-input-label for="no_hp" :value="__('Nomor WhatsApp')" />
                  </div>
                  <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp"
                    :value="$user->no_hp" required autocomplete="no_hp" />
                  <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                </div>

                <!-- Organization -->
                <div>
                  <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                      </path>
                    </svg>
                    <x-input-label for="instansi" :value="__('Sekolah/Perguruan Tinggi/Instansi')" />
                  </div>
                  <x-text-input id="instansi" class="block mt-1 w-full" type="text" name="instansi"
                    :value="$user->instansi" required autocomplete="organization" />
                  <x-input-error :messages="$errors->get('instansi')" class="mt-2" />
                </div>

                <!-- Photo Guidelines -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                  <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                      <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                    </div>
                    <div>
                      <h4 class="text-sm font-medium text-blue-900 mb-1">Tips Foto Profil</h4>
                      <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Gunakan foto dengan rasio 1:1 (persegi)</li>
                        <li>• Format yang didukung: JPG, PNG</li>
                        <li>• Ukuran maksimal: 2MB</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Change Password Form -->
            <!-- Header Section -->
            <div class="relative bg-red-600 rounded-xl px-8 py-6 mt-6">
              <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                  </svg>
                </div>
                <div>
                  <h2 class="text-xl font-bold text-white">Ubah Password</h2>
                  <p class="text-red-100 text-sm">Perbarui password Anda untuk keamanan yang lebih baik</p>
                </div>
              </div>
            </div>



            <!-- Form Fields -->
            <div class="pt-8">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- New Password -->
                <!-- Password -->
                <div>
                  <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                      </path>
                    </svg>
                    <x-input-label for="password" :value="__('Password Baru')" />
                  </div>
                  <div class="relative">
                    <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password"
                      autocomplete="new-password" />

                    <button type="button" onclick="togglePassword()"
                      class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                      <!-- Mata terbuka -->
                      <svg id="eyeIconOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                      </svg>

                      <!-- Mata tertutup -->
                      <svg id="eyeIconClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a10.05 10.05 0 013.29-4.568m3.522-1.77A9.956 9.956 0 0112 5c4.478 0 8.269 2.943 9.543 7a9.96 9.96 0 01-1.249 2.427M15 12a3 3 0 01-3 3m0 0a3 3 0 01-3-3m3 3L3 3l18 18" />
                      </svg>
                    </button>
                  </div>

                  <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm New Password -->
                <div>
                  <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                      </path>
                    </svg>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                  </div>


                  <div class="relative">
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                      name="password_confirmation" autocomplete="new-password" />

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
                      <svg id="eyeIconClosedConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a10.05 10.05 0 013.29-4.568m3.522-1.77A9.956 9.956 0 0112 5c4.478 0 8.269 2.943 9.543 7a9.96 9.96 0 01-1.249 2.427M15 12a3 3 0 01-3 3m0 0a3 3 0 01-3-3m3 3L3 3l18 18" />
                      </svg>
                    </button>
                  </div>

                  <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 mt-8">
              <button type="submit"
                class="flex-1 bg-primary hover:bg-[#00295A] text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Perubahan
              </button>
              <a href="{{ route('profil.show', $user->slug) }}"
                class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                  </path>
                </svg>
                Batal
              </a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
  <x-footer class="fill-[#EEF0F2]" />

  <script>
    function previewImage(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
          document.getElementById('preview-image').src = e.target.result;
        }

        reader.readAsDataURL(input.files[0]);
      }
    }

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
</x-layout-web>
