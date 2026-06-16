@props(['route' => '#', 'label' => '', 'count' => 0, 'tag' => ''])

<a href="{{ $route }}" class="group rounded-2xl border border-slate-100 bg-slate-50 p-5 hover:bg-blue-50 hover:border-blue-200 transition-all focus:outline-none focus:ring-2 focus:ring-blue-400" aria-label="Kelola {{ $label }}">
    <div class="flex items-start justify-between gap-3">
        <div>
            <p class="text-[10px] font-black uppercase tracking-[0.18em] text-blue-600 mb-2">{{ $tag }}</p>
            <h3 class="text-base font-black text-slate-800 group-hover:text-blue-800">{{ $label }}</h3>
            <p class="text-xs text-slate-500 mt-1">Kelola data {{ strtolower($label) }}</p>
        </div>
        <div class="min-w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-xl font-black text-slate-800">
            {{ $count }}
        </div>
    </div>
</a>
