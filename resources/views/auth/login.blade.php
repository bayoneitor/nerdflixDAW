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
                        <h2>Iniciar Sesión</h2>
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
                        <h3>Iniciar Sesión</h3>
                        <form method="POST" action="{{route('login') }}">
                            @csrf

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="input__item @error('email') is-invalid @enderror">
                                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                                       autofocus placeholder="Correo electrónico"/>
                                <span class="icon_mail"></span>
                            </div>

                            @error('password')
                            <span class="invalid-feedback flex" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="input__item @error('password') is-invalid @enderror">
                                <input type="password" placeholder="Contraseña" name="password" required
                                       autocomplete="current-password"/>
                                <span class="icon_lock"></span>
                            </div>
                            <!--Akadido -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember"
                                       id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Recordarme') }}
                                </label>
                            </div>

                            <button type="submit" class="site-btn">Logearse</button>
                        </form>
                        <a href="{{route('password.request') }}" class="forget_pass"
                        >¿Olvidaste tu contraseña?</a
                        >
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login__register">
                        <h3>¿No tienes una cuenta?</h3>
                        <a href="{{route('register')}}" class="primary-btn">Registrarse</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login Section End -->

@endsection
