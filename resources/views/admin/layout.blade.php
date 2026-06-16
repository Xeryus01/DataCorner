<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('image/logo-bpskecil.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/tabler-icons.min.css">
    @vite(['resources/js/app.js'])
    <title>Admin Panel — Datapedia</title>
    <style>
        :root {
            --sidebar-w: 200px;
            --topbar-h: 48px;
            --color-bg: #f1f5f9;
            --color-surface: #fff;
            --color-border: rgba(0,0,0,0.08);
            --color-text: #0f172a;
            --color-muted: #64748b;
            --brand-navy: #0C3060;
            --brand-blue: #1F6FD6;
            --brand-blue-light: #E6F1FB;
            --brand-blue-mid: #B5D4F4;
            --brand-blue-dark: #0C447C;
            --green-bg: #EAF3DE;
            --green-dark: #27500A;
            --amber-bg: #FAEEDA;
            --amber-dark: #633806;
            --red-bg: #FCEBEB;
            --red-dark: #791F1F;
            --font: 'Inter', system-ui, -apple-system, sans-serif;
        }
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:var(--font);background:var(--color-bg);color:var(--color-text)}
        .shell{display:flex;min-height:100vh}
        .sidebar{
            width:var(--sidebar-w);background:var(--brand-navy);flex-shrink:0;
            display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:40;
            overflow-y:auto;overflow-x:hidden;
        }
        .sb-brand{padding:14px 14px;border-bottom:1px solid rgba(255,255,255,0.08);display:flex;align-items:center;gap:8px}
        .sb-logo{width:28px;height:28px;background:var(--brand-blue);border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .sb-logo img{width:18px;height:18px;object-fit:contain}
        .sb-title{font-size:13px;font-weight:600;color:#fff;letter-spacing:0.03em}
        .sb-title span{color:#93C5FD}
        .sb-nav{padding:8px 8px;flex:1}
        .sb-section{font-size:9px;font-weight:600;color:rgba(255,255,255,0.30);letter-spacing:0.14em;padding:8px 8px 4px;margin-top:4px;text-transform:uppercase}
        .sb-link{display:flex;align-items:center;gap:7px;padding:6px 8px;border-radius:6px;color:rgba(255,255,255,0.55);font-size:11px;font-weight:500;text-decoration:none;margin-bottom:1px;transition:all 140ms}
        .sb-link:hover{background:rgba(255,255,255,0.07);color:#fff}
        .sb-link.active{background:rgba(255,255,255,0.12);color:#fff;font-weight:600}
        .sb-link i{font-size:13px;width:14px;text-align:center}
        .sb-link.logout{color:#F09595;margin-top:6px}
        .sb-link.logout:hover{background:rgba(240,149,149,0.15)}
        .sb-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.35);z-index:35}
        .main{flex:1;display:flex;flex-direction:column;min-width:0;margin-left:var(--sidebar-w)}
        .topbar{
            height:var(--topbar-h);background:var(--color-surface);
            border-bottom:0.5px solid var(--color-border);
            display:flex;align-items:center;justify-content:space-between;padding:0 18px;flex-shrink:0;
            position:sticky;top:0;z-index:30;
        }
        .topbar-left{display:flex;align-items:center;gap:10px}
        .menu-btn{display:none;background:none;border:none;color:var(--color-muted);cursor:pointer;font-size:18px;padding:4px}
        .topbar-left span{font-size:12px;color:var(--color-muted)}
        .topbar-right{display:flex;align-items:center;gap:8px}
        .avatar{width:30px;height:30px;border-radius:50%;background:var(--brand-blue-light);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;color:#185FA5}
        .badge-role{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:999px;font-size:10px;font-weight:600}
        .badge-admin{background:var(--brand-blue-light);color:#185FA5}
        .badge-operator{background:var(--green-bg);color:#3B6D11}
        .badge-magang{background:#FFF4E5;color:#B45309}
        .content{padding:16px 18px;flex:1;display:flex;flex-direction:column;gap:14px}
        .card{background:var(--color-surface);border:0.5px solid var(--color-border);border-radius:12px;overflow:hidden}

        /* ── Shared form styles ── */
        .form-label{display:block;font-size:12px;font-weight:600;color:var(--color-text);margin-bottom:5px}
        .form-input,.form-select,.form-textarea{
            width:100%;height:40px;padding:0 12px;
            border:0.5px solid var(--color-border);border-radius:8px;
            background:var(--color-surface);font-size:13px;color:var(--color-text);
            outline:none;transition:border-color 150ms, box-shadow 150ms;
            font-family:inherit;
        }
        .form-textarea{height:auto;padding:10px 12px;resize:vertical;min-height:80px}
        .form-input:focus,.form-select:focus,.form-textarea:focus{
            border-color:var(--brand-blue);box-shadow:0 0 0 3px rgba(31,111,214,0.10);
        }
        .form-input::placeholder{color:#94a3b8}
        .form-select{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M8 10L3 5h10L8 10z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;padding-right:32px}
        .form-error{background:var(--red-bg);border:1px solid #F7C1C1;color:var(--red-dark);padding:10px 14px;border-radius:8px;font-size:12px;margin-bottom:16px}
        .form-error div{margin-bottom:2px}
        .form-error div:last-child{margin-bottom:0}

        /* ── Buttons ── */
        .btn-primary{display:inline-flex;align-items:center;gap:6px;padding:8px 18px;background:var(--brand-blue);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none;transition:background 150ms}
        .btn-primary:hover{background:#185FA5}
        .btn-primary i{font-size:14px}
        .btn-ghost{display:inline-flex;align-items:center;gap:6px;padding:8px 18px;background:transparent;color:var(--color-muted);border:0.5px solid var(--color-border);border-radius:8px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none;transition:all 150ms}
        .btn-ghost:hover{background:#f8fafc;color:var(--color-text)}
        .btn-ghost i{font-size:14px}
        .btn-edit-sm{display:inline-flex;align-items:center;gap:4px;padding:4px 9px;background:var(--brand-blue-light);color:var(--brand-blue-dark);border:none;border-radius:6px;font-size:11px;font-weight:500;cursor:pointer;text-decoration:none;transition:background 150ms}
        .btn-edit-sm:hover{background:var(--brand-blue-mid)}
        .btn-edit-sm i{font-size:12px}
        .btn-del-sm{display:inline-flex;align-items:center;gap:4px;padding:4px 9px;background:var(--red-bg);color:var(--red-dark);border:none;border-radius:6px;font-size:11px;font-weight:500;cursor:pointer;transition:background 150ms}
        .btn-del-sm:hover{background:#F7C1C1}
        .btn-del-sm i{font-size:12px}

        /* ── Table ── */
        .table-wrap{overflow-x:auto}
        table.data-table{width:100%;border-collapse:collapse}
        table.data-table thead tr{background:#f8fafc}
        table.data-table th{padding:10px 16px;text-align:left;font-size:11px;font-weight:600;color:var(--color-muted);border-bottom:0.5px solid var(--color-border);white-space:nowrap;text-transform:uppercase;letter-spacing:0.06em}
        table.data-table td{padding:12px 16px;font-size:12px;color:var(--color-text);border-bottom:0.5px solid var(--color-border)}
        table.data-table tr:last-child td{border-bottom:none}
        table.data-table tbody tr{transition:background 100ms}
        table.data-table tbody tr:hover{background:#f8fafc}
        .num-cell{text-align:center;width:48px;color:var(--color-muted);font-size:11px}
        .name-cell{font-weight:500}
        .email-cell{color:var(--color-muted);font-size:12px}

        /* ── Badges ── */
        .badge-status{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:999px;font-size:10px;font-weight:500}
        .badge-active{background:var(--green-bg);color:var(--green-dark)}
        .badge-inactive{background:var(--red-bg);color:var(--red-dark)}
        .badge-admin-sm{background:var(--brand-blue-light);color:var(--brand-blue-dark)}
        .badge-operator-sm{background:var(--green-bg);color:var(--green-dark)}
        .badge-super{background:#EEEDFE;color:#3C3489}
        .badge-dot{width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block}

        /* ── Card components ── */
        .card-header{padding:14px 18px;border-bottom:0.5px solid var(--color-border);display:flex;align-items:center;justify-content:space-between}
        .card-header-left{display:flex;align-items:center;gap:8px}
        .card-title{font-size:13px;font-weight:600;color:var(--color-text)}
        .card-title i{font-size:16px;color:var(--brand-blue)}
        .card-body{padding:20px}
        .card-footer{padding:10px 16px;border-top:0.5px solid var(--color-border);display:flex;align-items:center;justify-content:space-between}
        .footer-info{font-size:11px;color:var(--color-muted)}

        /* ── Page header ── */
        .page-header-row{display:flex;align-items:center;justify-content:space-between}
        .page-title{font-size:16px;font-weight:500;color:var(--color-text)}
        .page-sub{font-size:12px;color:var(--color-muted);margin-top:2px}

        /* ── Section divider in forms ── */
        .form-section-title{display:flex;align-items:center;gap:8px;margin-bottom:16px;font-size:13px;font-weight:600;color:var(--color-text)}
        .form-section-title i{font-size:16px;color:var(--brand-blue)}
        .form-divider{height:0.5px;background:var(--color-border);margin:20px 0}

        /* ── Readonly total field ── */
        .form-input.readonly{background:#f8fafc;border-color:#cbd5e1;color:var(--brand-blue-dark);font-weight:600;cursor:not-allowed}

        /* ── Search box ── */
        .search-box{display:flex;align-items:center;gap:8px;background:#f8fafc;border:0.5px solid var(--color-border);border-radius:8px;padding:0 10px;height:32px}
        .search-box i{font-size:14px;color:var(--color-muted)}
        .search-box input{border:none;background:transparent;font-size:12px;color:var(--color-text);outline:none;width:160px;font-family:inherit}
        .search-box input::placeholder{color:#94a3b8}

        /* ── Radio / Checkbox ── */
        .form-check{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--color-text);cursor:pointer}
        .form-check input[type=checkbox],.form-check input[type=radio]{accent-color:var(--brand-blue);width:15px;height:15px;cursor:pointer}

        /* ── Grid ── */
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px 20px}
        @media(max-width:640px){.form-grid{grid-template-columns:1fr}}

        /* ── Action bar at bottom of forms ── */
        .form-actions{display:flex;align-items:center;gap:8px;margin-top:20px;padding-top:16px;border-top:0.5px solid var(--color-border)}

        @media(max-width:1024px){
            .sidebar{transform:translateX(-100%);transition:transform 240ms ease}
            .sidebar.open{transform:translateX(0)}
            .sb-overlay.show{display:block}
            .main{margin-left:0}
            .menu-btn{display:block}
        }
    </style>
</head>
<body>
    @php
        $adminUser = Auth::guard('admin')->user();
        $roleName = $adminUser?->getRoleNames()->first() ?? 'admin';
        $isAdmin = $roleName === 'admin';
        $isOperator = $roleName === 'operator';
        $isMagang = in_array($roleName, ['operator magang', 'operator kepegawaian']);
        $roleBadge = $isAdmin ? 'badge-admin' : ($isOperator ? 'badge-operator' : 'badge-magang');
    @endphp

    <div id="sbOverlay" class="sb-overlay" onclick="toggleSidebar()"></div>

    <aside id="sidebar" class="sidebar">
        <div class="sb-brand">
            <div class="sb-logo"><img src="{{ asset('image/logo-pst.png') }}" alt="Logo"></div>
            <div class="sb-title">DATA<span>PEDIA</span></div>
        </div>
        <nav class="sb-nav">
            <div class="sb-section">Dashboard</div>
            <a href="{{ route('dashboard.index') }}" class="sb-link {{ Route::is('dashboard.index')?'active':'' }}"><i class="ti ti-layout-dashboard"></i> Halaman dashboard</a>

            <div class="sb-section">Manajemen user</div>
            <a href="{{ route('admin.index') }}" class="sb-link"><i class="ti ti-shield-check"></i> Admin</a>
            <a href="{{ route('dataUser') }}" class="sb-link"><i class="ti ti-users"></i> User</a>
            <a href="{{ route('konsultan.index') }}" class="sb-link"><i class="ti ti-tie"></i> Konsultan</a>
            <a href="{{ route('petugas.index') }}" class="sb-link"><i class="ti ti-calendar-week"></i> Petugas mingguan</a>
            <a href="{{ route('petugas-berprestasi.index') }}" class="sb-link"><i class="ti ti-star"></i> Petugas berprestasi</a>
            <a href="{{ route('bidang-keahlian.index') }}" class="sb-link"><i class="ti ti-tags"></i> Bidang keahlian</a>

            <div class="sb-section">Layanan</div>
            <a href="{{ route('jadwal.index') }}" class="sb-link"><i class="ti ti-calendar"></i> Jadwal janji temu</a>
            <a href="{{ route('layanan.index') }}" class="sb-link"><i class="ti ti-bell"></i> Layanan 24 jam</a>
            <a href="{{ route('standar.index') }}" class="sb-link"><i class="ti ti-clipboard"></i> Standar pelayanan</a>
            <a href="{{ route('maklumat.index') }}" class="sb-link"><i class="ti ti-file-text"></i> Maklumat layanan</a>
            <a href="{{ route('jam-operasional.index') }}" class="sb-link"><i class="ti ti-clock"></i> Jam operasional</a>
            <a href="{{ route('adminKonsultasi.create') }}" class="sb-link"><i class="ti ti-plus"></i> + Konsultasi</a>

            <div class="sb-section">Statistik layanan</div>
            <a href="{{ route('statistik.perpustakaan.index') }}" class="sb-link"><i class="ti ti-book"></i> Perpustakaan</a>
            <a href="{{ route('statistik.konsultasi-statistik.index') }}" class="sb-link"><i class="ti ti-handshake"></i> Konsultasi</a>
            <a href="{{ route('statistik.produk-statistik.index') }}" class="sb-link"><i class="ti ti-box"></i> Produk statistik</a>
            <a href="{{ route('statistik.rekomendasi.index') }}" class="sb-link"><i class="ti ti-bulb"></i> Rekomendasi</a>
            <a href="{{ route('statistik.pojok-statistik.index') }}" class="sb-link"><i class="ti ti-map-pin"></i> Pojok statistik</a>
            <a href="{{ route('statistik.website.index') }}" class="sb-link"><i class="ti ti-world"></i> Website BPS</a>
            <a href="{{ route('survei-layanan.index') }}" class="sb-link"><i class="ti ti-poll"></i> Survei layanan</a>

            @if($isAdmin || $isOperator)
            <div class="sb-section">Edukasi statistik</div>
            <a href="{{ route('admin_subjek-materi.index') }}" class="sb-link"><i class="ti ti-stack"></i> Subjek materi</a>
            <a href="{{ route('admin_artikel.index') }}" class="sb-link"><i class="ti ti-article"></i> Artikel</a>
            <a href="{{ route('admin_video-pembelajaran.index') }}" class="sb-link"><i class="ti ti-video"></i> Video</a>
            <a href="{{ route('admin_infografis.index') }}" class="sb-link"><i class="ti ti-photo"></i> Infografis</a>
            @endif

            @if($isAdmin || $isMagang)
            <div class="sb-section">Program magang</div>
            <a href="{{ route('admin_informasi-magang.index') }}" class="sb-link"><i class="ti ti-megaphone"></i> Informasi magang</a>
            <a href="{{ route('admin_daftar-magang.index-admin') }}" class="sb-link"><i class="ti ti-users"></i> Pendaftar</a>
            <a href="{{ route('admin_pengaturan-presensi.index') }}" class="sb-link"><i class="ti ti-fingerprint"></i> Presensi</a>
            @endif

            @if($isAdmin)
            <div class="sb-section">Program riset</div>
            <a href="{{ route('admin_informasi-riset.index') }}" class="sb-link"><i class="ti ti-flask"></i> Informasi riset</a>
            <a href="{{ route('admin_daftar-riset.index-admin') }}" class="sb-link"><i class="ti ti-file-signature"></i> Pendaftar</a>
            @endif

            @if($isAdmin || $isOperator)
            <div class="sb-section">Kuis & alat</div>
            <a href="{{ route('admin_kuis-reguler.index') }}" class="sb-link"><i class="ti ti-question-mark"></i> Kuis reguler</a>
            <a href="{{ route('admin_periode.index') }}" class="sb-link"><i class="ti ti-trophy"></i> Tantangan</a>
            <a href="{{ route('alat-statistik.index') }}" target="_blank" class="sb-link"><i class="ti ti-calculator"></i> Alat statistik</a>
            <a href="{{ route('visualisasi.index') }}" target="_blank" class="sb-link"><i class="ti ti-chart-bar"></i> Visualisasi data</a>
            <a href="{{ route('simulasi.index') }}" target="_blank" class="sb-link"><i class="ti ti-math"></i> Simulasi</a>
            @endif

            @if($isAdmin || $roleName === 'operator kepegawaian')
            <div class="sb-section">Master data</div>
            <a href="{{ route('admin_wilayah-bps.index') }}" class="sb-link"><i class="ti ti-map-pin"></i> Wilayah BPS</a>
            @endif

            <div class="sb-section">Lainnya</div>
            <a href="{{ route('faq.pesan') }}" class="sb-link"><i class="ti ti-message"></i> Pesan WA</a>
            <a href="{{ route('faq.index') }}" class="sb-link"><i class="ti ti-help"></i> FAQ</a>
            <a href="{{ route('footer-item.index') }}" class="sb-link"><i class="ti ti-link"></i> Footer item</a>

            <a href="{{ route('logoutAdmin') }}" class="sb-link logout"><i class="ti ti-logout"></i> Logout</a>
        </nav>
    </aside>

    <div class="main">
        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-btn" onclick="toggleSidebar()" aria-label="Toggle menu"><i class="ti ti-menu-2"></i></button>
                <span>Datapedia Admin Panel</span>
            </div>
            <div class="topbar-right">
                <div class="badge-role {{ $roleBadge }}">
                    <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block"></span>
                    {{ ucwords($roleName) }}
                </div>
                <div class="avatar">{{ strtoupper(substr($adminUser?->nama ?? 'A', 0, 1)) }}</div>
            </div>
        </header>
        <div class="content">
            @yield('content')
        </div>
    </div>

    <script>
        function toggleSidebar(){document.getElementById('sidebar').classList.toggle('open');document.getElementById('sbOverlay').classList.toggle('show')}
        document.querySelectorAll('.sb-link').forEach(l=>{l.addEventListener('click',()=>{if(window.innerWidth<=1024){document.getElementById('sidebar').classList.remove('open');document.getElementById('sbOverlay').classList.remove('show')}})});
    </script>
</body>
</html>