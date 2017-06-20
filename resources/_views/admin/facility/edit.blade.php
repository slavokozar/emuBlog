@extends('admin.layout')

@section('content')
    <h1>SportEMU facilities</h1>

    <h2>{{$facility->name}}</h2>

    <form class="form-inline" action="{{action('Admin\FacilityController@update', $facility->id)}}" method="post">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT" />
        <input type="text" class="form-control" name="name" value="{{$facility->name}}">
        <a href="{{action('Admin\FacilityController@index')}}" class="btn btn-danger">Back</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection