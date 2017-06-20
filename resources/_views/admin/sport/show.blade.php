@extends('admin.layout')

@section('content')
    <h1>SportEMU sports</h1>
    <h2>{{$sport->name}}</h2>
    <a href="{{action('Admin\SportController@index')}}">Back to index</a>
@endsection