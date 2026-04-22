@extends('layouts.backend')
@section('title', 'Create Region')
@section('admin')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 style="text-align: center">Create Region</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.regions.store')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name_uz" class="form-label">Region Name UZ</label>
                                    <input type="text" class="form-control" name="name_uz" id="name" placeholder="Enter Region Name">
                                </div>
                                <div class="col-md-6">
                                    <label for="name_ru" class="form-label">Region Name RU</label>
                                    <input type="text" class="form-control" name="name_ru" id="name" placeholder="Enter Region Name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name_en" class="form-label">Region Name EN</label>
                                    <input type="text" class="form-control" name="name_en" id="name" placeholder="Enter Region Name">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Region Code</label>
                                    <input type="text" class="form-control" name="code" id="code" placeholder="TOS, FAR, SAM">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
