@extends('layouts.admin')

@section('title', 'Manage Tools')

@section('content')
<div class="panel-welcome mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold text-body mb-1">Manage Tools</h1>
            <p class="text-muted mb-0 small">Add, edit, or remove tools from the catalog.</p>
        </div>
        <a href="{{ route('admin.tools.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Add Tool</a>
    </div>
</div>

<div class="panel-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Category</th>
                    <th>Active</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tools as $tool)
                <tr>
                    <td><i class="fa-solid {{ $tool->icon ?? 'fa-wrench' }} me-2 text-muted"></i>{{ $tool->name }}</td>
                    <td><code>{{ $tool->slug }}</code></td>
                    <td>{{ $tool->category }}</td>
                    <td>
                        @if($tool->is_active)
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.tools.edit', $tool) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('admin.tools.destroy', $tool) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this tool?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">No tools yet. <a href="{{ route('admin.tools.create') }}">Add one</a>.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tools->hasPages())
    <div class="card-footer">{{ $tools->links() }}</div>
    @endif
</div>
@endsection
