<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('image/logo-bpskecil.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/tabler-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/js/app.js'])
    <title>Konsultan Panel — Datapedia</title>
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
        .badge-konsultan{background:var(--brand-blue-light);color:#185FA5}
        .content{padding:16px 18px;flex:1;display:flex;flex-direction:column;gap:14px}
        .card{background:var(--color-surface);border:0.5px solid var(--color-border);border-radius:12px;overflow:hidden}

        @media(max-width:1024px){
            .sidebar{transform:translateX(-100%);transition:transform 240ms ease}
            .sidebar.open{transform:translateX(0)}
            .sb-overlay.show{display:block}
            .main{margin-left:0}
            .menu-btn{display:block}
        }

        /* ── Page header ── */
        .page-header-row{display:flex;align-items:center;justify-content:space-between}
        .page-title{font-size:16px;font-weight:500;color:var(--color-text)}
        .page-sub{font-size:12px;color:var(--color-muted);margin-top:2px}

        /* ── Card components ── */
        .card-header{padding:14px 18px;border-bottom:0.5px solid var(--color-border);display:flex;align-items:center;justify-content:space-between}
        .card-header-left{display:flex;align-items:center;gap:8px}
        .card-title{font-size:13px;font-weight:600;color:var(--color-text)}
        .card-title i{font-size:16px;color:var(--brand-blue)}
        .card-body{padding:20px}

        /* ── Table ── */
        .table-wrap{overflow-x:auto}
        table.data-table{width:100%;border-collapse:collapse}
        table.data-table thead tr{background:#f8fafc}
        table.data-table th{padding:10px 16px;text-align:left;font-size:11px;font-weight:600;color:var(--color-muted);border-bottom:0.5px solid var(--color-border);white-space:nowrap;text-transform:uppercase;letter-spacing:0.06em}
        table.data-table td{padding:12px 16px;font-size:12px;color:var(--color-text);border-bottom:0.5px solid var(--color-border)}
        table.data-table tr:last-child td{border-bottom:none}
        table.data-table tbody tr{transition:background 100ms}
        table.data-table tbody tr:hover{background:#f8fafc}

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

        /* ── Buttons ── */
        .btn-primary{display:inline-flex;align-items:center;gap:6px;padding:8px 18px;background:var(--brand-blue);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none;transition:background 150ms}
        .btn-primary:hover{background:#185FA5}
        .btn-primary i{font-size:14px}

        /* ── Badges ── */
        .badge-status{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:999px;font-size:10px;font-weight:500}
        .badge-active{background:var(--green-bg);color:var(--green-dark)}
        .badge-inactive{background:var(--red-bg);color:var(--red-dark)}

        /* ── Alert ── */
        .alert-success{background:var(--green-bg);border:1px solid #C9DEB5;color:var(--green-dark);padding:10px 14px;border-radius:8px;font-size:12px;margin-bottom:16px}
        .alert-error{background:var(--red-bg);border:1px solid #F7C1C1;color:var(--red-dark);padding:10px 14px;border-radius:8px;font-size:12px;margin-bottom:16px}

        /* ── Grid ── */
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px 20px}
        @media(max-width:640px){.form-grid{grid-template-columns:1fr}}

        /* ── Form actions ── */
        .form-actions{display:flex;align-items:center;gap:8px;margin-top:20px;padding-top:16px;border-top:0.5px solid var(--color-border)}

        /* ── Radio / Checkbox ── */
        .form-check{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--color-text);cursor:pointer}
        .form-check input[type=checkbox],.form-check input[type=radio]{accent-color:var(--brand-blue);width:15px;height:15px;cursor:pointer}

        /* ── Status card ── */
        .status-card{padding:16px;border-radius:12px;border:1px solid}
        .status-tersedia{background:var(--green-bg);border-color:#C9DEB5}
        .status-tidak-tersedia{background:var(--red-bg);border-color:#F7C1C1}
        .status-text-green{color:var(--green-dark);font-size:13px;font-weight:500}
        .status-text-red{color:var(--red-dark);font-size:13px;font-weight:500}
        .status-text-muted{color:var(--color-muted);font-style:italic}
    </style>
</head>
<body>
    @php
        $konsultan = Session::get('konsultanLogin');
        $konsultanNama = $konsultan->nama ?? 'Konsultan';
        $konsultanInisial = strtoupper(substr($konsultanNama, 0, 1));
    @endphp

    <div id="sbOverlay" class="sb-overlay" onclick="toggleSidebar()"></div>

    <aside id="sidebar" class="sidebar">
        <a href="{{ url('/') }}" class="sb-brand" style="text-decoration: none; color: inherit;">
            <div class="sb-logo"><img src="{{ asset('image/logo-pst.png') }}" alt="Logo"></div>
            <div class="sb-title">DATA<span>PEDIA</span></div>
        </a>
        <nav class="sb-nav">
            <div class="sb-section">Konsultan</div>
            <a href="{{ route('konsultan.jadwal.index') }}" class="sb-link {{ Route::is('konsultan.jadwal.index') ? 'active' : '' }}"><i class="ti ti-calendar"></i> Jadwal Janji Temu</a>
            <a href="{{ route('status.index') }}" class="sb-link {{ Route::is('status.index') || Route::is('status.store') ? 'active' : '' }}"><i class="ti ti-status-change"></i> Status Konsultan</a>
            <a href="{{ route('mingguan.index') }}" class="sb-link {{ Route::is('mingguan.index') || Route::is('mingguan.create') || Route::is('mingguan.edit') ? 'active' : '' }}"><i class="ti ti-calendar-week"></i> Petugas Mingguan</a>
            <a href="{{ route('konsultan.berprestasi') }}" class="sb-link {{ Route::is('konsultan.berprestasi') ? 'active' : '' }}"><i class="ti ti-star"></i> Petugas Berprestasi</a>

            <div class="sb-section" style="margin-top:auto"></div>
            <a href="{{ route('logoutKonsultan') }}" class="sb-link logout"><i class="ti ti-logout"></i> Logout</a>
        </nav>
    </aside>

    <div class="main">
        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-btn" onclick="toggleSidebar()" aria-label="Toggle menu"><i class="ti ti-menu-2"></i></button>
                <span>Konsultan Panel</span>
            </div>
            <div class="topbar-right">
                <div class="badge-role badge-konsultan">
                    <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block"></span>
                    Konsultan
                </div>
                <div class="avatar">{{ $konsultanInisial }}</div>
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