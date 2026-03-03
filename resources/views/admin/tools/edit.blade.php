@extends('layouts.admin')

@section('title', 'Edit Tool')

@section('content')
<div class="panel-welcome mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold text-body mb-1">Edit Tool</h1>
            <p class="text-muted mb-0 small">Update tool details.</p>
        </div>
        <a href="{{ route('admin.tools.index') }}" class="btn btn-outline-secondary">Back to Tools</a>
    </div>
</div>

<div class="panel-card">
    <div class="card-body">
        <form action="{{ route('admin.tools.update', $tool) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $tool->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $tool->slug) }}" required>
                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ old('category', $tool->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="2">{{ old('description', $tool->description) }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="icon" class="form-label">Icon (Font Awesome class)</label>
                <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon', $tool->icon) }}">
                @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $tool->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active (shown on tools list)</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Tool</button>
        </form>
    </div>
</div>
@endsection
