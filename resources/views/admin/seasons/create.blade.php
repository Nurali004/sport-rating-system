@extends('layouts.backend')
@section('title', 'Create Season')
@section('admin')
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3>Create Season</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.seasons.store')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" id="name">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Year Start</label>
                                    <input type="number" name="year_start" class="form-control" id="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Year End</label>
                                    <input type="number" name="year_end" class="form-control" id="">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Start Date</label>
                                    <input type="date" name="start_date" class="form-control" id="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">End Date</label>
                                    <input type="date" name="end_date" class="form-control" id="">
                                </div>

                                <div class="col-md-6">
                                    <label for="">Sport</label>
                                    <select name="sport_id" id="" class="form-control">
                                        <option value="" class="disabled">Select Sport</option>
                                        @foreach ($sports as $sport)
                                            <option value="{{$sport->id}}">{{$sport->name_uz}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Status</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex" style="margin-top: 30px;">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
