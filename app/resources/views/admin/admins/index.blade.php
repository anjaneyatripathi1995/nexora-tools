@extends('layouts.admin')

@section('title', 'Manage Admins')

@section('content')
<div class="panel-welcome mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold text-body mb-1">Manage Admins</h1>
            <p class="text-muted mb-0 small">Add sub-admins and assign section access.</p>
        </div>
        <a href="{{ route('admin.admins.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i>Add Sub-Admin</a>
    </div>
</div>

<div class="panel-card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Access</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        @if($admin->is_master)
                            <span class="badge bg-dark">Master Admin</span>
                        @else
                            <span class="badge bg-secondary">Sub-Admin</span>
                        @endif
                    </td>
                    <td>
                        @if($admin->access_rules === null || $admin->access_rules === [])
                            <span class="text-muted">Full access</span>
                        @else
                            {{ implode(', ', (array) $admin->access_rules) }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<p class="text-muted small mt-2">Only the master admin can add sub-admins. Sub-admins can access the admin portal based on their assigned sections (tools, projects, apps, templates).</p>
@endsection
