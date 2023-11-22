<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <link href="{{ url('css/question.css') }}" rel="stylesheet">
        <link href="{{ url('css/new.question.css') }}" rel="stylesheet">


        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer>
        </script>
    </head>
    <body>
        <main>
            <header>
                <h1><a href="{{ url('/home') }}">CreativeHub</a></h1>
                <form method="POST" action="{{ route('search') }}">
                    {{ csrf_field() }}
                    <input type="text" name="search" placeholder="Search..">
                </form>
                <section id="user_buttons">
                    @if (Auth::check())
                    <a class="button" href="{{ url('/logout') }}"> Logout </a>
                    <a class="button" href="{{ url('/profile') }}"> {{ Auth::user()->username }} </a>
                    @endif
                    @if (!Auth::check())
                    <a class="button" href="{{ url('/login') }}"> Login </a>
                    @endif
                </section>
            </header>
            <section id="content">
                @yield('content')
            </section>
        </main>
    </body>
</html>
