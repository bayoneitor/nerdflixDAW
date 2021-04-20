@extends('layouts.app')

@section('content')
    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="recent__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                <h4>Editar usuario: <span class="text-info">{{$user->email}}</span></h4>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="{{route('admin.user.update',$user->id)}}" class="row video">
                            @csrf
                            @method('PUT')
                            <div class="col-lg-6">
                                <label for="name"><h6>Nombre</h6></label>
                                <input type="text" placeholder="{{$user->name}}" name="name" id="name"/>
                                <label for="email"><h6>E-mail</h6></label>
                                <input type="email" placeholder="{{$user->email}}" name="email" id="email"/>
                                <label for="password"><h6>Contraseña</h6></label>
                                <input type="password" placeholder="Contraseña" name="password" id="password"/>
                            </div>
                            <div class="col-lg-6">
                                <h6>Roles</h6>
                                @foreach ($roles as $role)
                                    <div class="form-check check-role">
                                        <input class="form-check-input roles" type="checkbox" id="{{$role->name}}" value="{{$role->name}}" name="roles[]"
                                        @if ($user->hasRole($role->name))
                                        checked
                                        @endif
                                        @if ($role->name == 'visitor')
                                        disabled
                                        @endif
                                        />
                                        <label class="form-check-label" for="{{$role->name}}">{{$role->name}}</label>
                                    </div>
                                @endforeach
                                <input type="submit" class="btn btn-success" value="Actualizar Usuario" style="margin-top: 30px;">
                            </div>
                        </form>
                        <div class="row">
                            @if($errors->any())
                                {!!  implode('', $errors->all('<span class="invalid-feedback" role="alert"> <strong>:message</strong></span><br>')) !!}
                            @endif
                        </div>
                        <br>
                        <br>
                        <a href="{{url()->previous()}}"type="button" class="btn btn-light boton"><i class="fas fa-arrow-left"></i> Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->
@endsection
