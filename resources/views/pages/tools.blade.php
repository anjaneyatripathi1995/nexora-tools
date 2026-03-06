@extends('layouts.site')

@php
    $pageTitle = 'All Tools';
    $pageDesc = 'Explore every free online tool on Nexora — PDF, developer, SEO, image, finance & more.';
    $canonical = route('tools.index');
    $qLower = strtolower(trim($q ?? ''));
    $categories = config('nexora.categories', []);
    $catColor = fn (string $cat) => ($categories[$cat]['color'] ?? '#6B7280');
    $catBg = fn (string $cat) => ($categories[$cat]['bg'] ?? '#F3F4F6');
@endphp

@section('content')
<div class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>🛠 All Tools</h1>
            <p>{{ count($tools ?? []) }}+ free tools — pick what you need</p>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div style="max-width:540px;margin:0 auto 36px;display:flex;background:var(--bg-card);border:1.5px solid var(--border);border-radius:12px;overflow:hidden">
            <span style="padding:0 14px 0 18px;display:flex;align-items:center;color:var(--text-3)"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg></span>
            <input type="text" id="toolsPageSearch" placeholder="Filter tools..." value="{{ $q ?? '' }}" style="flex:1;padding:13px 0;font-size:.95rem;border:none;outline:none;background:transparent;color:var(--text)">
        </div>

        <div class="cat-tabs">
            <button class="cat-tab active" data-cat="all">All <span class="cat-count">{{ count($tools ?? []) }}</span></button>
            @foreach ($categories as $slug => $cat)
                <button class="cat-tab" data-cat="{{ $slug }}">{{ $cat['icon'] }} {{ $cat['name'] }} <span class="cat-count">{{ count($toolsByCat[$slug] ?? []) }}</span></button>
            @endforeach
        </div>

        <div class="tools-grid" id="allToolsGrid">
            @foreach (($tools ?? []) as $t)
                <a href="{{ url('/tools/' . $t['slug']) }}" class="tool-card" data-cat="{{ $t['cat'] }}" data-name="{{ strtolower($t['name']) }}" data-desc="{{ strtolower($t['desc']) }}">
                    <div class="tool-card-icon" style="background:{{ $catBg($t['cat']) }};color:{{ $catColor($t['cat']) }}">{{ $t['icon'] }}</div>
                    <div class="tool-card-body">
                        <div class="tool-card-name">{{ $t['name'] }}</div>
                        <div class="tool-card-desc">{{ $t['desc'] }}</div>
                        <div class="tool-card-badges">
                            @if (!empty($t['popular'])) <span class="badge badge-popular">⭐ Popular</span> @endif
                            @if (!empty($t['new'])) <span class="badge badge-new">New</span> @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<script>
(function(){
    const i=document.getElementById('toolsPageSearch');
    const c=document.querySelectorAll('#allToolsGrid .tool-card');
    if(!i) return;
    function f(){
        const q=(i.value||'').toLowerCase();
        c.forEach(x=>{
            x.classList.toggle('hidden', !!q && !x.dataset.name.includes(q) && !x.dataset.desc.includes(q));
        });
    }
    i.addEventListener('input', f);
    if(i.value) f();
})();
</script>
@endsection
