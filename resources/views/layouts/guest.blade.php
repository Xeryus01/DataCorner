<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset('gambar/logo-bps.jpg') }}" type="image/jpg">
  <title>Pojok Literasi Statistik</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
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
      input[type="password"],
      input[type="number"] {
        font-size: 16px;
      }
    }
  </style>
</head>

<body class="font-sans text-gray-900 antialiased min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 flex items-center justify-center p-4">
  <div class="w-full max-w-md rounded-3xl card-shadow bg-white overflow-hidden p-8 fade-in-up">
    {{ $slot }}
  </div>
</body>

</html>
