@extends('tools.layout')
@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('tools.index') }}">Tools</a></li><li class="breadcrumb-item active">{{ $tool['name'] }}</li></ol></nav>
    <h1 class="h2 mb-3">{{ $tool['name'] }}</h1>
    <p class="text-muted mb-4">{{ $tool['description'] }}</p>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ url('/tools/' . $tool['slug'] . '/process') }}" method="post">@csrf
                <label for="json" class="form-label">Paste JSON</label>
                <textarea name="json" id="json" class="form-control font-monospace" rows="8" placeholder='{"key": "value"}'>{{ $json ?? '' }}</textarea>
                @if(isset($error))<p class="text-danger small mt-2">{{ $error }}</p>@endif
                <button type="submit" class="btn btn-primary mt-2">Format / Validate</button>
            </form>
        </div>
    </div>
</div>
@endsection
