{{-- Admin Data Card — card putih dengan header + search + tabel --}}
@props(['icon' => 'ti-layout-list', 'title' => 'Data', 'searchPlaceholder' => 'Cari...', 'searchName' => 'search', 'searchValue' => ''])

<div class="card" style="background:#fff;border:0.5px solid #e2e8f0;border-radius:12px;overflow:hidden">
    <div class="card-header" style="padding:14px 18px;border-bottom:0.5px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between">
        <div style="font-size:13px;font-weight:600;color:#0f172a;display:flex;align-items:center;gap:8px">
            <i class="ti {{ $icon }}" style="font-size:16px;color:#1F6FD6"></i> {{ $title }}
            <span style="font-size:11px;font-weight:400;color:#94a3b8;margin-left:4px">— {{ $slot->attributes['total'] ?? '0' }} data</span>
        </div>
        <form action="" method="GET" style="display:flex;align-items:center;gap:8px;background:#f8fafc;border:0.5px solid #e2e8f0;border-radius:8px;padding:0 10px;height:32px">
            <i class="ti ti-search" style="font-size:14px;color:#94a3b8"></i>
            <input type="text" name="{{ $searchName }}" value="{{ $searchValue }}" placeholder="{{ $searchPlaceholder }}" style="border:none;background:transparent;font-size:12px;color:#0f172a;outline:none;width:180px">
        </form>
    </div>
    <div style="overflow-x:auto">
        {{ $slot }}
    </div>
</div>