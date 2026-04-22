@extends('layouts.backend')
@section('title', 'Edit User')
@section('admin')
    <div class="row mt-4">
        <div class="col">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit User</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('put')
                            <div class="my-2">
                                <label for="">User Name</label>
                                <input type="text" name="name" value="{{$user->name}}" class="form-control" placeholder="Enter User Name">
                            </div>
                            <div class="mb-2">
                                <label for="">Email</label>
                                <input type="email" name="email" value="{{$user->email}}" class="form-control" placeholder="Enter Email">
                            </div>
                            <div class="mb-2">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password">
                            </div>
                            <div class="mb-2">
                                <label for="">Role</label>
                                <select class="form-control" name="role" id="">
                                    <option @if($user->role == 'admin') selected @endif value="admin">Admin</option>
                                    <option @if($user->role == 'moderator') selected @endif value="moderator">Moderator</option>
                                    <option @if($user->role == 'viewer') selected @endif value="viewer">viewer</option>

                                </select>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
