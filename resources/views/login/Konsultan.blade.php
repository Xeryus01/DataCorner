<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>BPS Konsultan | Login</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    :root {
      --primary-color: #002B6A;
      --primary-light: #003d8a;
    }

    .gradient-bg {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
    }

    .card-shadow {
      box-shadow: 0 25px 50px -12px rgba(0, 43, 106, 0.25);
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
      transition: all 0.3s ease;
    }

    .btn-primary:hover:not(:disabled) {
      transform: translateY(-2px);
      box-shadow: 0 15px 35px rgba(0, 43, 106, 0.3);
    }

    .btn-primary:disabled {
      opacity: 0.7;
      cursor: not-allowed;
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

    /* Mobile Optimization */
    @media (max-width: 768px) {
      input[type="text"],
      input[type="email"],
      input[type="password"] {
        font-size: 16px;
      }
    }
  </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 flex items-center justify-center p-4">

  <main class="w-full max-w-5xl mx-auto rounded-3xl flex flex-col lg:flex-row card-shadow bg-white overflow-hidden">

    <!-- Right Section - Login Form -->
    <section class="w-full lg:w-1/2 bg-white p-8 lg:p-12 flex flex-col justify-center">
      <form action="{{ route('prosesloginKonsultan') }}" method="POST" class="w-full max-w-md mx-auto">
        @csrf

        <!-- Error Messages -->
        @if($errors->any())
          <div class="bg-red-50 border-l-4 border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6 fade-in-up">
            <div class="flex items-center">
              <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
              </svg>
              <ul class="list-disc ml-2">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
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
          <h2 class="text-3xl font-bold text-gray-800 mb-2">Silahkan Login</h2>
          <p class="text-gray-600">Akses portal konsultasi dengan aman</p>
        </div>

        <!-- Email Input -->
        <div class="mb-6 fade-in-up delay-200">
          <label for="email" class="block text-primary font-medium text-sm mb-2">Email</label>
          <div class="relative">
            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
            </div>
            <input type="email" name="email" id="email" placeholder="konsultan@example.com" autocomplete="email"
                   class="w-full py-4 px-12 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-300 text-gray-700"
                   value="{{ old('email') }}"
                   aria-label="Email"
                   required>
          </div>
          @if ($errors->has('email'))
            <p class="text-red-500 text-sm mt-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                {{ $errors->first('email') }}
            </p>
          @endif
        </div>

        <!-- Password Input -->
        <div class="mb-8 fade-in-up delay-300">
          <label for="password" class="block text-primary font-medium text-sm mb-2">Password</label>
          <div class="relative">
            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
            </div>
            <input type="password" name="password" id="password" placeholder="Masukkan password Anda" autocomplete="current-password"
                   class="w-full py-4 px-12 pr-12 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-300 text-gray-700"
                   aria-label="Password"
                   required>

            <button type="button" onclick="toggleKonsultanPassword()" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-200" aria-label="Toggle password visibility">
              <svg id="konsultanEyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
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

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mb-8 fade-in-up delay-300">
          <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="remember" value="1" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <span class="text-primary font-medium text-sm">Ingat saya</span>
          </label>
          <a href="{{ route('password.request') }}" class="text-primary text-sm font-semibold hover:underline transition-colors duration-200">
            Lupa Password?
          </a>
        </div>

        <!-- Login Button -->
        <button type="submit" id="submitBtn" class="w-full btn-primary py-4 rounded-xl text-white font-semibold text-lg mb-6 fade-in-up delay-400 relative transition-all duration-300 hover:shadow-lg disabled:opacity-70">
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

        <!-- Link Alternatif -->
        <div class="text-center fade-in-up delay-400">
          <p class="text-gray-600">
            Bukan Konsultan?
            <a href="{{ route('loginAdmin') }}" class="text-primary hover:underline font-semibold ml-1 transition-colors duration-300">
              Ke Login Admin
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
        <h1 class="text-white font-bold text-4xl lg:text-5xl mb-4">Selamat Datang Konsultan</h1>
        <div class="w-20 h-1 bg-white mx-auto mb-6 rounded-full"></div>
        <p class="text-white/90 text-lg mb-8 max-w-xs">Masukkan Email dan Password untuk mengakses portal</p>
        <div class="fade-in-up delay-300">
          <img src="{{ asset('image/loginKonsultasi.png') }}" alt="Konsultan Login Illustration"
               class="h-64 lg:h-80 object-contain drop-shadow-2xl">
        </div>
      </div>
    </section>
  </main>

  <script>
    function toggleKonsultanPassword() {
        const input = document.getElementById("password");
        const icon = document.getElementById("konsultanEyeIcon");

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
  </script>

</body>

</html>
