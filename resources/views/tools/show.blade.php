@extends('layouts.app')

@section('title', $tool->name . ' - Free Online Tool')
@section('meta_description', $tool->description)

@section('content')
@php
    $toolSlug = $tool->slug ?? '';
    $wideLayout = $toolSlug === 'json-formatter';
@endphp

<div class="{{ $wideLayout ? 'container-fluid px-lg-5 json-formatter-wrap' : 'container' }} py-4 py-lg-3 tools-page-content">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tools.index') }}">Tools</a></li>
            @if(!empty($currentCategory))
            <li class="breadcrumb-item"><a href="{{ route('tools.index') }}#{{ \Illuminate\Support\Str::slug($currentCategory) }}">{{ $currentCategory }}</a></li>
            @endif
            <li class="breadcrumb-item active">{{ $tool->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        {{-- ── Main Tool Area ──────────────────────────── --}}
        <div class="{{ $wideLayout ? 'col-12' : 'col-lg-8 col-xl-9' }}">
            <div class="tool-page-card rounded-4 shadow-sm border-0 p-4 p-lg-5 mb-3 {{ $wideLayout ? 'json-formatter-card' : '' }}">
                {{-- Tool header --}}
                <div class="d-flex align-items-start gap-3 mb-4 pb-3 border-bottom">
                    <div class="tool-page-icon rounded-3 p-3 bg-primary bg-opacity-10 flex-shrink-0">
                        @if(str_starts_with($tool->icon ?? '', 'fa-'))
                            <i class="fa-solid {{ $tool->icon }} fa-2x text-primary"></i>
                        @else
                            <span class="fs-2">{{ $tool->icon }}</span>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex flex-wrap align-items-start justify-content-between gap-2">
                            <div>
                                <h1 class="h2 fw-bold mb-1">{{ $tool->name }}</h1>
                                <p class="text-body-secondary mb-2">{{ $tool->description }}</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-success-subtle text-success-emphasis"><i class="fa-solid fa-circle-check me-1"></i>Free</span>
                                    <span class="badge bg-primary-subtle text-primary-emphasis"><i class="fa-solid fa-bolt me-1"></i>Instant results</span>
                                    <span class="badge bg-warning-subtle text-warning-emphasis"><i class="fa-solid fa-shield-halved me-1"></i>No data stored</span>
                                </div>
                            </div>
                            @auth
                            <button type="button" class="btn btn-outline-primary btn-sm btn-save-toggle align-self-center {{ $isSaved ?? false ? 'saved' : '' }}" id="save-tool-btn" data-item-type="tool" data-item-slug="{{ $tool->slug }}" title="{{ $isSaved ?? false ? 'Remove from saved' : 'Save for later' }}">
                                <i class="fa-{{ ($isSaved ?? false) ? 'solid fa-bookmark' : 'regular fa-bookmark' }} me-1"></i>
                                <span class="btn-text">{{ ($isSaved ?? false) ? 'Saved' : 'Save' }}</span>
                            </button>
                            @endauth
                        </div>
                    </div>
                </div>

                {{-- Tool partial --}}
                @if($tool_partial && view()->exists('tools.partials.' . $tool_partial))
                    @include('tools.partials.' . $tool_partial)
                @else
                    <div class="text-center py-5">
                        <i class="fa-solid fa-gears fa-3x text-muted mb-3"></i>
                        <p class="text-body-secondary mb-3">This tool is being improved. Check back soon.</p>
                        <a href="{{ route('tools.index') }}" class="btn btn-outline-primary">Browse all tools</a>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Sidebar ──────────────────────────────────── --}}
        @unless($wideLayout)
        <div class="col-lg-4 col-xl-3">

            {{-- Related Tools in same category --}}
            @if(!empty($relatedTools))
            <div class="sidebar-card mb-3">
                <div class="sidebar-card-head">
                    <i class="fa-solid fa-layer-group me-2 text-primary"></i>
                    {{ $currentCategory }} Tools
                </div>
                <ul class="sidebar-tool-list">
                    @foreach($relatedTools as $t)
                    <li>
                        <a href="{{ route('tools.show', $t['slug']) }}" class="sidebar-tool-link {{ $t['slug'] === $tool->slug ? 'active' : '' }}">
                            <span class="sidebar-tool-icon bg-{{ $t['color'] }}-subtle">
                                <i class="fa-solid {{ $t['icon'] }} text-{{ $t['color'] }}"></i>
                            </span>
                            <span class="sidebar-tool-name">{{ $t['name'] }}</span>
                            <i class="fa-solid fa-chevron-right ms-auto text-muted small"></i>
                        </a>
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('tools.index') }}#{{ \Illuminate\Support\Str::slug($currentCategory) }}" class="sidebar-view-all">
                    View all {{ $currentCategory }} tools →
                </a>
            </div>
            @endif

            {{-- All PDF & File tools (always visible) --}}
            @if(!empty($allCategories['PDF & File']))
            <div class="sidebar-card mb-3">
                <div class="sidebar-card-head">
                    <i class="fa-solid fa-file-pdf me-2 text-danger"></i>
                    All PDF Tools
                </div>
                <ul class="sidebar-tool-list">
                    @foreach($allCategories['PDF & File'] as $t)
                    <li>
                        <a href="{{ route('tools.show', $t['slug']) }}" class="sidebar-tool-link {{ $t['slug'] === $tool->slug ? 'active' : '' }}">
                            <span class="sidebar-tool-icon bg-{{ $t['color'] }}-subtle">
                                <i class="fa-solid {{ $t['icon'] }} text-{{ $t['color'] }}"></i>
                            </span>
                            <span class="sidebar-tool-name">{{ $t['name'] }}</span>
                            <i class="fa-solid fa-chevron-right ms-auto text-muted small"></i>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Quick Category Jump --}}
            @if(!empty($otherCategories))
            <div class="sidebar-card mb-3">
                <div class="sidebar-card-head">
                    <i class="fa-solid fa-compass me-2 text-primary"></i>Explore by Category
                </div>
                <div class="d-flex flex-column gap-2 p-3 pt-0">
                    @php
                    $catMeta = [
                        'Finance & Date'  => ['icon'=>'fa-coins','color'=>'warning','href'=>'/tools#finance'],
                        'PDF & File'      => ['icon'=>'fa-file-pdf','color'=>'danger','href'=>'/tools#pdf'],
                        'Text & Content'  => ['icon'=>'fa-pen-fancy','color'=>'primary','href'=>'/tools#text'],
                        'Developer'       => ['icon'=>'fa-code','color'=>'dark','href'=>'/tools#developer'],
                        'Image'           => ['icon'=>'fa-image','color'=>'info','href'=>'/tools#image'],
                    ];
                    @endphp
                    @foreach($otherCategories as $cat)
                    @php $meta = $catMeta[$cat] ?? ['icon'=>'fa-wrench','color'=>'secondary','href'=>'/tools']; @endphp
                    <a href="{{ $meta['href'] }}" class="sidebar-cat-pill">
                        <i class="fa-solid {{ $meta['icon'] }} text-{{ $meta['color'] }}"></i>
                        <span>{{ $cat }}</span>
                    </a>
                    @endforeach
                    <a href="{{ route('tools.index') }}" class="sidebar-cat-pill sidebar-cat-pill--all">
                        <i class="fa-solid fa-grid-2"></i>
                        <span>All Tools</span>
                    </a>
                </div>
            </div>
            @endif

            {{-- Pro tip / info card --}}
            <div class="sidebar-card sidebar-tip-card">
                <div class="sidebar-tip-icon"><i class="fa-solid fa-lightbulb"></i></div>
                <div class="sidebar-tip-text">
                    <strong>Did you know?</strong> All TechHub tools are free, work entirely in your browser, and require no sign-up.
                </div>
                <a href="/register" class="btn btn-primary btn-sm w-100 mt-3 fw-semibold">
                    <i class="fa-solid fa-user-plus me-1"></i>Create Free Account
                </a>
                <p class="text-center text-muted mt-2 mb-0" style="font-size:0.78rem">Save history & access premium features</p>
            </div>

        </div>
        @endunless
    </div>
