@extends('admin.layout')

@section('content')
    <h1>SportEMU sports</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="col-md-1">#</th>
            <th class="col-md-8">Sport</th>
            <th class="col-md-3">
                <a href="{{action('Admin\SportController@create')}}" class="btn btn-primary">Create</a>
            </th>
        </tr>
        </thead>
        <tbody>
            @foreach($sports as $sport)
                <tr>
                    <th scope="row">{{$sport->id}}</th>
                    <td>{{$sport->name}}</td>
                    <td>
                        <a href="{{action('Admin\SportController@show', $sport->id)}}" class="btn btn-primary">Show</a>
                        <a href="{{action('Admin\SportController@edit', $sport->id)}}" class="btn btn-warning">Edit</a>

                        <form style="display:inline" class="remove-form" action="{{action('Admin\SportController@destroy', $sport->id)}}" method="post">
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