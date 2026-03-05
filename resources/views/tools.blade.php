@extends('layouts.app')

@section('meta_description', $tool->description)
@section('content')
<div class="container py-5">
    <h1 class="mb-4">Utility Tools</h1>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card tool-card bg-dark text-light p-4">
                <h5>EMI Calculator</h5>
                <p class="text-muted">Calculate EMI easily</p>
            </div>
        </div>
    </div>
</div>
@endsection