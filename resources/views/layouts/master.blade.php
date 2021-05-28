<html>

<head>

    <title></title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--Bootstrap-->
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="{{asset('/css/bootstrap-rtl.css')}}">
    <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}">

    <!--Fontawesome-->
    <link rel="stylesheet" href="{{asset('/css/font/all.css')}}">
    <link rel="stylesheet" href="{{asset('/css/boxicons.min.css')}}">

    <!--Custom-->
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar-min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('/css/style.css')}}">

</head>

<body>



<div class="d-flex" id="wrapper">

{{--Navbar--}}

        @include('include.header')


<!-- Page content wrapper-->
<div id="page-content-wrapper">

        {{--List--}}
{{--
        @if(auth()->user()) --}}
            @include('include.sidebarMenu')
        {{-- @endif --}}

        <!-- Page content-->
        <div class="container-fluid">
        {{--Content--}}
        @yield('content')

        </div>

    </div>
</div>



<!--jquery and Bootstrap.js-->
<script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/pusher.min.js')}}"></script>
<script src="{{asset('js/bootbox.min.js')}}"></script>
<script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('e385633e7a2e9feba132', {
        cluster: 'ap1',
        encrypted: false
    });

    // var channel = pusher.subscribe('my-channel');
    // channel.bind('my-event', function(data) {
    //     alert(JSON.stringify(data));
    // });
</script>

<script src="{{asset('js/pusherNotifications.js')}}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>


</body>
</html>
