@extends('layouts.admin')

@section('title', 'Add Sub-Admin')

@section('content')
<div class="panel-welcome mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold text-body mb-1">Add Sub-Admin</h1>
            <p class="text-muted mb-0 small">Create a new admin with optional section access.</p>
        </div>
        <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">Back to Admins</a>
    </div>
</div>

<div class="panel-card">
    <div class="card-body">
        <form action="{{ route('admin.admins.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Access (leave all unchecked for full access)</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="access_tools" value="1" id="access_tools" {{ old('access_tools') ? 'checked' : '' }}>
                    <label class="form-check-label" for="access_tools">Tools</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="access_projects" value="1" id="access_projects" {{ old('access_projects') ? 'checked' : '' }}>
                    <label class="form-check-label" for="access_projects">Projects</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="access_apps" value="1" id="access_apps" {{ old('access_apps') ? 'checked' : '' }}>
                    <label class="form-check-label" for="access_apps">Apps</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="access_templates" value="1" id="access_templates" {{ old('access_templates') ? 'checked' : '' }}>
                    <label class="form-check-label" for="access_templates">Templates</label>
                </div>
                <small class="text-muted">If no box is checked, the sub-admin will have full access to all sections.</small>
            </div>
            <button type="submit" class="btn btn-primary">Create Sub-Admin</button>
        </form>
    </div>
</div>
@endsection
