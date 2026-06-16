<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.85">

  @vite(['resources/css/app.css','resources/js/app.js'])
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



  {{-- Leaflet CSS --}}
  <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
  />
</head>

<body  class="bg-gray-100 min-h-screen overflow-x-hidden">
  {{ $slot }}

  {{-- Leaflet JS --}}
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  {{-- ⬇️ INI WAJIB --}}
  @stack('scripts')
</body>
</html>

