@extends('layouts.app')

@section('content')
    <!-- Normal Breadcrumb Begin -->
    <section
        class="normal-breadcrumb set-bg"
        data-setbg="{{asset('img/normal-breadcrumb.jpg')}}"
    >
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Recuperar Contraseña</h2>
                        <p>Bienvenido a la pagina oficial de NerdFlix.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Login Section Begin -->
    <section class="login spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login__form">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h3>Recuperar Contraseña</h3>

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <div class="input__item @error('email') is-invalid @enderror">
                                <input type="email"  name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Correo electrónico"/>
                                <span class="icon_mail"></span>
                            </div>
                            <button type="submit" class="site-btn">Enviar Correo</button>
                        </form>

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login__register">
                        <h3>¿Te has acordado de la contraseña?</h3>
                        <a href="{{route('login')}}" class="primary-btn">Iniciar Sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login Section End -->

@endsection
