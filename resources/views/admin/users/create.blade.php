@extends('layouts.backend')
@section('title', 'Create User')

@section('admin')

    <div class="container mt-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold">Create New User</h2>

            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                ← Back
            </a>
        </div>

        <!-- Card -->
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body p-4">

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">

                        <!-- Name -->
                        <div class="col-md-6">
                            <label class="form-label">User Name</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="form-control form-control-lg"
                                   placeholder="Enter user name">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="form-control form-control-lg"
                                   placeholder="Enter email">
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control form-control-lg"
                                   placeholder="Enter password">
                        </div>

                        <!-- Confirm Password (bonus UX) -->
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control form-control-lg"
                                   placeholder="Confirm password">
                        </div>

                    </div>

                    <!-- Submit -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-4 shadow-sm">
                            Create User
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection
