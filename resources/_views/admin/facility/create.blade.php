@extends('admin.layout')

@section('content')
    <h1>SportEMU facilities</h1>

    <h2>Create new facility</h2>

    <form class="form-inline" action="{{action('Admin\FacilityController@store')}}" method="post">
        {!! csrf_field() !!}
        <input type="text" class="form-control" name="name" placeholder="Name">
        <a href="{{action('Admin\FacilityController@index')}}" class="btn btn-danger">Back</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection