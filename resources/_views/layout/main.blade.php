
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Super cool ">
    <meta name="author" content="Data4You.cz, E-Zone.sk, CodingBootcamp.cz">

    <title>SportEmu</title>

    <link href="{{asset('css/style.css')}}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


    <![endif]-->
</head>

<body>

@include('layout.navbar')

@yield('content')

@include('layout.footer')

<div class="container">
    <footer>

    </footer>
</div>

<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/bootstrap-select.js')}}"></script>
<script src="{{asset('js/jquery.easy-autocomplete.js')}}"></script>
<script src="{{asset('js/navbar.js')}}"></script>
<script src="{{asset('js/select2.js')}}"></script>

<script>
	$.ajaxSetup({headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}});

    $('.selectpicker').selectpicker({
        style: 'btn-info',
        size: 4
    });

    var options1 = {
        data: ["Badminton", "Cycling", "Yoga", "Tennis", "red", "yellow"],
        adjustWidth: false,
        placeholder: "Type"
    };
    $("#homepage-autocomplete-1").easyAutocomplete(options1);

    var options2 = {
        data: ["Prague1", "Prague2", "Náměstí Míru", "Vinohrady", "Holešovice", "Anděl"],
        adjustWidth: false,
        placeholder: "City or Address"
    };
    $("#homepage-autocomplete-2").easyAutocomplete(options2);

    var options3 = {
        data: ["Germany", "Austria", "Hungary", "Poland", "France", "Argentina", "Japan"],
        adjustWidth: false,
        placeholder: "Not in Czech Republic"
    };
    $("#homepage-autocomplete-3").easyAutocomplete(options3);

    $('.remove-form').submit(function(e){
       if(!confirm('Do You really want to delete it?')){
           e.preventDefault();
       }
    });

</script>
@yield('scripts')


</body>
</html>
