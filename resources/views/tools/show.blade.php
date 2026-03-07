@extends('layouts.site')

@push('head_styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/tools.css') }}">
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@php
    $toolSlug   = $tool['slug'] ?? '';
    $wideLayout = $toolSlug === 'json-formatter';
    $categories = config('nexora.categories', []);
    $catSlug    = $tool['cat'] ?? null;
    $catInfo    = $catSlug ? ($categories[$catSlug] ?? null) : null;
    $toolIcon   = $tool['icon'] ?? '🛠';
    $isFaIcon   = is_string($toolIcon) && str_starts_with($toolIcon, 'fa-');
@endphp

@section('title', ($tool['name'] ?? 'Tool') . ' - Free Online Tool')

@section('content')

{{-- Sub-banner: same pattern as all other internal pages --}}
<div class="sub-banner tool-sub-banner">
    <div class="{{ $catSlug==='dev' ? 'container-fluid px-lg-5' : 'container' }}">
        <div class="sub-banner-inner">
            <div class="sub-banner-tool-icon" style="background:{{ $catInfo['bg'] ?? '#DBEAFE' }};color:{{ $catInfo['color'] ?? '#3B82F6' }}">
                @if($isFaIcon)
                    <i class="fa-solid {{ $toolIcon }}"></i>
                @else
                    {{ $toolIcon }}
                @endif
            </div>
            <h1>{{ $tool['name'] ?? 'Tool' }}</h1>
            <p>{{ $tool['desc'] ?? '' }}</p>
            <div class="sub-banner-pills">
                <span class="sub-banner-pill"><i class="fa-solid fa-circle-check"></i> Free</span>
                <span class="sub-banner-pill"><i class="fa-solid fa-bolt"></i> Instant results</span>
                <span class="sub-banner-pill"><i class="fa-solid fa-shield-halved"></i> No data stored</span>
                @auth
                <button type="button"
                        class="sub-banner-pill sub-banner-save {{ ($isSaved ?? false) ? 'saved' : '' }}"
                        id="save-tool-btn"
                        data-item-type="tool"
                        data-item-slug="{{ $toolSlug }}"
                        title="{{ ($isSaved ?? false) ? 'Remove from saved' : 'Save for later' }}">
                    <i class="fa-{{ ($isSaved ?? false) ? 'solid fa-bookmark' : 'regular fa-bookmark' }}"></i>
                    <span class="btn-text">{{ ($isSaved ?? false) ? 'Saved' : 'Save' }}</span>
                </button>
                @endauth
            </div>
            <div class="breadcrumb">
                <a href="{{ url('/') }}">Home</a> /
                <a href="{{ route('tools.index') }}">Tools</a>
                @if($currentCategory)
                / <a href="{{ route('categories.show', ['category' => $catSlug]) }}">{{ $currentCategory }}</a>
                @endif
                / {{ $tool['name'] ?? 'Tool' }}
            </div>
        </div>
    </div>
</div>

{{-- Tool content section --}}
<section class="section tool-section">
    <div class="{{ $wideLayout ? 'container-fluid px-lg-5' : ($catSlug==='dev' ? 'container-fluid px-lg-5' : 'container') }} tools-page-content">
        <div class="tool-layout {{ $wideLayout ? 'tool-layout--wide' : '' }} {{ $catSlug==='dev' ? 'tool-layout--dev' : '' }}">

            {{-- Main Tool Area --}}
            <div class="tool-content-area">
                <div class="tool-page-card">
                    {{-- Tool partial --}}
                    @if($tool_partial && view()->exists('tools.partials.' . $tool_partial))
                        @include('tools.partials.' . $tool_partial)
                    @else
                        <div class="tool-empty-state">
                            <i class="fa-solid fa-gears"></i>
                            <p>This tool is being improved. Check back soon.</p>
                            <a href="{{ route('tools.index') }}" class="btn btn-primary">Browse all tools</a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar (hidden for wide/json-formatter layout) --}}
            @unless($wideLayout)
            <aside class="tool-sidebar">

                @if(!empty($relatedTools))
                <div class="sidebar-card">
                    <div class="sidebar-card-head">
                        <i class="fa-solid fa-layer-group" style="color:{{ $catInfo['color'] ?? '#3B82F6' }}"></i>
                        {{ $currentCategory ?? 'Tools' }}
                    </div>
                    <ul class="sidebar-tool-list">
                        @foreach($relatedTools as $t)
                        @php
                            $tIcon = $t['icon'] ?? '🛠';
                            $tFa   = is_string($tIcon) && str_starts_with($tIcon, 'fa-');
                        @endphp
                        <li>
                            <a href="{{ route('tools.show', ['slug' => $t['slug']]) }}"
                               class="sidebar-tool-link {{ ($t['slug'] ?? '') === $toolSlug ? 'active' : '' }}">
                                <span class="sidebar-tool-icon" style="background:{{ $catInfo['bg'] ?? '#DBEAFE' }};color:{{ $catInfo['color'] ?? '#3B82F6' }}">
                                    @if($tFa)<i class="fa-solid {{ $tIcon }}"></i>@else{{ $tIcon }}@endif
                                </span>
                                <span class="sidebar-tool-name">{{ $t['name'] ?? '' }}</span>
                                <i class="fa-solid fa-chevron-right sidebar-tool-arrow"></i>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('categories.show', ['category' => $catSlug]) }}" class="sidebar-view-all">
                        View all {{ $currentCategory ?? '' }} tools &rarr;
                    </a>
                </div>
                @endif

                <div class="sidebar-card sidebar-tip-card">
                    <div class="sidebar-tip-icon"><i class="fa-solid fa-lightbulb"></i></div>
                    <div class="sidebar-tip-text">
                        <strong>Did you know?</strong> All Nexora Tools are free, work entirely in your browser, and require no sign-up.
                    </div>
                    <a href="{{ route('register') }}" class="btn btn-primary w-full mt-3" style="width:100%;text-align:center;display:block">
                        <i class="fa-solid fa-user-plus"></i> Create Free Account
                    </a>
                    <p style="text-align:center;font-size:0.78rem;color:var(--text-3);margin-top:8px;margin-bottom:0">
                        Save history &amp; access premium features
                    </p>
                </div>

            </aside>
            @endunless

        </div>
    </div>
</section>

@push('scripts')
<script>
(function () {
    var btn = document.getElementById('save-tool-btn');
    if (!btn) return;
    btn.addEventListener('click', function () {
        var type = this.getAttribute('data-item-type');
        var slug = this.getAttribute('data-item-slug');
        if (!type || !slug) return;
        this.disabled = true;
        var fd = new FormData();
        fd.append('item_type', type);
        fd.append('item_slug', slug);
        fd.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        fetch('{{ route("saved-items.toggle") }}', {
            method: 'POST', body: fd,
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            var icon = btn.querySelector('i');
            var text = btn.querySelector('.btn-text');
            if (d.saved) {
                btn.classList.add('saved');
                if (icon) { icon.className = 'fa-solid fa-bookmark'; }
                if (text) text.textContent = 'Saved';
                btn.title = 'Remove from saved';
            } else {
                btn.classList.remove('saved');
                if (icon) { icon.className = 'fa-regular fa-bookmark'; }
                if (text) text.textContent = 'Save';
                btn.title = 'Save for later';
            }
            if (typeof showToast === 'function') showToast(d.message, 'success');
        })
        .catch(function () {
            if (typeof showToast === 'function') showToast('Something went wrong.', 'danger');
        })
        .finally(function () { btn.disabled = false; });
    });
})();
</script>
@endpush

@endsection
