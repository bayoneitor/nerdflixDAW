<!-- Header Section Begin -->
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="header__logo">
                    <a href="{{route('index')}}">
                        <img src="{{asset('img/logo.png')}}" alt=""/>
                    </a>
                </div>
            </div>
            @if (Auth::check())
                <div class="col-lg-8">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li class="active"><a href="{{route('index')}}">Inicio</a></li>
                                <!--<li>
                                    <a href="./categories.html"
                                    >Categorias <span class="arrow_carrot-down"></span
                                        ></a>
                                    <ul class="dropdown">
                                        <li><a href="./categories.html">Categorias</a></li>
                                        <li><a href="./anime-details.html">Anime Details</a></li>
                                        <li>
                                            <a href="./anime-watching.html">Anime Watching</a>
                                        </li>
                                        <li><a href="./blog-details.html">Blog Details</a></li>
                                    </ul>
                                </li>-->
                                @if(Auth::user()->hasAnyRole(['editor','admin']))
                                <li><a href="{{route('video.create')}}">Añadir Video</a></li>
                                @endif
                                @if(Auth::user()->hasRole('admin'))
                                <li><a href="{{route('admin.index')}}">Admin</a></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header__right">
                        <a href="#" class="search-switch"><span class="icon_search"></span></a>
                        <a href="{{route('settings.profile')}}">
                            {{Auth::user()->name}} <span class="icon_profile"></span></a>
                    </div>
                </div>
            @endif
        </div>
        <div id="mobile-menu-wrap"></div>
    </div>
</header>
<!-- Header End -->
