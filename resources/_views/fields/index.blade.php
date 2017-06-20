@extends('layout')

@section('content')
    <div class="container">

        <h1>SportEMU <a href="{{action('Resort\ResortController@show',$resort->id)}}">{{$resort->name}}</a> Fields</h1>


        @if($fields->count())
            <table class="table table-hover table-striped reservation-index-table">
                <thead>
                <tr>
                    <th class="col-md-4">Name</th>
                    <th class="col-md-4">Sports</th>
                    <th class="col-md-4">
                        <a href="{{ action('Resort\FieldController@create',[$resort->id]) }}" class="btn btn-primary">
                            Create new field
                        </a>
                    </th>
                </tr>
                </thead>

                <tbody>

                @foreach($fields as $field)
                    <tr>
                        <td>
                            <a href="{{ action('Resort\FieldController@show',[$resort->id, $field->id]) }}"
                               class="articles-link">{{ $field->name }}</a>
                        </td>
                        <td>
                            @foreach($field->sports as $sport)
                                @if(!$loop->last)
                                    {{$sport->name}},
                                @else
                                    {{$sport->name}}
                                @endif
                            @endforeach
                        </td>
                        <td>

                            <a href="{{action('Resort\FieldController@edit', [$resort->id, $field->id])}}"
                               class="btn btn-info">Edit</a>
                            <form class="remove-form"
                                  action="{{action('Resort\FieldController@destroy', [$resort->id, $field->id])}}"
                                  method="post">
                                {!! csrf_field() !!}
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>There are no fields for this resort!</p>
            <p><a href="{{ action('Resort\FieldController@create',[$resort->id]) }}" class="btn btn-primary">Create new
                                                                                                             field</a>
            </p>
        @endif
    </div>
@endsection