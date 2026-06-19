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
      background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    /* Floating particles */
    .particles {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
    }

    .particle {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.06);
      animation: float 20s infinite ease-in-out;
    }

    .particle:nth-child(1) { width: 80px; height: 80px; top: 10%; left: 10%; animation-delay: 0s; }
    .particle:nth-child(2) { width: 120px; height: 120px; top: 60%; left: 80%; animation-delay: -5s; }
    .particle:nth-child(3) { width: 60px; height: 60px; top: 30%; left: 70%; animation-delay: -10s; }
    .particle:nth-child(4) { width: 100px; height: 100px; top: 80%; left: 20%; animation-delay: -15s; }
    .particle:nth-child(5) { width: 50px; height: 50px; top: 50%; left: 50%; animation-delay: -7s; }
    .particle:nth-child(6) { width: 90px; height: 90px; top: 15%; left: 40%; animation-delay: -12s; }

    @keyframes float {
      0%, 100% { transform: translateY(0) rotate(0deg); }
      33% { transform: translateY(-30px) rotate(5deg); }
      66% { transform: translateY(15px) rotate(-3deg); }
    }

    /* Geometry decorations */
    .geometry {
      position: absolute;
      pointer-events: none;
    }

    .geo-ring {
      position: absolute;
      border-radius: 50%;
      border: 2px solid rgba(255, 255, 255, 0.08);
    }

    .ring-1 {
      width: 400px;
      height: 400px;
      top: -100px;
      right: -150px;
    }

    .ring-2 {
      width: 250px;
      height: 250px;
      bottom: -80px;
      left: -80px;
      border-style: dashed;
    }

    .ring-3 {
      width: 150px;
      height: 150px;
      top: 20%;
      left: 5%;
      border-color: rgba(199, 210, 254, 0.15);
    }

    .error-container {
      position: relative;
      z-index: 10;
      max-width: 560px;
      width: 90%;
      text-align: center;
      animation: slideUp 0.7s ease-out;
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(50px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Lock icon */
    .error-icon-box {
      margin-bottom: 1.75rem;
    }

    .error-icon {
      width: 100px;
      height: 100px;
      margin: 0 auto;
      background: rgba(239, 68, 68, 0.12);
      border: 2px solid rgba(239, 68, 68, 0.3);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 0 40px rgba(239, 68, 68, 0.15);
      animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { box-shadow: 0 0 40px rgba(239, 68, 68, 0.15); }
      50% { box-shadow: 0 0 60px rgba(239, 68, 68, 0.3); }
    }

    .error-icon svg {
      width: 48px;
      height: 48px;
      color: #fca5a5;
    }

    /* Error code */
    .error-code {
      font-size: 7rem;
      font-weight: 900;
      background: linear-gradient(180deg, #f87171 0%, #ef4444 50%, #dc2626 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin: 0.5rem 0;
      letter-spacing: -3px;
      line-height: 1;
    }

    .error-title {
      font-size: 1.75rem;
      font-weight: 700;
      color: #f1f5f9;
      margin-bottom: 0.75rem;
      letter-spacing: -0.5px;
    }

    .error-subtitle {
      font-size: 0.95rem;
      color: #cbd5e1;
      margin-bottom: 2rem;
      line-height: 1.7;
      max-width: 420px;
      margin-left: auto;
      margin-right: auto;
    }

    .divider {
      width: 60px;
      height: 3px;
      background: linear-gradient(90deg, rgba(239, 68, 68, 0.4), #ef4444, rgba(239, 68, 68, 0.4));
      border-radius: 99px;
      margin: 0 auto 2rem;
    }

    /* Buttons */
    .button-group {
      display: flex;
      gap: 0.75rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn {
      padding: 0.8rem 1.75rem;
      border: none;
      border-radius: 0.75rem;
      font-size: 0.9rem;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.25s ease;
      letter-spacing: 0.02em;
      white-space: nowrap;
    }

    .btn-primary {
      background: #ef4444;
      color: #fff;
      box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35);
    }

    .btn-primary:hover {
      background: #dc2626;
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(239, 68, 68, 0.45);
    }

    .btn-outline {
      background: transparent;
      color: #e2e8f0;
      border: 2px solid rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(4px);
    }

    .btn-outline:hover {
      background: rgba(255, 255, 255, 0.08);
      border-color: rgba(255, 255, 255, 0.4);
      color: #fff;
      transform: translateY(-2px);
    }

    .btn-ghost {
      background: transparent;
      color: #94a3b8;
      border: 2px solid transparent;
    }

    .btn-ghost:hover {
      color: #e2e8f0;
      background: rgba(255, 255, 255, 0.05);
    }

    .btn svg {
      width: 18px;
      height: 18px;
      flex-shrink: 0;
    }

    /* Help text */
    .help-text {
      margin-top: 2.5rem;
      font-size: 0.8rem;
      color: #64748b;
    }

    .help-text a {
      color: #f87171;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.2s;
    }

    .help-text a:hover {
      color: #fca5a5;
      text-decoration: underline;
    }

    @media (max-width: 640px) {
      .error-code {
        font-size: 5rem;
      }

      .error-title {
        font-size: 1.4rem;
      }

      .error-subtitle {
        font-size: 0.85rem;
      }

      .button-group {
        flex-direction: column;
        align-items: center;
      }

      .btn {
        width: 100%;
        max-width: 320px;
        justify-content: center;
      }

      .error-icon {
        width: 80px;
        height: 80px;
      }

      .error-icon svg {
        width: 38px;
        height: 38px;
      }
    }
  </style>
</head>

<body>
  <!-- Decorative particles -->
  <div class="particles">
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
  </div>

  <!-- Geometric rings -->
  <div class="geometry">
    <div class="geo-ring ring-1"></div>
    <div class="geo-ring ring-2"></div>
    <div class="geo-ring ring-3"></div>
  </div>

  <div class="error-container">
    <!-- Icon -->
    <div class="error-icon-box">
      <div class="error-icon">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
            d="M12 15v2m0 0l.5.5m-.5-.5l-.5.5M6.343 6.343A8 8 0 0118 18a8 8 0 01-11.657 0zm0 0L3.515 3.515m2.828 2.828L9 9m9 9l2.829 2.829m-2.829-2.829L15 15" />
        </svg>
      </div>
    </div>

    <div class="error-code">403</div>
    <h1 class="error-title">Akses Ditolak</h1>
    <p class="error-subtitle">
      Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
      Halaman ini mungkin terbatas atau memerlukan hak akses khusus.
    </p>
    <div class="divider"></div>

    <div class="button-group">
      <a href="{{ url('/') }}" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z" />
        </svg>
        Ke Halaman Utama
      </a>
      <a href="{{ url()->previous() }}" class="btn btn-outline" onclick="if(document.referrer===''){this.href='{{ url('/') }}'}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali
      </a>
      <a href="{{ route('loginUser') }}" class="btn btn-ghost">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        Masuk
      </a>
    </div>

    <p class="help-text">
      Jika Anda merasa ini adalah kesalahan, silakan <a href="mailto:{{ env('ADMIN_EMAIL', 'admin@bps.go.id') }}">hubungi administrator</a>.
    </p>
  </div>
</body>

</html>