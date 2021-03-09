@extends('layouts.app')

@section('content')
    <!-- Normal Breadcrumb Begin -->
    <section
        class="normal-breadcrumb set-bg"
        data-setbg="img/normal-breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Crear Una Cuenta</h2>
                        <p>Bienvenido a la pagina oficial de NerdFlix.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Signup Section Begin -->
    <section class="signup spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login__form">
                        <h3>Crear Una Cuenta</h3>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <div class="input__item @error('name') is-invalid @enderror">
                                <input type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nombre usuario"/>
                                <span class="icon_profile"></span>

                            </div>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <div class="input__item @error('email') is-invalid @enderror">
                                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Correo electrónico"/>
                                <span class="icon_mail"></span>
                            </div>

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <div class="input__item @error('password') is-invalid @enderror">
                                <input type="password" name="password" required autocomplete="new-password" placeholder="Contraseña"/>
                                <span class="icon_lock"></span>
                            </div>


                            <div class="input__item">
                                <input type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar Contraseña"/>
                                <span class="icon_lock"></span>
                            </div>


                            <button type="submit" class="site-btn">Registrarse</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login__register">
                        <h3>¿Ya tienes una cuenta?</h3>
                        <a href="{{route('login')}}" class="primary-btn">Iniciar Sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Signup Section End -->

@endsection
