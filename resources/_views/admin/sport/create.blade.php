@extends('admin.layout')

@section('content')
    <h1>SportEMU sports</h1>

    <h2>Create new sport</h2>

    <form class="form-inline" action="{{action('Admin\SportController@store')}}" method="post">
        {!! csrf_field() !!}
        <input type="text" class="form-control" name="name" placeholder="Name">
        <a href="{{action('Admin\SportController@index')}}" class="btn btn-danger">Back</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection