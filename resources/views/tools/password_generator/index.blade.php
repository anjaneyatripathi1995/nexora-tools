@extends('tools.layout')
@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('tools.index') }}">Tools</a></li><li class="breadcrumb-item active">{{ $tool['name'] }}</li></ol></nav>
    <h1 class="h2 mb-3">{{ $tool['name'] }}</h1>
    <p class="text-muted mb-4">{{ $tool['description'] }}</p>
    <div class="card shadow-sm"><div class="card-body"><p class="mb-0">Generate strong random passwords — length, uppercase, numbers, symbols toggles + copy button.</p></div></div>
</div>
@endsection
