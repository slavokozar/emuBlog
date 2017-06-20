@extends('admin.layout')

@section('content')
    <h1>SportEMU facilities</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="col-md-1">#</th>
            <th class="col-md-8">Facility</th>
            <th class="col-md-3">
                <a href="{{action('Admin\FacilityController@create')}}" class="btn btn-primary">Create</a>
            </th>
        </tr>
        </thead>
        <tbody>
            @foreach($facilities as $facility)
                <tr>
                    <th scope="row">{{$facility->id}}</th>
                    <td>{{$facility->name}}</td>
                    <td>
                        <a href="{{action('Admin\FacilityController@show', $facility->id)}}" class="btn btn-primary">Show</a>
                        <a href="{{action('Admin\FacilityController@edit', $facility->id)}}" class="btn btn-warning">Edit</a>

                        <form style="display:inline" class="remove-form" action="{{action('Admin\FacilityController@destroy', $facility->id)}}" method="post">
                            {!! csrf_field() !!}
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection