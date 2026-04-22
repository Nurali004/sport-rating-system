@extends('layouts.backend')
@section('title', 'Edit Rating')
@section('admin')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 style="text-align: center">Edit Rating</h3>
                        <a href="{{ route('admin.ratings.index') }}" class="btn btn-primary">Back</a>
                        <form action="{{route('admin.ratings.destroy', $rating->id)}}" method="post" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.ratings.update', $rating->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Athletes</label>
                                    <select name="athlete_id" id="" class="form-control">
                                        <option value="" class="disabled">Select Athlete</option>
                                        @foreach ($athletes as $athlete)
                                            <option @if($rating->athlete_id == $athlete->id ) selected @endif value="{{ $athlete->id }}">{{ $athlete->first_name. ' '. $athlete->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Seasons</label>
                                    <select name="season_id" id="" class="form-control">
                                        <option value="" class="disabled">Select Season</option>
                                        @foreach ($seasons as $season)
                                            <option @if($rating->season_id == $season->id) selected @endif value="{{ $season->id }}">{{ $season->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Sport</label>
                                    <select name="sport_id" id="" class="form-control">
                                        <option value="" class="disabled">Select Sport</option>
                                        @foreach($sports as $sport)
                                            <option @if($rating->sport_id == $sport->id) selected @endif value="{{ $sport->id }}">{{ $sport->name_uz }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Total Points</label>
                                    <input type="number" name="total_points" id="" class="form-control" value="{{ $rating->total_points }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Rank Position</label>
                                    <input type="number" name="rank_position" id="" class="form-control" value="{{ $rating->rank_position }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Gold Medals Count</label>
                                    <input type="number" name="gold_count" id="" class="form-control" value="{{ $rating->gold_count }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Silver Medals Count</label>
                                    <input type="number" name="silver_count" id="" class="form-control" value="{{ $rating->silver_count }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Bronze Medals Count</label>
                                    <input type="number" name="bronze_count" id="" class="form-control" value="{{ $rating->bronze_count }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Competitions Count</label>
                                    <input type="number" name="competitions_count" id="" class="form-control" value="{{ $rating->competitions_count }}">
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-between" style="margin-top: 30px">
                                    <button type="submit" class="btn btn-outline-success">Update</button>
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
