<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>BPS User | Login</title>
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

      .card-shadow {
        border-radius: 1.5rem;
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

    <!-- Left Section - Welcome -->
    <section class="w-full lg:w-1/2 gradient-bg px-8 py-12 flex flex-col items-center justify-center relative overflow-hidden">
      <!-- Decorative circles -->
      <div class="absolute top-0 left-0 w-72 h-72 bg-white opacity-5 rounded-full -translate-x-36 -translate-y-36"></div>
      <div class="absolute bottom-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full translate-x-48 translate-y-48"></div>

      <div class="relative text-center fade-in-up">
        <h1 class="text-white font-bold text-4xl lg:text-5xl mb-4">
          Selamat Datang di Datapedia
        </h1>
        <div class="w-20 h-1 bg-white mx-auto mb-6 rounded-full"></div>
        <p class="text-white/90 text-lg mb-8 max-w-xs mx-auto">
          Login dengan nomor handphone yang terdaftar untuk mengakses informasi dan layanan BPS.
        </p>
        <!-- <div class="space-y-4 text-left max-w-sm mx-auto mb-8">
          <div class="flex gap-3 items-start">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/20 text-white">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
              </svg>
            </span>
            <p class="text-white/85 text-sm leading-relaxed">Akses layanan dengan cepat tanpa menu tersembunyi.</p>
          </div>
          <div class="flex gap-3 items-start">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/20 text-white">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5s-3 1.343-3 3 1.343 3 3 3z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.4 15a7 7 0 10-14.8 0A7 7 0 0012 22a7 7 0 007.4-7z"/>
              </svg>
            </span>
            <p class="panel-note text-sm leading-relaxed">Antarmuka bersih dengan petunjuk yang jelas untuk setiap input.</p>
          </div>
          <div class="flex gap-3 items-start">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/20 text-white">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3H8a2 2 0 00-2 2v2h12V5a2 2 0 00-2-2z"/>
              </svg>
            </span>
            <p class="panel-note text-sm leading-relaxed">Pastikan nomor Anda aktif agar notifikasi dan reset password berjalan lancar.</p>
          </div>
        </div> -->
        <div class="icon-bounce delay-300">
          <img src="{{ asset('image/loginUser.png') }}" alt="Login Illustration"
               class="h-64 lg:h-80 object-contain drop-shadow-2xl">
        </div>
      </div>
    </section>

    <!-- Right Section - Login Form -->
    <section class="w-full lg:w-1/2 glass-effect shadow-2xl p-8 lg:p-12 flex flex-col justify-center">
    <form action="{{ route('prosesloginUser') }}" method="POST" class="w-full max-w-md mx-auto">
        @csrf

        <!-- Error Messages -->
        @if($errors->has('invalid_no_hp') || $errors->has('invalid_password'))
          <div class="bg-red-50 border-l-4 border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6 fade-in-up">
            <div class="flex items-center">
              <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
              </svg>
              {{ $errors->first('invalid_no_hp') ?? $errors->first('invalid_password') }}
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
          <h2 class="text-3xl font-bold text-slate-900 mb-2">Silahkan Masuk</h2>
          <p class="text-slate-500">Masuk ke akun Datapedia Anda untuk menggunakan semua fitur.</p>
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
          @if ($errors->has('no_hp'))
            <p class="text-red-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                {{ $errors->first('no_hp') }}
            </p>
          @endif
        </div>

        <div class="mb-8 fade-in-up delay-300">
    <label for="password" class="block text-primary form-label font-medium text-sm mb-2">Password</label>
    <div class="relative">
        {{-- Icon Kunci --}}
        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>

        {{-- Input Password --}}
        <input type="password" name="password" id="password" placeholder="Masukkan password Anda" value="{{ old('password') }}" autocomplete="current-password"
               class="w-full py-4 px-12 pr-12 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white input-focus transition-all duration-300 text-gray-700" aria-label="Password">

        {{-- Icon Toggle Visibility --}}
        <button type="button" onclick="togglePasswordVisibility()" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-200" aria-label="Toggle password visibility">
            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
        </button>
    </div>

        @if ($errors->has('password'))
            <p class="text-red-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                {{ $errors->first('password') }}
            </p>
        @endif
</div>

<div class="flex items-center justify-between mb-8 fade-in-up delay-300">
    <label class="flex items-center gap-2 cursor-pointer">
        <input type="checkbox" name="remember" value="1" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary">
        <span class="text-primary font-medium text-sm">Ingat saya</span>
    </label>
    <a href="{{ route('password.request') }}" class="text-primary text-sm font-semibold hover:underline transition-colors duration-200">
        Lupa Password?
    </a>
</div>


        <!-- Login Button -->
        <button type="submit" id="submitBtn" class="w-full btn-primary py-4 rounded-xl text-white font-semibold text-lg mb-6 fade-in-up delay-400 relative transition-all duration-300 hover:shadow-lg disabled:opacity-70 disabled:cursor-not-allowed">
          <span id="submitText" class="flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            Masuk
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
            Belum Memiliki Akun?
            <a href="{{ route('registerUser') }}" class="text-primary hover:underline font-semibold ml-1 transition-colors duration-300">
              Bikin akun dulu yuk!!
            </a>
          </p>
        </div>
      </form>
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
    // Toggle Password Visibility
    function togglePasswordVisibility() {
        const input = document.getElementById("password");
        const icon = document.getElementById("eyeIcon");

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
        const passwordInput = document.getElementById('password');
        const submitBtn = document.getElementById('submitBtn');

        function validateForm() {
            const isPhoneValid = noHpInput.value.trim().length >= 10;
            const isPasswordValid = passwordInput.value.trim().length >= 6;
            
            submitBtn.disabled = !(isPhoneValid && isPasswordValid);
        }

        noHpInput.addEventListener('input', validateForm);
        passwordInput.addEventListener('input', validateForm);

        // Initial validation
        validateForm();
    });
  </script>
</body>
</html>
