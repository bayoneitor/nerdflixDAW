

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{config('app.name', 'NerdFlix')}} {{$title ?? ''}}</title>
    <meta name="description" content="La mejor pagina para ver videos"/>
    <meta name="keywords" content="videos, unica, creative, html"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>

    <!-- Google Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <link
        href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    />

    <!-- Css Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('extraCSS')
</head>

<body>
<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>


@include('includes.navbar')


@yield('content')

<!-- Footer Section Begin -->
<footer class="footer">
    <div class="page-up">
        <a href="#" id="scrollToTopButton"><span class="arrow_carrot-up"></span></a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="footer__logo">
                    <a href="{{route('index')}}"><img src="{{asset('img/logo.png')}}" alt=""/></a>
                </div>
            </div>
            @if (Auth::check())
            <div class="col-lg-6">
                <div class="footer__nav">
                    <ul>
                        <li class="active"><a href="{{route('index')}}">Inicio</a></li>
                        <li><a href="./categories.html">Categorias</a></li>
                        <li><a href="./blog.html">Añadir Video </a></li>
                        <li><a href="./admin">Admin </a></li>
                    </ul>
                </div>
            </div>
            @endif
            <div class="col-lg-3">
                <p>
                    Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    Todos los derechos reservados | David Bayona Artero
                </p>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<!-- Search model Begin -->
<div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch"><i class="icon_close"></i></div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Buscar aquí....."/>
            <br>
            <br>
            <br>
        <input type="button" id="search-button" class="btn btn-light" value="Buscar">
        </form>
    </div>
</div>
<!-- Search model end -->

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
<script>
    var searchText = document.getElementById("search-input");
    var searchButton = document.getElementById("search-button");
    searchButton.addEventListener("click", function () {
        let value = searchText.value.trim();
        if (value != '') {
            let url = "{{route('video.search', ':value')}}";
            url = url.replace(':value',value);
            window.location.href = url;
        }
    });
</script>
@yield('extraJS')
</body>
</html>