</div>
@endsection

@push('styles')
<style>
/* ── Tool page card ─────────────────────────── */
.tool-page-card {
    background: #fff;
    border: 1px solid #e2e8f0 !important;
}
.tool-page-icon { display: flex; align-items: center; justify-content: center; min-width: 64px; min-height: 64px; }

/* ── Sidebar ─────────────────────────────────── */
.sidebar-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
}
.sidebar-card-head {
    padding: 0.85rem 1.25rem;
    font-weight: 700;
    font-size: 0.9rem;
    color: #0f172a;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}

/* Tool list */
.sidebar-tool-list { list-style: none; padding: 0.5rem 0; margin: 0; }
.sidebar-tool-list li { padding: 0.15rem 0.75rem; }
.sidebar-tool-link {
    display: flex; align-items: center; gap: 0.75rem;
    padding: 0.55rem 0.75rem; border-radius: 10px;
    text-decoration: none; color: #374151;
    font-size: 0.88rem; font-weight: 500;
    transition: all 0.15s;
}
.sidebar-tool-link:hover { background: #eff6ff; color: #2563eb; }
.sidebar-tool-link.active { background: #dbeafe; color: #1e40af; font-weight: 700; }
.sidebar-tool-icon {
    width: 32px; height: 32px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem; flex-shrink: 0;
}
.sidebar-tool-name { flex: 1; }
.sidebar-view-all {
    display: block; text-align: center; padding: 0.6rem;
    font-size: 0.82rem; font-weight: 600; color: #2563eb;
    border-top: 1px solid #f1f5f9; text-decoration: none;
    background: #f8fafc;
}
.sidebar-view-all:hover { background: #eff6ff; }

/* Category pills */
.sidebar-cat-pill {
    display: flex; align-items: center; gap: 0.65rem;
    padding: 0.6rem 0.85rem; border-radius: 10px;
    border: 1px solid #e2e8f0; background: #f8fafc;
    color: #374151; font-size: 0.87rem; font-weight: 500;
    text-decoration: none; transition: all 0.15s;
}
.sidebar-cat-pill:hover { border-color: #93c5fd; background: #eff6ff; color: #2563eb; }
.sidebar-cat-pill--all { background: #fff; border-color: #2563eb; color: #2563eb; font-weight: 700; }
.sidebar-cat-pill--all:hover { background: #2563eb; color: #fff; }

/* Tip card */
.sidebar-tip-card { padding: 1.25rem; border: 1px solid #fde68a; background: linear-gradient(135deg, #fffbeb, #fef9c3); }
.sidebar-tip-icon { font-size: 1.5rem; color: #d97706; margin-bottom: 0.5rem; }
.sidebar-tip-text { font-size: 0.85rem; color: #374151; line-height: 1.5; }

/* bg-*-subtle helpers for Bootstrap 4/5 compat */
.bg-primary-subtle { background: #dbeafe !important; }
.bg-success-subtle { background: #dcfce7 !important; }
.bg-warning-subtle { background: #fef9c3 !important; }
.bg-danger-subtle  { background: #fee2e2 !important; }
.bg-info-subtle    { background: #e0f2fe !important; }
.bg-dark-subtle    { background: #f1f5f9 !important; }
</style>
@endpush

@push('scripts')
<script>
(function() {
    var btn = document.getElementById('save-tool-btn');
    if (!btn) return;
    btn.addEventListener('click', function() {
        var type = this.getAttribute('data-item-type');
        var slug = this.getAttribute('data-item-slug');
        if (!type || !slug) return;
        this.disabled = true;
        var formData = new FormData();
        formData.append('item_type', type);
        formData.append('item_slug', slug);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        fetch('{{ route("saved-items.toggle") }}', { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(function(r) { return r.json(); })
            .then(function(d) {
                var icon = btn.querySelector('i');
                var text = btn.querySelector('.btn-text');
                if (d.saved) {
                    btn.classList.add('saved');
                    if (icon) { icon.classList.remove('fa-regular'); icon.classList.add('fa-solid'); }
                    if (text) text.textContent = 'Saved';
                } else {
                    btn.classList.remove('saved');
                    if (icon) { icon.classList.remove('fa-solid'); icon.classList.add('fa-regular'); }
                    if (text) text.textContent = 'Save';
                }
                if (typeof showToast === 'function') showToast(d.message, 'success'); else alert(d.message);
            })
            .catch(function() { if (typeof showToast === 'function') showToast('Something went wrong.', 'danger'); else alert('Something went wrong.'); })
            .finally(function() { btn.disabled = false; });
    });
})();
</script>
@endpush
