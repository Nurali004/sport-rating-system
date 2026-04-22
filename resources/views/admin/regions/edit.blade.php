@extends('layouts.backend')
@section('title', 'Edit Region')
@section('admin')
    <div class="container mt-3">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 style="text-align: center">Edit Region</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.regions.update', $region->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Region Name UZ</label>
                                    <input type="text" name="name_uz" class="form-control" value="{{ $region->name_uz }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Region Name EN</label>
                                    <input type="text" name="name_en" class="form-control" value="{{ $region->name_en }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Region Name RU</label>
                                    <input type="text" name="name_ru" class="form-control" value="{{ $region->name_ru }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Region Code</label>
                                    <input type="text" name="code" class="form-control" value="{{ $region->code }}">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
