<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    {!! Html::style(elixir('css/app.css')) !!}
    {!! Html::style('css/style.css') !!}
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!}
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">{{ trans('auth.toggle-nav') }}</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">{{ trans('common/buttons.login') }}</a></li>
                            <li><a href="{{ url('/register') }}">{{ trans('common/buttons.register') }}</a></li>
                        @else
                            <li>
                                {{ link_to_action('Web\SuggestQuestionsController@index', 
                                    trans('front-end/users.suggest-question.contribute-question') , null, null) }}
                            </li>
                            <li>
                                {{ link_to_action('Web\ExamsController@index', trans('common/buttons.exam')) }}
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @can('access-admin')
                                        <li>
                                            {{ link_to_action('Admin\HomeController@index', trans('common/buttons.admin-cp') , null, null) }}
                                        </li>
                                    @endcan
                                    <li>
                                        {{ link_to_action('Web\UsersController@edit', trans('common/buttons.user-profile'), Auth::user()->id, null) }}
                                    </li>
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ trans('common/buttons.logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    {!! HTML::script(elixir('js/app.js')); !!}
    <script src='http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js'></script>
    <script src="/js/vendor.js"></script>
    <script>
        var confirmation = "{{ trans('common/dialogs.confirmation') }}";
    </script>
</body>
</html>
