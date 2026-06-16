<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="icon" href="{{ asset('gambar/logo-bps.jpg') }}" type="image/jpg">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>403 - Akses Ditolak</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #7C3AED 0%, #A855F7 50%, #D946EF 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    .background-decoration {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      opacity: 0.1;
    }

    .decoration-circle {
      position: absolute;
      border-radius: 50%;
      border: 2px solid rgba(255, 255, 255, 0.5);
    }

    .circle-1 {
      width: 300px;
      height: 300px;
      top: -150px;
      right: -100px;
    }

    .circle-2 {
      width: 200px;
      height: 200px;
      bottom: -50px;
      left: -50px;
    }

    .error-container {
      position: relative;
      z-index: 10;
      max-width: 600px;
      width: 90%;
      text-align: center;
      animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(40px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .error-icon-box {
      margin-bottom: 2rem;
      animation: shake 0.6s ease-in-out;
    }

    @keyframes shake {
      0%, 100% {
        transform: rotateZ(0deg);
      }
      25% {
        transform: rotateZ(-5deg);
      }
      75% {
        transform: rotateZ(5deg);
      }
    }

    .error-icon {
      width: 120px;
      height: 120px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.15);
      border: 3px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      backdrop-filter: blur(10px);
    }

    .error-icon svg {
      width: 60px;
      height: 60px;
      color: white;
    }

    .error-code {
      font-size: 6rem;
      font-weight: 900;
      background: linear-gradient(135deg, #ffffff 0%, rgba(255, 255, 255, 0.8) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin: 1rem 0;
      letter-spacing: -2px;
    }

    .error-title {
      font-size: 2rem;
      font-weight: 800;
      color: white;
      margin-bottom: 1rem;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .error-message {
      font-size: 1.1rem;
      color: rgba(255, 255, 255, 0.9);
      margin-bottom: 2.5rem;
      line-height: 1.6;
    }

    .button-group {
      display: flex;
      gap: 1rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn {
      padding: 1rem 2rem;
      border: none;
      border-radius: 0.75rem;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .btn-primary {
      background: white;
      color: #7C3AED;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }

    .btn-secondary {
      background: rgba(255, 255, 255, 0.2);
      color: white;
      border: 2px solid rgba(255, 255, 255, 0.4);
      backdrop-filter: blur(10px);
    }

    .btn-secondary:hover {
      background: rgba(255, 255, 255, 0.3);
      border-color: rgba(255, 255, 255, 0.6);
    }

    .btn svg {
      width: 20px;
      height: 20px;
    }

    @media (max-width: 640px) {
      .error-code {
        font-size: 4rem;
      }

      .error-title {
        font-size: 1.5rem;
      }

      .error-message {
        font-size: 1rem;
      }

      .button-group {
        flex-direction: column;
      }

      .btn {
        width: 100%;
        justify-content: center;
      }
    }
  </style>
</head>

<body>
  <div class="background-decoration">
    <div class="decoration-circle circle-1"></div>
    <div class="decoration-circle circle-2"></div>
  </div>

  <div class="error-container">
    <div class="error-icon-box">
      <div class="error-icon">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 0v2m0-6v-2M7.08 6.47a9 9 0 1111.84 11.84M7.08 6.47L4.586 3.972m12.168 12.168l2.502 2.502" />
        </svg>
      </div>
    </div>

    <div class="error-code">403</div>
    <h1 class="error-title">Akses Ditolak</h1>
    <p class="error-message">
      Anda tidak memiliki izin untuk mengakses halaman ini. Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
    </p>

    <div class="button-group">
      <a href="{{ url('/') }}" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 5h4"></path>
        </svg>
        Ke Halaman Utama
      </a>
      <a href="javascript:history.back()" class="btn btn-secondary">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali
      </a>
    </div>
  </div>
</body>

</html>
