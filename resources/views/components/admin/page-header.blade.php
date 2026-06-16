{{-- Admin Page Header — breadcrumb + title + action button --}}
@props(['title', 'subtitle' => null, 'breadcrumbs' => [], 'addRoute' => null, 'addLabel' => 'Tambah Data'])

<div class="page-header" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px">
    <div>
        @if(!empty($breadcrumbs))
        <div style="display:flex;align-items:center;gap:5px;font-size:12px;color:#64748b;margin-bottom:4px">
            @foreach($breadcrumbs as $i => $crumb)
                @if($i > 0) <i class="ti ti-chevron-right" style="font-size:10px"></i> @endif
                <span @if($loop->last) style="color:#0f172a;font-weight:600" @endif>{{ $crumb }}</span>
            @endforeach
        </div>
        @endif
        <div style="font-size:16px;font-weight:600;color:#0f172a">{{ $title }}</div>
        @if($subtitle)
        <div style="font-size:12px;color:#64748b;margin-top:2px">{{ $subtitle }}</div>
        @endif
    </div>
    @if($addRoute)
    <a href="{{ $addRoute }}" class="btn-add" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:#1F6FD6;color:#fff;border-radius:8px;font-size:12px;font-weight:500;text-decoration:none;transition:background 120ms;white-space:nowrap" onmouseover="this.style.background='#185FA5'" onmouseout="this.style.background='#1F6FD6'">
        <i class="ti ti-plus" style="font-size:14px"></i> {{ $addLabel }}
    </a>
    @endif
</div>