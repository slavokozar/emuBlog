@extends('layout.main')


@section('content')

    <section>
        <div class="jumbotron jumbotron-fluid">
            <div class="container transparent-box">
                <h1>Book sports instantly with Sportemu</h1>
                <p class="lead">Find new co-players. Split costs instantly. Get to know real time availability of sports
                    around you.
                    Or train with professionals.</p>
            </div>
        </div>
    </section>

    <section class="homepage-section-a">
        <div class="container">

            <h2>What would you like to do today?</h2>

            <div class="row homepage-searchbox">
                <form action="{{action('SearchController@index')}}" method="post">
                    {!! csrf_field() !!}
                    <div class="form-group col-sm-4 col-md-2">
                        <label for="book">Book sports</label>
                        <select class="form-control">
                            <option value="">Book</option>
                            <option value="" hidden>Other options</option>
                            <option value=""></option>
                        </select>
                    </div>

                    <div class="form-group col-sm-4 col-md-2">
                        <label for="which_sports">Which sport?</label>
                        <select class="form-control" name="sport_id">
                            @foreach($sports as $sport)
                                <option value="{{$sport->id}}">{{$sport->name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group col-sm-4 col-md-2">
                        <label for="where">Where?</label>
                        <input id="homepage-autocomplete-2" class="form-control" name="place">
                    </div>

                    <div class="input-append date form_datetime form-group col-sm-4 col-md-2">
                        <label for="when_1">What day? </label>
                        <input type="date" class="form-control" value="{{$date}}" name="date">
                    </div>

                    <div class="form-group col-sm-4 col-md-2 homepage-searchtime">
                        <label for="when_2">What time?</label>
                        <input type="time" class="form-control" value="{{$time}}" step="1800" name="time">
                    </div>

                    <div class="col-sm-4 col-md-2">
                        <button type="submit" class="btn btn-primary btn-lg">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="homepage-section-b">
        <div class="container">
            <div class="row">
                <div class="col-md-4 text-center">
                    <i class="fa fa-calendar homepage-section2-icon" aria-hidden="true"></i>
                    <h2>Book sports nearby</h2>

                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor
                        mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada
                        magna mollis euismod. Donec sed odio dui. </p>


                    <p class="text-right"><a href="#">View details &raquo;</a></p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fa fa-user-plus homepage-section2-icon" aria-hidden="true"></i>

                    <h2>Find new players</h2>

                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor
                        mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada
                        magna mollis euismod. Donec sed odio dui. </p>

                    <p class="text-right"><a href="#">View details &raquo;</a></p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fa fa-newspaper-o homepage-section2-icon" aria-hidden="true"></i>

                    <h2>Get new clients</h2>

                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor
                        mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada
                        magna mollis euismod. Donec sed odio dui. </p>

                    <p class="text-right"><a href="#">View details &raquo;</a></p>
                </div>
            </div>
        </div>
    </section>

    <section class="homepage-section-a">
        <div class="container">
            <div class="row">

                <div class="col-md-5">
                    <h2>This Month's Top Pick</h2>
                </div>

                <div class="col-md-5">
                    <form class="homepage-event-search navbar-form input-sm" role="search">
                        <div class="input-group add-on">
                            <input id="homepage-autocomplete-3" class="form-control">

                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div class="row homepage-event-contents">
                <div class="homepage-event-contens-head">
                    <h4>What sports events are happening around you? / Sport News</h4>
                </div>
                <div class="homepage-col5 col-sm-6 homepage-sportnews-div">
                    <img class="img-responsive homepage-sportnews-image center-block"
                         src="{{ asset('img/tennis.JPG') }}"
                         alt="Tennis player">
                    <a class="" href="#"><h3>Heading</h3></a>

                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo,
                        tortor mauris condimentum nibh, </p>
                </div>
                <div class="homepage-col5 col-sm-6 homepage-sportnews-div">
                    <img class="img-responsive homepage-sportnews-image center-block"
                         src="{{ asset('img/football.JPG') }}"
                         alt="Football match">
                    <a class="" href="#"><h3>Heading</h3></a>

                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo,
                        tortor mauris condimentum nibh, </p>
                </div>
                <div class="homepage-col5 col-sm-6 homepage-sportnews-div">
                    <img class="img-responsive homepage-sportnews-image center-block" src="{{ asset('img/ski.JPG') }}"
                         alt="Ski">
                    <a class="" href="#"><h3>Heading</h3></a>

                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo,
                        tortor mauris condimentum nibh, </p>
                </div>
                <div class="homepage-col5 col-sm-6 homepage-sportnews-div">
                    <img class="img-responsive homepage-sportnews-image center-block"
                         src="{{ asset('img/cycling.JPG') }}"
                         alt="Cycling">
                    <a class="" href="#"><h3>Heading</h3></a>

                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo,
                        tortor mauris condimentum nibh, </p>
                </div>
                <div class="homepage-col5 col-sm-6 homepage-sportnews-div">
                    <img class="img-responsive homepage-sportnews-image center-block"
                         src="{{ asset('img/runner.JPG') }}"
                         alt="Runner">
                    <a class="" href="#"><h3>Heading</h3></a>

                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor
                        mauris condimentum nibh, </p>
                </div>


            </div>
    </section>

    <section class="homepage-section-b">
        <div class="container">

            <h2>Most popular sports</h2>

            <div class="row homepage-popular-sports">
                <div class="col-md-3 col-sm-6 homepage-listed-sports">
                    <div class="text-center">
                        <a href="#">
                            <img class="" src="{{ asset('img/sport_icon/football.png') }}"
                                 alt="football_icon">
                        </a>
                    </div>
                    <div class="text-center">
                        <h4>Football</h4>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 homepage-listed-sports">
                    <div class="text-center">
                        <a href="#">
                            <img class="" src="{{ asset('img/sport_icon/tennis.png') }}"
                                 alt="tennis_icon">
                        </a>
                    </div>
                    <div class="text-center">
                        <h4>Tennis</h4>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 homepage-listed-sports">
                    <div class="text-center">
                        <a href="#">
                            <img class="" src="{{ asset('img/sport_icon/badminton.png') }}"
                                 alt="badminton_icon">
                        </a>
                    </div>
                    <div class="text-center">
                        <h4>Badminton</h4>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 homepage-listed-sports">
                    <div class="text-center">
                        <a href="#">
                            <img class="" src="{{ asset('img/sport_icon/hockey.png') }}"
                                 alt="hockey_icon">
                        </a>
                    </div>
                    <div class="text-center">
                        <h4>Hockey</h4>
                    </div>
                </div>
            </div>
            <div class="text-right homepage-listed-sports">
                <button type="button" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-plus"
                                                                           aria-hidden="true"></span>Add your sport
                </button>
            </div>

        </div>
    </section>



    <section class="homepage-section-a">
        <div class="container">
            <h2>Sportemu in your country</h2>

            <div class="row">
                <div class="col-md-8">
                    <img class="img-responsive" src="{{asset('img/worldmap.png') }}" alt="World map">
                </div>
                <div class="col-md-4">
                    <ul class="list-unstyled">
                        <a href="#" class="btn btn-sq-lg btn-success"></a>
                        <li class="homepage-functionality">Full
                            funcionality
                        </li>
                        <a href="#" class="btn btn-sq-lg btn-warning"></a>
                        <li class="homepage-functionality">Limited
                            funcionality
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </section>

    <section class="homepage-section-b">

        <div class="container ">
            <h2>What do our users say</h2>

            <div class="row homepage-users-recommendations">

                <div class="col-md-6 homepage-user-feedback homepage-user-feedback-1">
                    <div class="col-md-3 col-xs-4">
                        <img src="{{ asset('img/homepage-feedback-face/home-feedback-face-1.jpg') }}"
                             alt="Our client's photo-sport center owner"
                             class="img-circle img-responsive">
                    </div>
                    <div class="col-md-9 col-xs-8">
                        <h3>Name XY, Athlete</h3>

                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut aliquip ex ea commodo consequat.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 homepage-user-feedback homepage-user-feedback-1">
                    <div class="col-md-3 col-xs-4">
                        <img src="{{ asset('img/homepage-feedback-face/home-feedback-face-2.jpg') }}"
                             alt="Our client's photo-sport center owner"
                             class="img-circle img-responsive">
                    </div>
                    <div class="col-md-9 col-xs-8">
                        <h3>Name XY, Sport Center Owner</h3>

                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut aliquip ex ea commodo consequat.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-xs-12 homepage-user-feedback homepage-user-feedback-2">
                    <div class="col-md-9 col-md-push-0 col-xs-8 col-xs-push-4">
                        <h3>Name XY, Instructor</h3>

                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                            ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </p>
                    </div>
                    <div class="col-md-3 col-md-pull-0 col-xs-4 col-xs-pull-8">
                        <img src="{{ asset('img/homepage-feedback-face/home-feedback-face-3.jpg') }}"
                             alt="Our client's photo-team organiser"
                             class="img-circle img-responsive">
                    </div>
                </div>

                <div class="col-md-6 col-xs-12 homepage-user-feedback homepage-user-feedback-2">
                    <div class="col-md-9 col-md-push-0 col-xs-8 col-xs-push-4">
                        <h3>Name XY, Organiser</h3>

                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                            ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </p>
                    </div>
                    <div class="col-md-3 col-md-pull-0 col-xs-4 col-xs-pull-8">
                        <img src="{{ asset('img/homepage-feedback-face/home-feedback-face-4.jpg') }}"
                             alt="Our client's photo-team organiser"
                             class="img-circle img-responsive">
                    </div>
                </div>


            </div>
        </div>


    </section>



@endsection

@section('scripts')

@endsection
