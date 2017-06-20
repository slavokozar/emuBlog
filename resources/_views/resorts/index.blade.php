@extends('layout')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <h1>SportEMU Resorts</h1>
            </div>
        </div>

        <div id="masonry_grid">
            @foreach($resorts as $resort)
                <div class="masonry_item">
                    <div class="thumbnail">
                        @if($resort->images->first())
                            <img src="{{ asset($resort->images->first()->path) }}" alt="Resort image" class="img-responsive center-block">
                        @else
                            <img src="http://placehold.it/500x300" alt="Resort image" class="img-responsive center-block">
                        @endif
                        <div class="caption">
                            <h3>
                                <a href="{{ action('Resort\ResortController@show',[$resort->id]) }}" class="articles-link">
                                    {{ $resort->name }}
                                </a>
                            </h3>
                            @if($resort->sports->count() > 0)
                                <h5>Available Sports:</h5>
                                <ul>
                                    @foreach($resort->sports as $sport)
                                        <li>{{ $sport->name }}</li>
                                    @endforeach
                                </ul>
                            @endif

                            @if(Auth::check() && \Facades\App\Services\ResortService::isOwner($resort, Auth::user()))
                                <a href="{{action('Resort\ResortController@edit', $resort->id)}}" class="btn btn-primary">Edit</a>
                                <a href="{{action('Resort\ReservationController@index', $resort->id)}}" class="btn btn-warning">Reservations</a>
                                <a href="{{action('Resort\FieldController@index', $resort->id)}}" class="btn btn-info">Fields</a>

                                <form class="remove-form" action="{{action('Resort\ResortController@destroy', $resort->id)}}" method="post">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>

                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/masonry.js')}}"></script>
    <script src="{{asset('js/imagesloaded.js')}}"></script>
    <script>

		var $grid = $('#masonry_grid').masonry({
			// options
			itemSelector: '.masonry_item',
			columnWidth : $('#masonry_grid').width() / 3
		});

		$('.masonry_item').css('width', ($('#masonry_grid').width() / 3 - 20) + 'px');

		$grid.imagesLoaded().progress(function () {
			$grid.masonry('layout');
		});
    </script>
@endsection