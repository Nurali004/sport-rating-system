@extends('layouts.backend')
@section('title', 'Edit Season')
@section('admin')
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Season</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.seasons.update', $season->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $season->name }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Start Year</label>
                                    <input type="number" name="year_start" class="form-control" value="{{ $season->year_start }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">End Year</label>
                                    <input type="number" name="year_end" class="form-control" value="{{ $season->year_end }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Start Date</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ $season->start_date }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">End Date</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ $season->end_date }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Status</label>
                                    <select name="is_active" id="" class="form-control">
                                        <option value="" class="disabled">Select Status</option>
                                        <option value="1" {{ $season->is_active == 1 ? 'selected' : '' }}>Active</option>
                                         <option value="0" {{ $season->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Sport</label>
                                    <select name="sport_id" id="" class="form-control">
                                        <option value="" class="disabled">Select Sport</option>
                                        @foreach($sports as $sport)
                                            <option value="{{ $sport->id }}" {{ $season->sport_id == $sport->id ? 'selected' : '' }}>{{ $sport->name_uz }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex" style="margin-top: 30px;">
                                    <button class="btn btn-primary">Update</button>
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
