<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @yield('csrf')

        <!-- bootstrap -->
    	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Original CSS -->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

        <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->

        <!-- fontawesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css" integrity="sha384-rtJEYb85SiYWgfpCr0jn174XgJTn4rptSOQsMroFBPQSGLdOC5IbubP6lJ35qoM9" crossorigin="anonymous">
        <!-- Google Material Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


        <title>@yield('title')</title>

    </head>

    <body class="pt-5">
        <header>
            <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                <a class="navbar-brand" href="{{ route('index') }}">Laravel BBS</a>

                <div id="Navbar" class="collapse navbar-collapse"></div>
                <div class="text-right">
                    <a class="btn btn-outline-success" href="{{ route('create') }}">投稿を新規作成する</a>
                </div>
            </nav>
        </header>

        <main role="main">
            <div class="jumbotron jumbotron-fluid mb-5">
                <div class="container">
                    <h1 class="display-2">@yield('jumbotron')</h1>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    {{-- ランキング --}}
                    @yield('ranking')

                    @yield('content')
                </div>

            </div>
        </main>

        <hr class="mt-5">

        <footer class="container p-5">
            <p class="text-center">test</p>
        </footer>

        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        {{-- index.blade.php用のJS --}}
        @yield('indexJS')

        {{-- single.blade.php用のJS --}}
        @yield('singleJS')

        {{-- create.blade.php用のJS --}}
        @yield('createJS')

        {{-- category.blade.php用のJS --}}
        @yield('categoryJS')

    </body>
</html>
