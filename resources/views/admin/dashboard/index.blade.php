@extends('admin.layout')

@section('content')
@php
    $adminUser = Auth::guard('admin')->user();
    $roleName = $adminUser?->getRoleNames()->first() ?? 'admin';
    $isAdmin = $roleName === 'admin';
@endphp

{{-- PAGE HEADER --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between">
    <div>
        <div style="font-size:9px;font-weight:600;color:#185FA5;letter-spacing:0.15em;margin-bottom:3px;text-transform:uppercase">Dashboard</div>
        <div style="font-size:18px;font-weight:600;color:#0f172a">Selamat datang, {{ $adminUser->nama ?? 'Admin' }}</div>
        <div style="font-size:11px;color:#64748b;margin-top:3px">
            @if($isAdmin) Akses penuh — kelola pengguna, konten, magang, riset, kuis, dan pengaturan sistem.
            @elseif(str_contains($roleName,'operator')) Kelola konten edukasi, magang, dan kuis.
            @else Kelola program magang, presensi, dan pengaturan pendukung.
            @endif
        </div>
    </div>
</div>

{{-- STATS GRID --}}
<div style="display:grid;grid-template-columns:repeat(5,1fr);gap:10px">
    @php
    $statItems = [
        ['label'=>'Admin','count'=>$totalAdmin??0,'color'=>'green','icon'=>'ti-shield-check'],
        ['label'=>'User','count'=>$totalUser??0,'color'=>'blue','icon'=>'ti-user'],
        ['label'=>'Konsultan','count'=>$totalKonsultan??0,'color'=>'pink','icon'=>'ti-tie'],
        ['label'=>'Jadwal','count'=>$totalJadwal??0,'color'=>'teal','icon'=>'ti-calendar'],
        ['label'=>'FAQ','count'=>$totalFaq??0,'color'=>'purple','icon'=>'ti-help'],
    ];
    $colors=[
        'green'=>['iconBg'=>'#EAF3DE','iconColor'=>'#3B6D11','pillBg'=>'#EAF3DE','pillColor'=>'#3B6D11','accent'=>'#639922'],
        'blue'=>['iconBg'=>'#E6F1FB','iconColor'=>'#185FA5','pillBg'=>'#E6F1FB','pillColor'=>'#185FA5','accent'=>'#378ADD'],
        'pink'=>['iconBg'=>'#FBEAF0','iconColor'=>'#993556','pillBg'=>'#FBEAF0','pillColor'=>'#993556','accent'=>'#D4537E'],
        'teal'=>['iconBg'=>'#E1F5EE','iconColor'=>'#0F6E56','pillBg'=>'#E1F5EE','pillColor'=>'#0F6E56','accent'=>'#1D9E75'],
        'purple'=>['iconBg'=>'#EEEDFE','iconColor'=>'#534AB7','pillBg'=>'#EEEDFE','pillColor'=>'#534AB7','accent'=>'#7F77DD'],
    ];
    @endphp
    @foreach($statItems as $s)
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:12px 14px;position:relative;overflow:hidden">
        <div style="position:absolute;top:0;right:0;width:48px;height:48px;border-radius:0 0 0 50%;background:{{$colors[$s['color']]['accent']}};opacity:0.22;pointer-events:none"></div>
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;position:relative">
            <div style="width:32px;height:32px;border-radius:8px;background:{{$colors[$s['color']]['iconBg']}};color:{{$colors[$s['color']]['iconColor']}};display:flex;align-items:center;justify-content:center;font-size:15px"><i class="ti {{$s['icon']}}"></i></div>
            <div style="font-size:9px;font-weight:600;padding:2px 7px;border-radius:999px;background:{{$colors[$s['color']]['pillBg']}};color:{{$colors[$s['color']]['pillColor']}}">{{strtoupper($s['label'])}}</div>
        </div>
        <div style="font-size:22px;font-weight:600;color:#0f172a;position:relative" class="counter" data-target="{{$s['count']}}">0</div>
        <div style="font-size:10px;color:#64748b;margin-top:2px;position:relative">Total {{strtolower($s['label'])}}</div>
    </div>
    @endforeach
</div>

{{-- MODULE HUB --}}
<div class="card">
    <div style="padding:14px 18px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between">
        <div>
            <div style="font-size:9px;font-weight:600;color:#185FA5;letter-spacing:0.15em;margin-bottom:2px;text-transform:uppercase">Modul utama</div>
            <div style="font-size:14px;font-weight:600;color:#0f172a">Pusat pengelolaan fitur</div>
            <div style="font-size:10px;color:#64748b;margin-top:1px">Edukasi, magang, riset, kuis, dan presensi terintegrasi</div>
        </div>
    </div>
    @php
    $modules = [
        ['route'=>'admin_subjek-materi.index','cat'=>'Edukasi','count'=>$totalSubjekMateri??0,'name'=>'Subjek materi','color'=>'#378ADD'],
        ['route'=>'admin_artikel.index','cat'=>'Edukasi','count'=>$totalArtikel??0,'name'=>'Artikel','color'=>'#1D9E75'],
        ['route'=>'admin_video-pembelajaran.index','cat'=>'Edukasi','count'=>$totalVideoPembelajaran??0,'name'=>'Video','color'=>'#7F77DD'],
        ['route'=>'admin_infografis.index','cat'=>'Edukasi','count'=>$totalInfografis??0,'name'=>'Infografis','color'=>'#D4537E'],
        ['route'=>'admin_informasi-magang.index','cat'=>'Magang','count'=>$totalInformasiMagang??0,'name'=>'Info magang','color'=>'#EF9F27'],
        ['route'=>'admin_daftar-magang.index-admin','cat'=>'Magang','count'=>$totalPendaftaranMagang??0,'name'=>'Pendaftar','color'=>'#BA7517'],
        ['route'=>'admin_informasi-riset.index','cat'=>'Riset','count'=>$totalInformasiRiset??0,'name'=>'Info riset','color'=>'#0F6E56'],
        ['route'=>'admin_daftar-riset.index-admin','cat'=>'Riset','count'=>$totalPendaftaranRiset??0,'name'=>'Pendaftar','color'=>'#1D9E75'],
        ['route'=>'admin_kuis-reguler.index','cat'=>'Kuis','count'=>$totalKuisReguler??0,'name'=>'Kuis reguler','color'=>'#534AB7'],
        ['route'=>'admin_kuis-tantangan-bulanan.index','cat'=>'Kuis','count'=>$totalTantanganBulanan??0,'name'=>'Tantangan','color'=>'#7F77DD'],
        ['route'=>'admin_pengaturan-presensi.index','cat'=>'Presensi','count'=>'-','name'=>'Pengaturan','color'=>'#888780'],
        ['route'=>'admin_wilayah-bps.index','cat'=>'Master','count'=>'-','name'=>'Wilayah BPS','color'=>'#5F5E5A'],
    ];
    @endphp
    <div style="display:grid;grid-template-columns:repeat(6,1fr);gap:8px;padding:14px">
        @foreach($modules as $m)
        <a href="{{ route($m['route']) }}" style="text-decoration:none;background:#f8fafc;border:1px solid #e2e8f0;border-left:3px solid {{$m['color']}};border-radius:0 8px 8px 0;padding:10px;cursor:pointer;transition:all 150ms;display:block" onmouseover="this.style.background='#fff';this.style.boxShadow='0 1px 6px rgba(0,0,0,0.06)'" onmouseout="this.style.background='#f8fafc';this.style.boxShadow='none'">
            <div style="font-size:9px;color:#94a3b8;font-weight:500;letter-spacing:0.06em;margin-bottom:2px">{{$m['cat']}}</div>
            <div style="font-size:14px;font-weight:600;color:#0f172a;margin-bottom:1px">{{$m['count']}}</div>
            <div style="font-size:10px;color:#64748b">{{$m['name']}}</div>
        </a>
        @endforeach
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;padding:0 14px 14px">
        <a href="{{ route('alat-statistik.index') }}" target="_blank" style="background:#0C3060;border-radius:8px;padding:10px 12px;display:flex;align-items:center;justify-content:space-between;text-decoration:none;transition:background 150ms" onmouseover="this.style.background='#185FA5'" onmouseout="this.style.background='#0C3060'">
            <span style="font-size:11px;font-weight:500;color:#fff"><i class="ti ti-flask" style="font-size:14px;margin-right:4px"></i> Alat statistik</span>
            <i class="ti ti-arrow-right" style="font-size:14px;color:rgba(255,255,255,0.6)"></i>
        </a>
        <a href="{{ route('visualisasi.index') }}" target="_blank" style="background:#0C3060;border-radius:8px;padding:10px 12px;display:flex;align-items:center;justify-content:space-between;text-decoration:none;transition:background 150ms" onmouseover="this.style.background='#185FA5'" onmouseout="this.style.background='#0C3060'">
            <span style="font-size:11px;font-weight:500;color:#fff"><i class="ti ti-chart-bar" style="font-size:14px;margin-right:4px"></i> Visualisasi data</span>
            <i class="ti ti-arrow-right" style="font-size:14px;color:rgba(255,255,255,0.6)"></i>
        </a>
        <a href="{{ route('simulasi.index') }}" target="_blank" style="background:#0C3060;border-radius:8px;padding:10px 12px;display:flex;align-items:center;justify-content:space-between;text-decoration:none;transition:background 150ms" onmouseover="this.style.background='#185FA5'" onmouseout="this.style.background='#0C3060'">
            <span style="font-size:11px;font-weight:500;color:#fff"><i class="ti ti-math" style="font-size:14px;margin-right:4px"></i> Simulasi statistik</span>
            <i class="ti ti-arrow-right" style="font-size:14px;color:rgba(255,255,255,0.6)"></i>
        </a>
    </div>
</div>

{{-- CHART SECTION --}}
<div class="card">
    <div style="padding:14px 18px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between">
        <div>
            <div style="font-size:9px;font-weight:600;color:#185FA5;letter-spacing:0.15em;margin-bottom:2px;text-transform:uppercase">Statistik konsultasi</div>
            <div style="font-size:14px;font-weight:600;color:#0f172a">Grafik konsultasi bulanan</div>
            <div style="font-size:10px;color:#64748b;margin-top:1px">Rekap jumlah konsultasi berdasarkan posisi pengunjung</div>
        </div>
        <form method="GET" action="{{ route('dashboard.index') }}">
            <select name="tahun" onchange="this.form.submit()" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;padding:4px 8px;font-size:11px;color:#0f172a;cursor:pointer">
                @foreach($availableYears as $year)
                    <option value="{{$year}}" {{$selectedYear==$year?'selected':''}}>{{$year}}</option>
                @endforeach
            </select>
        </form>
    </div>
    <div style="padding:14px 18px 18px">
        <div id="bar-chart" style="display:flex;align-items:flex-end;gap:6px;height:130px;margin-bottom:10px"></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:10px">
            <div style="background:#f8fafc;border-radius:10px;padding:12px 14px;display:flex;align-items:center;justify-content:space-between">
                <div>
                    <div style="font-size:10px;color:#64748b;margin-bottom:4px">Total konsultasi {{$selectedYear}}</div>
                    <div id="totalKonsultasi" style="font-size:18px;font-weight:600;color:#0f172a">0</div>
                </div>
                <div style="width:34px;height:34px;border-radius:8px;background:#E6F1FB;color:#185FA5;display:flex;align-items:center;justify-content:center;font-size:16px"><i class="ti ti-chart-bar"></i></div>
            </div>
            <div style="background:#f8fafc;border-radius:10px;padding:12px 14px;display:flex;align-items:center;justify-content:space-between">
                <div>
                    <div style="font-size:10px;color:#64748b;margin-bottom:4px">Bulan tertinggi</div>
                    <div id="bulanTertinggi" style="font-size:18px;font-weight:600;color:#0f172a">—</div>
                </div>
                <div style="width:34px;height:34px;border-radius:8px;background:#EAF3DE;color:#3B6D11;display:flex;align-items:center;justify-content:center;font-size:16px"><i class="ti ti-trending-up"></i></div>
            </div>
        </div>
    </div>
</div>

<script>
window.dataKonsultasiBulanan = @json($dataKonsultasiBulanan);

document.addEventListener('DOMContentLoaded', () => {
    const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    const totalData = window.dataKonsultasiBulanan?.totalBulanan || Array(12).fill(0);
    const maxVal = Math.max(...totalData, 1);
    const wrap = document.getElementById('bar-chart');
    wrap.innerHTML = '';
    let total = 0, maxBulan = 0, maxBulanIdx = -1;
    months.forEach((m,i) => {
        const val = totalData[i] || 0;
        total += val;
        if (val > maxBulan) { maxBulan = val; maxBulanIdx = i; }
        const pct = Math.round((val / maxVal) * 100);
        const col = document.createElement('div');
        col.style.cssText = 'display:flex;flex-direction:column;align-items:center;flex:1;gap:4px';
        col.innerHTML = `<div style="width:100%;border-radius:4px 4px 0 0;min-height:4px;background:${val>0?'#378ADD':'#f1f5f9'};height:${Math.max(pct,4)}%"></div><div style="font-size:9px;color:#94a3b8">${m}</div>`;
        wrap.appendChild(col);
    });
    document.getElementById('totalKonsultasi').textContent = total;
    document.getElementById('bulanTertinggi').textContent = maxBulanIdx >= 0 ? `${months[maxBulanIdx]} (${maxBulan})` : '—';
});

// Counter animation
const counters = document.querySelectorAll('.counter');
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const target = +entry.target.getAttribute('data-target');
            let count = 0;
            const speed = Math.max(15, Math.floor(500 / (target || 1)));
            const update = () => {
                if (count < target) { count += Math.ceil(target / speed); if (count > target) count = target; entry.target.textContent = count; requestAnimationFrame(update); }
                else { entry.target.textContent = target; }
            };
            update();
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });
counters.forEach(c => observer.observe(c));
</script>
@endsection