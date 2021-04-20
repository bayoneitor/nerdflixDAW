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
                                    <h4>Configuración Usuario</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 settings-buttons">
                                <div class="text row">
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <p>Nombre: <strong>{{Auth::user()->name}}</strong></p>
                                        <p>E-mail: <strong>{{Auth::user()->email}}</strong></p>
                                        <p>Tienes el rol:
                                            @foreach(Auth::user()->roles()->get() as $role)
                                                <strong>  @if ($loop->last)
                                                        {{$role->name}}.
                                                    @else
                                                        {{$role->name}},
                                                    @endif
                                                </strong>
                                            @endforeach
                                        </p>
                                        <p>Fecha Creación: <strong>{{Auth::user()->created_at}}</strong></p>
                                        @if(Auth::user()->created_at != Auth::user()->updated_at)
                                            <p>Fecha Modificación: <strong>{{Auth::user()->updated_at}}</strong></p>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <p>Videos Creados: <strong>{{Auth::user()->videos()->count()}}</strong></p>
                                        <p>Videos Vistos: <strong>{{Auth::user()->videosWatched()->count()}}</strong></p>
                                        <p>Videos Comentados/Puntuados: <strong>{{Auth::user()->scores()->count()}}</strong></p>
                                        <p>Videos Puntuación Media: <strong>{{round(Auth::user()->scores()->avg('score'),2) *2}}/10</strong></p>
                                    </div>
                                </div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-info boton" data-toggle="modal"
                                        data-target="#editarPerfil">
                                    Editar Perfil
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="editarPerfil" tabindex="-1" role="dialog"
                                     aria-labelledby="editarPerfilLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editarPerfilLabel">Editar Perfil</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="{{route('settings.updateProfile')}}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="email" class="col-form-label">Nuevo Correo
                                                            Electrónico:</label>
                                                        <input type="email" class="form-control" id="email" name="email"
                                                               placeholder="{{Auth::user()->email}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name" class="col-form-label">Nuevo Nombre
                                                            Usuario:</label>
                                                        <input type="text" class="form-control" id="name" name="name"
                                                               placeholder="{{Auth::user()->name}}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">
                                                        Cancelar
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-info boton" data-toggle="modal"
                                        data-target="#cambiarContraseña">
                                    Cambiar Contraseña
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="cambiarContraseña" tabindex="-1" role="dialog"
                                     aria-labelledby="cambiarContraseñaLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="cambiarContraseñaLabel">Cambiar
                                                    Contraseña</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="{{route('settings.updatePassword')}}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="oldPassword" class="col-form-label">Contraseña
                                                            Antigua:</label>
                                                        <input type="password" class="form-control" id="oldPassword"
                                                               name="oldPassword" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="newPassword" class="col-form-label">Contraseña
                                                            Nueva:</label>
                                                        <input type="password" class="form-control" id="newPassword"
                                                               name="password">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="repNewPassword" class="col-form-label">Confirmar
                                                            Contraseña Nueva:</label>
                                                        <input type="password" class="form-control" id="repNewPassword"
                                                               name="password_confirmation" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal" required>
                                                        Cancelar
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--__ FIN-->
                                <div>
                                    <button class="btn btn-warning boton"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Cerrar Sesión
                                    </button>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                                {{-- Eliminar cuenta --}}
                                <button type="button" class="btn btn-danger boton" data-toggle="modal" data-target="#deleteUser" style="border:none;">
                                    <span class="icon_trash"></span> Borrar Cuenta</a>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="deleteUserLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteUserLabel">BORRAR CUENTA</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Estás seguro que deseas borrar tu cuenta, <strong>¡perderas todo!</strong></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                <form method="post" action="{{route('settings.user.destroy', Auth::user()->id)}}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="submit" class="btn btn-primary" value="Borrar">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-6">
                                @if($errors->any())
                                    {!!  implode('', $errors->all('<span class="invalid-feedback" role="alert"> <strong>:message</strong></span><br>')) !!}
                                @endif
                                @isset($success)
                                    <span class="valid-feedback" role="alert">
                                        <strong>Se ha actualizado correctamente</strong>
                                    </span>
                                @endisset
                            </div>
                        </div>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Historial</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            @if(count($videos) > 0)
                                @foreach($videos as $video)
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="product__item">
                                            <div
                                                class="product__item__pic set-bg"
                                                data-setbg="{{asset('storage/'.$video->route_miniature)}}"
                                            >
                                                <div class="ep">{{round($video->scores()->avg('score'),2)}} <span
                                                        class="icon_star"></span></div>
                                                <div class="comment">
                                                    <i class="fa fa-comments"></i> {{$video->scores()->whereNotNull('comment')->count()}}
                                                </div>
                                                <div class="view"><i
                                                        class="fa fa-eye"></i> {{$video->usersWatched()->count()}}</div>
                                            </div>
                                            <div class="product__item__text">
                                                <ul>
                                                    @foreach($video->tags as $tag)
                                                        <li>{{$tag->name}}</li>
                                                    @endforeach
                                                </ul>
                                                <h5>
                                                    <a href="{{route('video.show',$video->id)}}">{{$video->title}}</a>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-warning" role="alert">No se han encontrado Videos</div>
                            @endif
                        </div>
                        @if(count($videos) > 0)
                            <div class="row d-flex justify-content-center" style="">{{$videos->links()}}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
