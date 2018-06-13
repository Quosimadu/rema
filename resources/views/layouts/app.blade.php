<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@section('title')
            {{ config('app.name', 'Laravel') }}
        @show</title>

    <!-- Styles -->
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">Rental Management</a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                @if (!Auth::guest())
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('bookings') }}">Bookings</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown" data-toggle="dropdown" role="button" aria-expanded="false">Messages<span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('messages') }}">Overview</a></li>
                            <li><a href="{{ route('messages.compose') }}">New</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('message_templates') }}">Templates</a></li>
                            <li><a href="{{ route('message_senders') }}">Senders</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('providers') }}">Providers</a></li>
                    <li><a href="{{ route('listings') }}">Listings</a></li>
                    <li><a href="{{ route('reports') }}">Reports</a></li>
                </ul>
                @endif

                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}" onclick="
								event.preventDefault();
								document.getElementById('logout-form').submit();">
                                        Logout</a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">{{ csrf_field() }} </form>
                                </li>

                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @if (count($errors))
        <div class="alert alert-warning">
            @foreach ($errors->all() as $error)
                {{ $error }}<br/>
            @endforeach
        </div>
    @endif
@yield('content')
</div>
<!-- Scripts -->
    <script src="{{ elixir('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    @yield('javascript')

</body>
</html>
