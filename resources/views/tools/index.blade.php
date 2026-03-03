@extends('layouts.app')

@section('title', 'Utility Tools')
@section('meta_description', 'Free online tools: Finance calculators, PDF tools, text tools, developer tools, image tools.')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
@include('partials.page-banner', [
    'image'       => 'images/utility-banner-2.png',
    'tag'         => '32+ Free Tools — No Signup Required',
    'title'       => '🔧 Utility Tools',
    'subtitle'    => 'Quick, powerful online tools for finance, PDF, text, developer, and image tasks — all free, right in your browser.',
    'icon'        => 'fa-screwdriver-wrench',
    'accentColor' => '#2563eb',
    'breadcrumb'  => [['label'=>'Home','href'=>'/'], ['label'=>'Tools']],
    'links'       => [
        ['label'=>'Finance',   'href'=>'#finance'],
        ['label'=>'PDF & File','href'=>'#pdf'],
        ['label'=>'Text',      'href'=>'#text'],
        ['label'=>'Developer', 'href'=>'#developer'],
        ['label'=>'Image',     'href'=>'#image'],
    ],
])

<div class="container py-5 tools-page-content">
    @include('tools.partials.tools-mega-menu')

    {{-- Search and category filter --}}
    <div class="row align-items-center gap-3 mb-4 p-3 rounded-4 bg-light border">
        <div class="col-md-6 col-lg-5">
            <label for="tools-search" class="form-label small fw-semibold text-body-secondary mb-1">Search tools</label>
            <input type="search" id="tools-search" class="form-control form-control-lg border-0 shadow-sm" placeholder="Type tool name or keyword..." aria-label="Search tools">
        </div>
        <div class="col-md-6 col-lg-5">
            <label class="form-label small fw-semibold text-body-secondary mb-1">Category</label>
            <div class="d-flex flex-wrap gap-2" id="tools-category-filter">
                <button type="button" class="btn btn-primary btn-sm filter-cat active" data-category="">All</button>
                @foreach(array_keys($catalog) as $cat)
                <button type="button" class="btn btn-outline-secondary btn-sm filter-cat" data-category="{{ \Illuminate\Support\Str::slug($cat) }}">{{ $cat }}</button>
                @endforeach
            </div>
        </div>
    </div>

    @php
        $sectionIds = [
            'Finance & Date' => 'finance',
            'PDF & File' => 'pdf',
            'Text & Content' => 'text',
            'Developer' => 'developer',
            'Image' => 'image',
        ];
    @endphp

    @foreach($catalog as $category => $tools)
        @php $sectionId = $sectionIds[$category] ?? \Illuminate\Support\Str::slug($category); @endphp
        <section id="{{ $sectionId }}" class="tool-category-section mb-5 scroll-margin-top" data-category="{{ $sectionId }}">
            <div class="d-flex align-items-center mb-4">
                <h2 class="h3 fw-bold mb-0 me-3">{{ $category }}</h2>
                <span class="badge bg-primary rounded-pill">{{ count($tools) }} tools</span>
            </div>
            <div class="row g-4">
                @foreach($tools as $t)
                    @php
                        $inDb = $dbTools->has($t['slug']);
                    @endphp
                    <div class="col-sm-6 col-lg-4 col-xl-3 tool-card-wrapper" data-name="{{ strtolower($t['name']) }}" data-desc="{{ strtolower($t['description']) }}" data-category="{{ $sectionId }}">
                        <a href="{{ route('tools.show', $t['slug']) }}" class="tool-card-link text-decoration-none">
                            <div class="tool-card-item h-100">
                                <div class="tool-card-icon bg-{{ $t['color'] }} bg-opacity-25 rounded-3 p-3 mb-3">
                                    <i class="fa-solid {{ $t['icon'] }} fa-2x text-{{ $t['color'] }}"></i>
                                </div>
                                <h5 class="fw-bold mb-2">{{ $t['name'] }}</h5>
                                <p class="small mb-3">{{ $t['description'] }}</p>
                                <span class="btn btn-sm btn-outline-{{ $t['color'] }}">
                                    {{ $inDb ? 'Open Tool' : 'Coming Soon' }}
                                    <i class="fa-solid fa-arrow-right ms-1 small"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach
</div>

@push('scripts')
<script>
(function() {
    var searchEl = document.getElementById('tools-search');
    var filterBtns = document.querySelectorAll('#tools-category-filter .filter-cat');
    var sections = document.querySelectorAll('.tool-category-section');
    var cards = document.querySelectorAll('.tool-card-wrapper');

    function applyFilters() {
        var q = (searchEl && searchEl.value) ? searchEl.value.trim().toLowerCase() : '';
        var cat = '';
        filterBtns.forEach(function(btn) {
            if (btn.classList.contains('active')) cat = (btn.getAttribute('data-category') || '').toLowerCase();
        });

        cards.forEach(function(wrap) {
            var name = wrap.getAttribute('data-name') || '';
            var desc = wrap.getAttribute('data-desc') || '';
            var cardCat = (wrap.getAttribute('data-category') || '').toLowerCase();
            var matchSearch = !q || name.indexOf(q) !== -1 || desc.indexOf(q) !== -1;
            var matchCat = !cat || cardCat === cat;
            wrap.style.display = (matchSearch && matchCat) ? '' : 'none';
        });

        sections.forEach(function(section) {
            var sectionCards = section.querySelectorAll('.tool-card-wrapper');
            var visible = 0;
            sectionCards.forEach(function(c) { if (c.style.display !== 'none') visible++; });
            section.style.display = visible > 0 ? '' : 'none';
        });
    }

    if (searchEl) {
        searchEl.addEventListener('input', applyFilters);
        searchEl.addEventListener('search', applyFilters);
    }
    filterBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            filterBtns.forEach(function(b) {
                b.classList.remove('active', 'btn-primary');
                b.classList.add('btn-outline-secondary');
            });
            this.classList.add('active', 'btn-primary');
            this.classList.remove('btn-outline-secondary');
            applyFilters();
        });
    });
})();
</script>
@endpush
@endsection
