<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>BPS User | Daftar</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    :root {
      --primary-color: #002B6A;
      --primary-light: #003d8a;
      --primary-dark: #001a3d;
    }

    .bg-primary {
      background-color: var(--primary-color);
    }

    .text-primary {
      color: var(--primary-color);
    }

    .border-primary {
      border-color: var(--primary-color);
    }

    .focus\:ring-primary:focus {
      --tw-ring-color: var(--primary-color);
    }

    .hover\:bg-primary\/90:hover {
      background-color: var(--primary-light);
    }

    .gradient-bg {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
    }

    .card-shadow {
      box-shadow: 0 25px 50px -12px rgba(0, 43, 106, 0.25);
    }

    .input-focus:focus {
      transform: translateY(-1px);
      box-shadow: 0 10px 25px rgba(0, 43, 106, 0.1);
    }

    .floating-label {
      transition: all 0.3s ease;
    }

    .input-container:focus-within .floating-label {
      transform: translateY(-20px) scale(0.85);
      color: var(--primary-color);
    }

    .input-container.has-value .floating-label {
      transform: translateY(-20px) scale(0.85);
      color: var(--primary-color);
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in-up {
      animation: fadeInUp 0.6s ease-out;
    }

    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }

    .glass-effect {
      backdrop-filter: blur(18px);
      background: #ffffff;
      border: 1px solid rgba(148, 163, 184, 0.18);
      box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
    }

    .btn-primary {
      background: #0f172a;
      transition: all 0.25s ease;
      color: #ffffff;
      box-shadow: 0 14px 30px rgba(15, 23, 42, 0.17);
    }

    .btn-primary:hover {
      transform: translateY(-1px);
      box-shadow: 0 20px 36px rgba(15, 23, 42, 0.22);
    }

    .form-label {
      color: #0f172a;
    }

    .form-help {
      color: #64748b;
    }

    .panel-heading {
      color: #ffffff;
    }

    .panel-copy {
      color: rgba(255, 255, 255, 0.88);
    }

    .panel-note {
      color: rgba(255, 255, 255, 0.75);
    }

    .icon-bounce {
      animation: bounce 2s infinite;
    }

    @keyframes bounce {
      0%, 20%, 53%, 80%, 100% {
        animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
        transform: translate3d(0,0,0);
      }
      40%, 43% {
        animation-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
        transform: translate3d(0, -8px, 0);
      }
      70% {
        animation-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
        transform: translate3d(0, -4px, 0);
      }
      90% {
        transform: translate3d(0, -2px, 0);
      }
    }

    /* Mobile Optimization */
    @media (max-width: 768px) {
      input[type="text"],
      input[type="email"],
      input[type="tel"],
      input[type="password"],
      input[type="number"] {
        font-size: 16px;
      }

      .glass-effect {
        background: rgba(255, 255, 255, 1);
      }
    }

    /* Form Input States */
    input:valid {
      border-color: #4ade80;
    }

    input[type="tel"]::-webkit-outer-spin-button,
    input[type="tel"]::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
  </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 flex items-center justify-center p-4">

  <main class="w-full max-w-5xl mx-auto rounded-3xl flex flex-col lg:flex-row card-shadow bg-white overflow-hidden">

    <!-- Right Section - Login Form -->
    <section class="w-full lg:w-1/2 glass-effect shadow-2xl p-8 lg:p-12 flex flex-col justify-center">
      <form action="{{ route('prosesregisterUser') }}" method="POST" class="w-full max-w-md mx-auto">
        @csrf

        <!-- Error Messages -->
        @if($errors->has('invalid_no_hp') || $errors->has('invalid_nama'))
          <div class="bg-red-50 border-l-4 border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6 fade-in-up">
            <div class="flex items-center">
              <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
              </svg>
              {{ $errors->first('invalid_no_hp') ?? $errors->first('invalid_nama') }}
            </div>
          </div>
        @endif

        <!-- Success Message -->
        @if (session('success'))
          <div class="bg-green-50 border-l-4 border-green-400 text-green-700 px-6 py-4 rounded-lg mb-6 fade-in-up">
            <div class="flex items-center">
              <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
              </svg>
              {{ session('success') }}
            </div>
          </div>
        @endif

        <!-- Form Header -->
        <div class="text-center mb-8 fade-in-up delay-100">
          <h2 class="text-3xl font-bold text-slate-900 mb-2">Buat Akun Baru</h2>
          <p class="text-slate-500">Gratis dan mudah. Gunakan akun Anda untuk akses cepat semua layanan Datapedia.</p>
        </div>

        <!-- Phone Number Input -->
        <div class="mb-6 fade-in-up delay-200">
          <label for="no_hp" class="block text-primary form-label font-medium text-sm mb-2">Nomor Handphone</label>
          <div class="relative">
            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
              <span class="text-sm font-medium">+62</span>
            </div>
            <input type="tel" name="no_hp" id="no_hp" placeholder="812345678901" autocomplete="tel"
                   class="w-full py-4 px-12 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white input-focus transition-all duration-300 text-gray-700"
                   value="{{ old('no_hp') }}"
                   aria-label="Nomor handphone"
                   required>
          </div>
          <p class="form-help text-xs mt-2">Masukkan nomor tanpa kode negara (mulai dari 8)</p>
          @error('no_hp')
            <p class="text-red-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </p>
          @enderror
        </div>

      <!-- Email Input -->
        <div class="mb-6 fade-in-up delay-200">
          <label for="email" class="block text-primary form-label font-medium text-sm mb-2">Email</label>
          <div class="relative">
            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
            </div>
            <input type="email" name="email" id="email" placeholder="contoh@gmail.com" autocomplete="email"
                   class="w-full py-4 px-12 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white input-focus transition-all duration-300 text-gray-700"
                   value="{{ old('email') }}"
                   aria-label="Email"
                   required>
          </div>
          @error('email')
             <p class="text-red-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
             </p>
          @enderror
        </div>

        <!-- Username Input -->
        <div class="mb-6 fade-in-up delay-300">
          <label for="nama" class="block text-primary form-label font-medium text-sm mb-2">Username</label>
          <div class="relative">
            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </div>
            <input type="text" name="nama" id="nama" placeholder="username123" autocomplete="username"
                   class="w-full py-4 px-12 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white input-focus transition-all duration-300 text-gray-700"
                   value="{{ old('nama') }}"
                   aria-label="Username"
                   required>
          </div>
          <p class="form-help text-xs mt-2">Gunakan huruf, angka, dan garis bawah (3-20 karakter)</p>
          @error('nama')
            <p class="text-red-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </p>
          @enderror
        </div>

        <!-- Password Input -->
        <div class="mb-8 fade-in-up delay-300">
          <label for="password" class="block text-primary form-label font-medium text-sm mb-2">Password</label>
          <div class="relative">
              {{-- Icon Kunci --}}
              <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                  </svg>
              </div>

              {{-- Input Password --}}
              <input type="password" name="password" id="password" placeholder="Buat password yang kuat" autocomplete="new-password"
                    class="w-full py-4 px-12 pr-12 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white input-focus transition-all duration-300 text-gray-700"
                    aria-label="Password"
                    required>

              {{-- Icon Toggle Visibility --}}
              <button type="button" onclick="toggleRegisterPasswordVisibility()" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-200" aria-label="Toggle password visibility">
                  <svg id="registerEyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  </svg>
              </button>
          </div>

          <p class="form-help text-xs mt-2">Minimal 8 karakter, gunakan kombinasi huruf, angka, dan simbol</p>
          @error('password')
          <p class="text-red-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
              </p>
          @enderror
      </div>


        <!-- Register Button -->
        <button type="submit" id="submitBtn" class="w-full btn-primary py-4 rounded-xl text-white font-semibold text-lg mb-6 fade-in-up delay-400 relative transition-all duration-300 hover:shadow-lg disabled:opacity-70 disabled:cursor-not-allowed">
          <span id="submitText" class="flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Daftar Akun
          </span>
          <span id="loadingSpinner" class="hidden absolute inset-0 flex items-center justify-center">
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
          </span>
        </button>

        <!-- Registration Link -->
        <div class="text-center fade-in-up delay-400">
          <p class="text-gray-600">
            Sudah Memiliki Akun?
            <a href="{{ route('loginUser') }}" class="text-primary hover:underline font-semibold ml-1 transition-colors duration-300">
              Kembali ke Halaman Login
            </a>
          </p>
        </div>
      </form>
    </section>

     <!-- Left Section - Welcome -->
    <section class="w-full lg:w-1/2 gradient-bg px-8 py-12 hidden lg:flex flex-col items-center justify-center relative overflow-hidden">
      <!-- Decorative circles -->
      <div class="absolute top-0 left-0 w-72 h-72 bg-white opacity-5 rounded-full -translate-x-36 -translate-y-36"></div>
      <div class="absolute bottom-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full translate-x-48 translate-y-48"></div>

      <div class="relative text-center fade-in-up">
        <h1 class="text-white font-bold text-4xl lg:text-5xl mb-4">
          Bergabunglah Sekarang
        </h1>
        <div class="w-20 h-1 bg-white mx-auto mb-6 rounded-full"></div>
        <p class="panel-copy text-lg mb-8 max-w-xs mx-auto">
          Daftar dengan cepat dan aman untuk mendapatkan akses penuh ke fitur Datapedia.
        </p>
        <!-- <div class="space-y-4 text-left max-w-sm mx-auto mb-8">
          <div class="flex gap-3 items-start">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/20 text-white">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
              </svg>
            </span>
            <p class="text-white/85 text-sm leading-relaxed">Keamanan data dengan password yang kuat dan nomor aktif.</p>
          </div>
          <div class="flex gap-3 items-start">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/20 text-white">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7a5 5 0 100 10 5 5 0 000-10z"/>
              </svg>
            </span>
            <p class="text-white/85 text-sm leading-relaxed">Proses pendaftaran yang mudah dan langsung aktif.</p>
          </div>
          <div class="flex gap-3 items-start">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/20 text-white">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </span>
            <p class="text-white/85 text-sm leading-relaxed">Dapatkan notifikasi penting dan pemulihan kata sandi dengan mudah.</p>
          </div>
        </div> -->
        <div class="icon-bounce delay-300">
          <img src="{{ asset('image/registerUser.png') }}" alt="Register Illustration"
               class="h-64 lg:h-80 object-contain drop-shadow-2xl">
        </div>
      </div>
    </section>

  </main>

  <!-- Session Timeout Script -->
  @if (session('session_timeout'))
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      Swal.fire({
        icon: 'warning',
        title: 'Sesi Anda telah berakhir',
        text: 'Silakan login kembali untuk melanjutkan.',
        confirmButtonText: 'Login Ulang',
        allowOutsideClick: false,
        allowEscapeKey: false,
        confirmButtonColor: '#002B6A'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "{{ route('loginUser') }}";
        }
      });
    });
  </script>
  @endif

  <!-- Floating Label Script -->
  <script>
    // Toggle Register Password Visibility
    function toggleRegisterPasswordVisibility() {
        const input = document.getElementById("password");
        const icon = document.getElementById("registerEyeIcon");

        if (input.type === "password") {
            input.type = "text";
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.174-3.362m1.415-3.63A10.05 10.05 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-2.174 3.362M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            `;
        } else {
            input.type = "password";
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    }

    // Form Submission with Loading State
    document.querySelector('form').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const loadingSpinner = document.getElementById('loadingSpinner');
        
        submitBtn.disabled = true;
        submitText.classList.add('hidden');
        loadingSpinner.classList.remove('hidden');
    });

    // Real-time Input Validation
    document.addEventListener('DOMContentLoaded', function() {
        const noHpInput = document.getElementById('no_hp');
        const emailInput = document.getElementById('email');
        const namaInput = document.getElementById('nama');
        const passwordInput = document.getElementById('password');
        const submitBtn = document.getElementById('submitBtn');

        function validateForm() {
            const isPhoneValid = noHpInput.value.trim().length >= 10;
            const isEmailValid = emailInput.value.includes('@') && emailInput.value.includes('.');
            const isUsernameValid = namaInput.value.trim().length >= 3;
            const isPasswordValid = passwordInput.value.length >= 8;
            
            submitBtn.disabled = !(isPhoneValid && isEmailValid && isUsernameValid && isPasswordValid);
        }

        noHpInput.addEventListener('input', validateForm);
        emailInput.addEventListener('input', validateForm);
        namaInput.addEventListener('input', validateForm);
        passwordInput.addEventListener('input', validateForm);

        // Initial validation
        validateForm();
    });
  </script>


</body>

</html>
