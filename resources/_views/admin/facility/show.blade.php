@extends('admin.layout')

@section('content')
    <h1>SportEMU facilities</h1>
    <h2>{{$facility->name}}</h2>
    <a href="{{action('Admin\FacilityController@index')}}">Back to index</a>
@endsection