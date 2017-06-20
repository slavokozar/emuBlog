@extends('layout')

@section('content')
    <div class="container">
        <section class="resort-show-header">
            <h1>
                <a href="{{action('Resort\ResortController@index')}}">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </a>{{ $resort->name }}
            </h1>
            <div class="row">
                <div class="col-md-6">
                    @if($resort->images->first())
                        <img src="{{ asset($resort->images->first()->path) }}" alt="..." width="500" height="300">
                    @else
                        <img src="http://placehold.it/500x300" alt="Image"
                             style="max-width:100%;" class="img-responsive center-block">
                    @endif
                </div>

                <div class="col-md-6 header-sport">
                    <p>{{ $resort->description }}</p>
                </div>
            </div>
        </section>

        <section class="resort-show-pics">
            <div class="row">
                <div class="col-md-12">
                    <div id="Carousel" class="carousel slide resort-show-carousel">

                        <ol class="carousel-indicators resort-show-carousel-indicators">
                            <li data-target="#Carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#Carousel" data-slide-to="1"></li>
                            <li data-target="#Carousel" data-slide-to="2"></li>
                        </ol>

                        <div class="carousel-inner">

                            <div class="item active">
                                <div class="row">
                                    @if($resort->images->first())
                                        @foreach($resort->images as $image)

                                            <div class="col-md-3"><a href="#" class="thumbnail"><img
                                                            src="{{ asset($image->path) }}" alt="Image"
                                                    ></a></div>

                                        @endforeach
                                    @else

                                        <div class="col-md-3"><a href="#" class="thumbnail"><img
                                                        src="http://placehold.it/250x250" alt="Image"
                                                        style="max-width:100%;"></a></div>
                                        <div class="col-md-3"><a href="#" class="thumbnail"><img
                                                        src="http://placehold.it/250x250" alt="Image"
                                                        style="max-width:100%;"></a></div>
                                        <div class="col-md-3"><a href="#" class="thumbnail"><img
                                                        src="http://placehold.it/250x250" alt="Image"
                                                        style="max-width:100%;"></a></div>
                                        <div class="col-md-3"><a href="#" class="thumbnail"><img
                                                        src="http://placehold.it/250x250" alt="Image"
                                                        style="max-width:100%;"></a></div>

                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="row">
                                    @if($resort->images->first())
                                        @foreach($resort->images as $image)

                                            <div class="col-md-3"><a href="#" class="thumbnail"><img
                                                            src="{{ asset($image->path) }}" alt="Image"
                                                    ></a></div>
                                        @endforeach
                                    @else

                                        <div class="col-md-3"><a href="#" class="thumbnail"><img
                                                        src="http://placehold.it/250x250" alt="Image"
                                                        style="max-width:100%;"></a></div>
                                        <div class="col-md-3"><a href="#" class="thumbnail"><img
                                                        src="http://placehold.it/250x250" alt="Image"
                                                        style="max-width:100%;"></a></div>
                                        <div class="col-md-3"><a href="#" class="thumbnail"><img
                                                        src="http://placehold.it/250x250" alt="Image"
                                                        style="max-width:100%;"></a></div>
                                        <div class="col-md-3"><a href="#" class="thumbnail"><img
                                                        src="http://placehold.it/250x250" alt="Image"
                                                        style="max-width:100%;"></a></div>

                                    @endif
                                </div>
                            </div>

                            <div class="item">
                                <div class="row">
                                    @if($resort->images->first())
                                        @foreach($resort->images as $image)

                                            <div class="col-md-3"><a href="#" class="thumbnail"><img
                                                            src="{{ asset($image->path) }}" alt="Image"
                                                    ></a></div>
                                        @endforeach
                                    @else

                                        <div class="col-md-3"><a href="#" class="thumbnail"><img
                                                        src="http://placehold.it/250x250" alt="Image"
                                                        style="max-width:100%;"></a></div>
                                        <div class="col-md-3"><a href="#" class="thumbnail"><img
                                                        src="http://placehold.it/250x250" alt="Image"
                                                        style="max-width:100%;"></a></div>
                                        <div class="col-md-3"><a href="#" class="thumbnail"><img
                                                        src="http://placehold.it/250x250" alt="Image"
                                                        style="max-width:100%;"></a></div>
                                        <div class="col-md-3"><a href="#" class="thumbnail"><img
                                                        src="http://placehold.it/250x250" alt="Image"
                                                        style="max-width:100%;"></a></div>

                                    @endif
                                </div>
                            </div>

                        </div>
                        <a data-slide="prev" href="#Carousel" class="left carousel-control resort-show-carousel-control">‹</a>
                        <a data-slide="next" href="#Carousel" class="right carousel-control resort-show-carousel-control">›</a>
                    </div>

                </div>
            </div>
        </section>
        <section class="resort-show-detail">
            <div class="row">
                <div class="col-md-4">
                    <h2><span class="label label-primary">General Information</span></h2>
                    <table class="table table-hover">
                        <tbody>
                        {{--<tr class="">--}}
                        {{--<th scope=row>--}}
                        {{--Opening hours--}}
                        {{--</th>--}}
                        {{--<td>--}}
                        {{--{{ $open }}--}}
                        {{-----}}
                        {{--{{ $close }}--}}
                        {{--</td>--}}
                        {{--</tr>--}}

                        <tr class="">
                            <th scope=row>
                                Games Played
                            </th>
                            <td>
                                250
                            </td>
                        </tr>
                        <tr class="">
                            <th scope=row>
                                Schedules Games
                            </th>
                            <td>
                                8
                            </td>
                        </tr>
                        <tr class="">
                            <th scope=row>
                                Users
                            </th>
                            <td>
                                850
                            </td>
                        </tr>
                        <tr class="">
                            <th scope=row>
                                Rating
                            </th>
                            <td>
                                8.5
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>

                <div class="sports col-md-4">
                    <h3><span class="label label-primary">Available Sports</span></h3>
                    @foreach($resort->sports as $sport)
                        <div class="text-center">
                            <h3>{{ $sport->name }}</h3>
                        </div>
                    @endforeach
                </div>

                <div class="services col-md-4">
                    <h3><span class="label label-primary">Available Services</span></h3>
                    @foreach($resort->facilities as $facility)
                        <div class="service">
                            <h5>{{ $facility->name }}</h5>
                            <img src="http://www.gemologyproject.com/wiki/images/5/5f/Placeholder.jpg"
                                 style="width: 80px; height: 80px; border-radius: 50%;" class="image_sports">
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <h3><span class="label label-primary">Find us</span></h3>
                    <p>{{ $resort->address_street }}, {{ $resort->address_zip }}. {{ $resort->address_city }}</p>
                </div>
                <div class="col-md-12" id="resort_map" class="col-md-6" style="height: 400px;">
                    <input type="hidden" id="map-resort" value="{{$resort}}">
                    <input type="hidden" id="map-lat" value="{{$resort->address_latitude}}">
                    <input type="hidden" id="map-lon" value="{{$resort->address_longitude}}">
                </div>

            </div>


        </section>

    </div>

@endsection

@section('scripts')
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBj-Ef6CWzOzl7MloXshvaOpCctWffBtG8"></script>
    <script src="{{asset('js/embed-map.js')}}"></script>
@endsection