@extends('layouts.admin')

@section('container-class')
    container
@endsection

@section('body-class')
    col-md-8
@endsection

@section('admin-title')
    <div>
        <span><a class="btn btn-link p-0" href="{{ route('sets') }}">Dashboard</a>/Set/</span><strong>{{ $set['name'] }}</strong>
    </div>
@endsection

@section('admin-body')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <hr>
                <span>---Data get link---</span>
                <p class="mb-1">
                    <strong class="dataLinkText">{{ route('data.get', [$set['id'], $token]) }}</strong>
                </p>
                <input style="display: none" class="copyLinkButton" type="submit" value="Copy Link">
            </div>
            <div class="col-md-12">
                <hr>
                <span>---Data set link---</span>
                <p class="mb-1">
                    <strong class="dataLinkText">{{ route('data.set', [$set['id'], $token]) }}</strong>
                </p>
                <input style="display: none" class="copyLinkButton" type="submit" value="Copy Link">
            </div>
        </div>
    </div>
@endsection
