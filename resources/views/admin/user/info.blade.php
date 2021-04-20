@extends('layouts.app')

@section('content')
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="recent__product">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="section-title">
                                    <h4>Información Usuario: <span class="text-info">{{$user->email}}</span></h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 settings-buttons">
                                <div class="text row">
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <p>Nombre: <strong>{{$user->name}}</strong></p>
                                        <p>E-mail: <strong>{{$user->email}}</strong></p>
                                        <p>Tiene el rol:
                                            @foreach($user->roles()->get() as $role)
                                                <strong>  @if ($loop->last)
                                                        {{$role->name}}
                                                    @else
                                                        {{$role->name}},
                                                    @endif
                                                </strong>
                                            @endforeach
                                        </p>
                                        <p>Fecha Creación: <strong>{{$user->created_at}}</strong></p>
                                        @if($user->created_at != $user->updated_at)
                                            <p>Fecha Modificación: <strong>{{$user->updated_at}}</strong></p>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <p>Videos Creados: <strong>{{$user->videos()->count()}}</strong></p>
                                        <p>Videos Vistos: <strong>{{$user->videosWatched()->count()}}</strong></p>
                                        <p>Videos Comentados/Puntuados: <strong>{{$user->scores()->count()}}</strong></p>
                                        <p>Videos Puntuación Media: <strong>{{round($user->scores()->avg('score'),2) *2}}/10</strong></p>
                                    </div>
                                </div>
                                <a href="{{route('admin.index')}}"type="button" class="btn btn-light boton"><i class="fas fa-arrow-left"></i> Volver</a>
                                <a href="{{route('admin.user.edit', $user->id)}}" class="btn btn-info boton"><i class="fas fa-user-edit"></i> Editar Perfil</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
