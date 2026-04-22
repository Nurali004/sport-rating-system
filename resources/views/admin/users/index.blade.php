@extends('layouts.backend')
@section('title', 'Users List')

@section('admin')
    <div class="container-fluid mt-5">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold">Users Management</h2>
            <a href="{{ route('admin.users.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-lg"></i> Add User
            </a>
        </div>

        <!-- Card -->
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table align-middle table-hover">

                        <thead class="table-light">
                        <tr class="text-secondary">
                            <th>#</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="fw-semibold">{{ $user->id }}</td>

                                <!-- Name + Avatar -->
                                <td>
                                    <div class="d-flex align-items-center gap-2">

                                        <span class="fw-medium">{{ $user->name }}</span>
                                    </div>
                                </td>

                                <td class="text-muted">{{ $user->email }}</td>

                                <td>
                                <span class="badge bg-light text-dark">
                                    {{ $user->created_at->format('d M Y') }}
                                </span>
                                </td>

                                <td>
                                <span class="badge bg-light text-dark">
                                    {{ $user->updated_at->format('d M Y') }}
                                </span>
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                       class="btn btn-sm btn-outline-info">
                                        👁
                                    </a>

                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        ✏️
                                    </a>

                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            🗑
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
