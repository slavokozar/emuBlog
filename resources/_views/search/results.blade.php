@extends('layout')

@section('content')
    <div class="container">
<h1>Available resort</h1>
        <div class="row row-flex">

            <div class="col-md-6">
                <form action="" method="post" class="form-inline">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <select class="form-control" name="sport_id">
                            @foreach($sports as $sportOption)
                                <option value="{{$sportOption->id}}"{{$sportOption->id == $sport->id ? ' selected':''}}>{{$sportOption->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="resort" placeholder="Resort">
                    </div>
                    <div class="form-group">
                        <input type="date" name="date" class="form-control" value="{{ $date }}">
                    </div>
                    <input type="submit" class="btn btn-default" name="save" value="Search">
                </form>


                {{--<ul class="nav nav-tabs" style="padding-top: 30px;">--}}
                {{--<li role="presentation" class="active"><a href="#">Results</a></li>--}}
                {{--<li role="presentation"><a href="#">Other Resorts</a></li>--}}
                {{--<li role="presentation"><a href="#">Other Sports</a></li>--}}
                {{--</ul>--}}

                <div class="row">
                    <div class="col-md-12">
                        <!--first row of first column-->

                        <!--third row of first column-->
                        @foreach($resorts as $resort)
                            <div class="row results">
                                <div class="col-md-4 col_result">
                                    <a href="{{ action('Resort\ResortController@show',[$resort->id]) }}"
                                       class="articles-link">
                                        {{ $resort->name }}
                                    </a>
                                </div>
                                <div class="col-md-4 col_result">
                                    @foreach($resort->sports as $availableSport)
                                        {{ $availableSport->name }},
                                    @endforeach
                                </div>
                                <div class="col-md-4 text-right col_result">
                                    <form action="{{action('ReservationController@create')}}" method="post">
                                        {!! csrf_field() !!}

                                        <input type="hidden" name="sport_id" value="{{ $sport->id }}">
                                        <input type="hidden" name="resort_id" value="{{ $resort->id }}">
                                        <input type="hidden" name="date" value="{{ $date }}">
                                        <input type="hidden" name="time" value="{{ $time }}">
                                        <button type="submit" class="btn  btn-default" role="button">Book</button>
                                    </form>

                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $resorts->links() }}
                </div>
            </div>


            <div class="col-md-6">
                <div>
                <div id="map">
                </div>
                </div>
            </div>
        </div>
    </div>


    <!--end of container-->


@endsection

@section('scripts')
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPKzbmmIrGu7Xj1eA1MUtJfWU_yzvvWEA"></script>
    <script async defer src="{{asset('js/search-results-map.js')}}"></script>
@endsection