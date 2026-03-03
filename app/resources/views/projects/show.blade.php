@extends('layouts.app')

@section('title', $project['name'])
@section('meta_description', $project['description'])

@section('content')
<div class="container py-5 mt-2">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb text-white-50">
            <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-decoration-none">Projects</a></li>
            <li class="breadcrumb-item active text-light" aria-current="page">{{ $project['name'] }}</li>
        </ol>
    </nav>

    <div class="project-detail-card rounded-4 p-4 p-lg-5">
        <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
            <div class="project-detail-icon rounded-3 p-3 bg-{{ $project['color'] }} bg-opacity-25">
                <i class="fa-solid {{ $project['icon'] }} fa-3x text-{{ $project['color'] }}"></i>
            </div>
            <div class="flex-grow-1">
                <h1 class="h2 fw-bold mb-2">{{ $project['name'] }}</h1>
                <p class="text-white-50 mb-0">{{ $project['description'] }}</p>
            </div>
            @auth
            <button type="button" class="btn btn-outline-light btn-sm btn-save-toggle {{ $isSaved ?? false ? 'saved' : '' }}" id="save-project-btn" data-item-type="project" data-item-slug="{{ $project['slug'] }}" title="{{ $isSaved ?? false ? 'Remove from saved' : 'Save for later' }}">
                <i class="fa-{{ ($isSaved ?? false) ? 'solid' : 'regular' }} fa-bookmark me-1"></i>
                <span class="btn-text">{{ ($isSaved ?? false) ? 'Saved' : 'Save' }}</span>
            </button>
            @endauth
        </div>

        <div class="row mb-4">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h5 class="fw-bold mb-3">Features</h5>
                <ul class="list-unstyled">
                    @foreach($project['features'] as $f)
                    <li class="mb-2"><i class="fa-solid fa-check-circle text-success me-2"></i>{{ $f }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-6">
                <h5 class="fw-bold mb-3">Tech Stack</h5>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($project['tech_stack'] as $tech)
                    <span class="badge bg-{{ $project['color'] }} bg-opacity-75 px-3 py-2">{{ $tech }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <hr class="border-secondary">

        <h5 class="fw-bold mb-3">Get This Project</h5>
        <div class="d-flex flex-wrap gap-3">
            <a href="{{ $project['demo_url'] }}" class="btn btn-{{ $project['color'] }}">
                <i class="fa-solid fa-play me-2"></i>Coming Soon
            </a>
            <a href="{{ $project['github_url'] }}" class="btn btn-outline-light">
                <i class="fa-brands fa-github me-2"></i>Coming Soon
            </a>
            <a href="{{ $project['download_url'] }}" class="btn btn-outline-light">
                <i class="fa-solid fa-download me-2"></i>Coming Soon
            </a>
        </div>
        <p class="text-white-50 small mt-3 mb-0">Documentation is included with the source code.</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
    var btn = document.getElementById('save-project-btn');
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
            .catch(function() { alert('Something went wrong.'); })
            .finally(function() { btn.disabled = false; });
    });
})();
</script>
@endpush
