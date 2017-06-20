@extends('admin.layout')

@section('content')
    <h1>SportEMU sports</h1>

    <h2>{{$sport->name}}</h2>

    <form class="form-inline" action="{{action('Admin\SportController@update', $sport->id)}}" method="post">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT" />
        <input type="text" class="form-control" name="name" value="{{$sport->name}}">
        <a href="{{action('Admin\SportController@index')}}" class="btn btn-danger">Back</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection