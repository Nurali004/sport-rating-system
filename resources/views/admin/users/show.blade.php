@extends('layouts.backend')
@section('title', 'View User')

@section('admin')

    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold">User Details</h2>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    ← Back
                </a>

                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-primary">
                    ✏️ Edit
                </a>

                <form action="{{ route('admin.users.destroy', $user->id) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this user?')">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-outline-danger">
                        🗑 Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body p-4">

                <!-- Header User -->
                <div class="d-flex align-items-center gap-3 mb-4">

                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center fw-bold"
                         style="width:60px;height:60px;font-size:20px;">
                        {{ strtoupper(substr($user->name,0,1)) }}
                    </div>

                    <div>
                        <h4 class="mb-0">{{ $user->name }}</h4>
                        <small class="text-muted">{{ $user->email }}</small>
                    </div>

                </div>

                <!-- Info Cards -->
                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light">
                            <small class="text-muted">User ID</small>
                            <div class="fw-bold">{{ $user->id }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light">
                            <small class="text-muted">Email</small>
                            <div class="fw-bold">{{ $user->email }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light">
                            <small class="text-muted">Created At</small>
                            <div class="fw-bold">
                                {{ $user->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light">
                            <small class="text-muted">Updated At</small>
                            <div class="fw-bold">
                                {{ $user->updated_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

@endsection
