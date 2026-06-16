<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="app-base-url" content="{{ url('') }}">
  <title>DATAPEDIA BPS - Literasi Statistik</title>

  <script>
      window.APP_BASE_URL = "{{ url('') }}";
  </script>

  <link rel="shortcut icon" href="{{ asset('image/logo-bpskecil.png') }}" type="image/x-icon" />
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user-page.css') }}">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

  @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/user-page.js'])
  
  <style>
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
      animation: fadeInUp 0.6s ease-out forwards;
      opacity: 0;
    }

    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }
  </style>
  
  @stack('styles')
</head>

<body class="antialiased bg-white">
  @include('components.user.navbar')

  <main class="flex-grow pt-24 w-full pb-16">
      {{ $slot }}
  </main>

  @include('components.user.footer')

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script>
      AOS.init({ once: false, offset: 120, duration: 800 });
  </script>
  @stack('scripts')
</body>
</html>
