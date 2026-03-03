@extends('layouts.user')

@section('title', 'Usages')
@section('meta_description', 'Your tool usage history')

@section('content')
<div class="panel-welcome mb-4">
    <h1 class="h3 fw-bold text-body mb-1">Tool usages</h1>
    <p class="text-muted mb-0 small">History of tools you’ve used.</p>
</div>
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-arrow-left me-1"></i>Dashboard</a>
</div>
    <div class="panel-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tool</th>
                        <th>Used at</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usages as $u)
                    <tr>
                        <td>
                            <i class="fa-solid {{ optional($u->tool)->icon ?? 'fa-wrench' }} me-2 text-muted"></i>
                            {{ optional($u->tool)->name ?? \Illuminate\Support\Str::title(str_replace('-', ' ', $u->tool_slug)) }}
                        </td>
                        <td>{{ $u->created_at->format('M j, Y g:i A') }}</td>
                        <td>
                            <a href="{{ route('tools.show', $u->tool_slug) }}" class="btn btn-sm btn-outline-primary">Open</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">No tool usages yet. <a href="{{ route('tools.index') }}">Use a tool</a> while logged in to see history here.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($usages->hasPages())
        <div class="card-footer bg-transparent border-0">{{ $usages->links() }}</div>
        @endif
    </div>
@endsection
