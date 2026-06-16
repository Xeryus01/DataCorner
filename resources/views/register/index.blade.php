<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Daftar — Datapedia BPS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        .login-wrap { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem 1rem; background: #f1f5f9; }
        .login-card { width: 100%; max-width: 420px; background: #fff; border: 1px solid #e2e8f0; border-radius: 1rem; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.06); }
        .card-header { background: #002B6A; padding: 1.5rem 1.75rem 1.25rem; display: flex; flex-direction: column; align-items: flex-start; gap: 10px; position: relative; overflow: hidden; }
        .card-header::before { content: ''; position: absolute; top: -40px; right: -40px; width: 140px; height: 140px; border-radius: 50%; background: rgba(31,111,214,0.25); }
        .card-header::after { content: ''; position: absolute; bottom: -30px; right: 60px; width: 80px; height: 80px; border-radius: 50%; background: rgba(74,155,255,0.15); }
        .logo-row { display: flex; align-items: center; gap: 10px; position: relative; z-index: 1; }
        .logo-box { width: 38px; height: 38px; background: rgba(255,255,255,0.12); border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.2); }
        .logo-box img { width: 24px; height: 24px; object-fit: contain; }
        .logo-name { color: #fff; font-size: 15px; font-weight: 600; }
        .header-title { color: #fff; font-size: 20px; font-weight: 700; line-height: 1.2; position: relative; z-index: 1; }
        .header-sub { color: rgba(255,255,255,0.55); font-size: 12px; position: relative; z-index: 1; margin-top: -6px; }
        .card-body { padding: 1.25rem 1.75rem 1.5rem; }
        .form-group { margin-bottom: 0.85rem; }
        .form-label { display: block; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 5px; }
        .field-box { display: flex; align-items: stretch; border: 1px solid #e2e8f0; border-radius: 8px; background: #f8fafc; transition: border-color 0.15s, box-shadow 0.15s, background 0.15s; overflow: hidden; }
        .field-box:focus-within { border-color: #1F6FD6; box-shadow: 0 0 0 3px rgba(31,111,214,0.1); background: #fff; }
        .field-prefix { display: flex; align-items: center; gap: 6px; padding: 0 12px; border-right: 1px solid #e2e8f0; background: #f1f5f9; color: #94a3b8; font-size: 13px; font-weight: 600; white-space: nowrap; user-select: none; flex-shrink: 0; }
        .field-prefix i { font-size: 14px; }
        .field-icon-left { display: flex; align-items: center; padding: 0 0 0 12px; color: #94a3b8; flex-shrink: 0; }
        .field-icon-left i { font-size: 16px; }
        .field-input { flex: 1; min-width: 0; height: 40px; padding: 0 12px; border: none; background: transparent; color: #0f172a; font-size: 14px; font-family: inherit; outline: none; }
        .field-input::placeholder { color: #cbd5e1; font-size: 13px; }
        .eye-btn { display: flex; align-items: center; padding: 0 12px; background: none; border: none; color: #94a3b8; cursor: pointer; flex-shrink: 0; transition: color 0.15s; }
        .eye-btn:hover { color: #64748b; }
        .eye-btn i { font-size: 16px; }
        .hint-text { font-size: 10px; color: #94a3b8; margin-top: 3px; }
        .error-text { font-size: 12px; color: #ef4444; margin-top: 3px; display: flex; align-items: center; gap: 4px; }
        .alert-box { font-size: 13px; padding: 9px 12px; border-radius: 8px; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 8px; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
        .btn-submit { width: 100%; height: 42px; background: #002B6A; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; font-family: inherit; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: background 0.15s, transform 0.1s; }
        .btn-submit:hover { background: #1F6FD6; }
        .btn-submit:active { transform: scale(0.99); }
        .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }
        .alt-row { text-align: center; font-size: 13px; color: #64748b; margin-top: 0.85rem; }
        .alt-row .link { color: #1F6FD6; font-weight: 600; text-decoration: none; }
        .alt-row .link:hover { text-decoration: underline; }
        .badge-secure { display: flex; align-items: center; justify-content: center; gap: 6px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 20px; padding: 5px 14px; font-size: 10px; color: #94a3b8; margin-top: 0.85rem; }
        .badge-secure i { font-size: 11px; color: #27B67A; }
    </style>
</head>
<body>
    <div class="login-wrap">
        <div class="login-card">
            <div class="card-header">
                <div class="logo-row">
                    <div class="logo-box"><img src="{{ asset('image/logo-pst.png') }}" alt="Logo"></div>
                    <span class="logo-name">Datapedia · BPS Babel</span>
                </div>
                <div class="header-title">Buat Akun Baru</div>
                <div class="header-sub">Daftar gratis untuk akses penuh layanan statistik</div>
            </div>
            <div class="card-body">
                <form action="{{ route('prosesregisterUser') }}" method="POST">
                    @csrf
                    @if($errors->any())
                    <div class="alert-box alert-error">
                        <i class="ti ti-alert-circle"></i>
                        @foreach($errors->all() as $error) {{ $error }} @endforeach
                    </div>
                    @endif

                    {{-- No HP --}}
                    <div class="form-group">
                        <label class="form-label" for="no_hp">Nomor Handphone</label>
                        <div class="field-box">
                            <div class="field-prefix"><i class="ti ti-device-mobile"></i> +62</div>
                            <input type="tel" class="field-input" name="no_hp" id="no_hp" placeholder="81234567890" autocomplete="tel" value="{{ old('no_hp') }}" required>
                        </div>
                        <p class="hint-text">Nomor aktif untuk verifikasi dan pemulihan akun</p>
                        @error('no_hp') <p class="error-text"><i class="ti ti-exclamation-circle"></i>{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <div class="field-box">
                            <div class="field-icon-left"><i class="ti ti-mail"></i></div>
                            <input type="email" class="field-input" name="email" id="email" placeholder="contoh@gmail.com" autocomplete="email" value="{{ old('email') }}" required>
                        </div>
                        @error('email') <p class="error-text"><i class="ti ti-exclamation-circle"></i>{{ $message }}</p> @enderror
                    </div>

                    {{-- Username --}}
                    <div class="form-group">
                        <label class="form-label" for="nama">Username</label>
                        <div class="field-box">
                            <div class="field-icon-left"><i class="ti ti-user"></i></div>
                            <input type="text" class="field-input" name="nama" id="nama" placeholder="username123" autocomplete="username" value="{{ old('nama') }}" required>
                        </div>
                        <p class="hint-text">Gunakan huruf, angka, dan garis bawah (3-20 karakter)</p>
                        @error('nama') <p class="error-text"><i class="ti ti-exclamation-circle"></i>{{ $message }}</p> @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="field-box">
                            <div class="field-icon-left"><i class="ti ti-lock"></i></div>
                            <input type="password" class="field-input" name="password" id="password" placeholder="Min. 5 karakter" autocomplete="new-password" required>
                            <button type="button" class="eye-btn" onclick="togglePass('password','eyeIcon')" aria-label="Toggle password"><i class="ti ti-eye" id="eyeIcon"></i></button>
                        </div>
                        @error('password') <p class="error-text"><i class="ti ti-exclamation-circle"></i>{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn"><i class="ti ti-user-plus" style="font-size:16px"></i> <span id="btnText">Daftar Akun</span></button>

                    <div class="alt-row">Sudah punya akun? <a href="{{ route('loginUser') }}" class="link">Masuk sekarang</a></div>
                    <div class="badge-secure"><i class="ti ti-shield-check"></i> Koneksi aman · Data terenkripsi</div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function togglePass(iId, iconId){const i=document.getElementById(iId),e=document.getElementById(iconId);if(i.type==='password'){i.type='text';e.className='ti ti-eye-off'}else{i.type='password';e.className='ti ti-eye'}}
        document.querySelector('form').addEventListener('submit',()=>{const b=document.getElementById('submitBtn');b.disabled=true;b.style.background='#1F6FD6';document.getElementById('btnText').textContent='Mendaftarkan...'});
    </script>
</body>
</html>