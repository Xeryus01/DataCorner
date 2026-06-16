<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BPS User | Profil</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 p-4">

  <nav class="w-full max-w-6xl mx-auto mb-8">
    <div class="glass-effect rounded-2xl p-4 flex items-center justify-between">
      <div class="flex items-center space-x-4">
        <div class="profile-avatar w-12 h-12 rounded-full flex items-center justify-center bg-primary">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
        </div>
        <div>
          <h1 class="text-xl font-bold text-gray-800">Profil Pengguna</h1>
          <p class="text-sm text-gray-600">Sistem BPS User</p>
        </div>
      </div>
      <img class=" sm:flex hidden" src="{{ asset('image/logo-bpsbiru.png') }}" width="400" height="400" alt="">
    </div>
  </nav>


  <main class="w-full max-w-6xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

      <!-- Kartu Profil -->
      <div class="lg:col-span-1">
        <div class="profile-card rounded-3xl p-8 card-shadow bg-white">
          <div class="text-center mb-8">
            <div class="profile-avatar w-32 h-32 rounded-full mx-auto flex items-center justify-center mb-4 bg-primary">
              <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $user->nama ?? 'Nama tidak tersedia' }}</h2>
            <div class="status-badge text-white px-4 py-2 rounded-full text-sm font-semibold inline-flex items-center bg-green-600">
              <div class="w-2 h-2 bg-white rounded-full mr-2"></div>
              Aktif
            </div>
          </div>
        </div>
      </div>

 <!-- Informasi Profil -->
<form method="POST" action="{{ route('profile.update', $user->id) }}" class="lg:col-span-2">
  @csrf
  @method('PUT')

  <div class="profile-card rounded-3xl p-8 bg-white shadow">
    <h3 class="text-2xl font-bold text-gray-800 mb-6">Edit Profil</h3>

    <!-- Grid untuk 2 kolom -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

      <!-- Username -->
      <div class="bg-gray-50 p-6 rounded-xl flex flex-col">
        <label for="nama" class="text-sm font-medium text-gray-600 mb-2">Username</label>
        <input type="text" name="nama" id="nama"
                value="{{ old('nama', $user->nama) }}"
               class="flex-1 w-full border border-gray-300 rounded-lg px-4 py-2 text-base text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <!-- Nomor Handphone -->
      <div class="bg-gray-50 p-6 rounded-xl flex flex-col">
        <label for="no_hp" class="text-sm font-medium text-gray-600 mb-2">Nomor Handphone</label>
        <input type="text" name="no_hp" id="no_hp"
               value="{{ old('no_hp', $user->no_hp) }}"
               class="flex-1 w-full border border-gray-300 rounded-lg px-4 py-2 text-base text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <!-- Password -->
      <div class="md:col-span-2 bg-gray-50 p-6 rounded-xl flex flex-col">
        <label for="password" class="text-sm font-medium text-gray-600 mb-2">Password</label>
        <input type="password" name="password" id="password"
               placeholder="Kosongkan jika tidak ingin mengganti"
               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-base text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

    </div>

    <!-- Tombol Aksi -->
    <div class="mt-8 flex justify-end">
      <button type="submit"
              class="bg-blue-800 hover:bg-blue-900 text-white px-6 py-3 rounded-xl flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span>Edit Profil</span>
      </button>
    </div>

  </div>
</form>



    </div>
  </main>

  <!-- Success Alert Modal -->
<div id="successAlert" class="fixed inset-0 hidden bg-black bg-opacity-50 alert-overlay z-50 items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full alert-container">
        <div class="text-center p-8">
            <div class="relative inline-flex items-center justify-center">
                <div class="absolute w-20 h-20 bg-green-400 rounded-full pulse-ring"></div>
                <div class="relative w-20 h-20 bg-gradient-to-r from-green-400 to-green-500 rounded-full flex items-center justify-center success-icon shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path class="success-check" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Berhasil!</h3>
                <p class="text-gray-600 mb-6">Profil Anda telah diperbarui.</p>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-center space-x-2 text-green-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">Perubahan disimpan dengan aman</span>
                    </div>
                </div>
                <div class="space-y-3">
                    <button onclick="closeAlert()" class="w-full bg-gradient-to-r from-primary to-primary-light text-white font-semibold py-3 px-6 rounded-lg hover:from-primary-dark hover:to-primary transition-all duration-200 shadow-lg hover:shadow-xl">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<script>
    window.addEventListener('DOMContentLoaded', () => {
        document.getElementById('successAlert')?.classList.remove('hidden');
    });
</script>
@endif

<script>
    function closeAlert() {
        const successAlert = document.getElementById('successAlert');
        const alertContainer = successAlert.querySelector('.alert-container');

        alertContainer.classList.add('fade-out');
        successAlert.classList.add('fade-out');

        setTimeout(() => {
            successAlert.classList.add('hidden');
            successAlert.classList.remove('fade-out');
            alertContainer.classList.remove('fade-out');
        }, 300);
    }

    // Escape key close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const successAlert = document.getElementById('successAlert');
            if (!successAlert.classList.contains('hidden')) {
                closeAlert();
            }
        }
    });

    // Close alert if click outside
    document.getElementById('successAlert')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeAlert();
        }
    });
</script>


</body>
</html>
