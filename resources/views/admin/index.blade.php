@extends('layouts.app')

@section('content')
    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-12">
                    <div class="recent__product">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="section-title">
                                    <h4>Buscar Usuario</h4>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-center-end flex-column seach-user">
                           <div>
                               <label for="email">Correo:</label>
                                <input id="email" type="email" placeholder="ejemplo@gmail.com">
                            </div>
                            <div>
                                <label>Roles:</label>
                                @foreach ($roles as $role)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input roles" type="checkbox" id="{{$role->name}}" value="{{$role->name}}">
                                        <label class="form-check-label" for="{{$role->name}}">{{$role->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div>
                                <button type="button" id="search-button-user"class="btn btn-light">Filtrar</button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="section-title">
                                    <h4>Usuario/s</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if(count($users) > 0)
                            <table class="table table-hover table-dark table-users">
                                <thead>
                                  <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Correo</th>
                                    <th scope="col">Roles</th>
                                    <th scope="col">Fecha Creación</th>
                                    <th scope="col">Fecha Actualización</th>
                                    <th scope="col">Acciones</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <th scope="row">{{$user->id}}</th>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            @foreach($user->roles()->get() as $role)
                                                @if ($loop->last)
                                                    {{$role->name}}
                                                @else
                                                    {{$role->name}},
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{$user->created_at}}</td>
                                        <td>
                                            @if($user->updated_at == $user->created_at)
                                                &nbsp;
                                            @else
                                            {{$user->updated_at}}
                                            @endif
                                        </td>
                                        <td class="actions">
                                            <a href="{{route('admin.user.info', $user->id)}}" class="fas fa-info-circle info"></a>
                                            <a href="{{route('admin.user.edit', $user->id)}}" class="fas fa-user-edit edit"></a>
                                            <i data-id="{{$user->id}}" data-email="{{$user->email}}" class="fas fa-trash-alt delete deleteUser" data-toggle="modal" data-target="#UserModal"></i>
                                        </td>
                                    </tr>
                                @endforeach
                                    </tbody>
                                </table>

                                <!-- Modal User -->
                                <div class="modal fade" id="UserModal" tabindex="-1" role="dialog" aria-labelledby="UserModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="UserModalLabel">Borrar Usuario</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Estás seguro que deseas borrar el usuario <span id="user-info"></span> </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                <form method="post" id="user-form-id" action="#">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="submit" class="btn btn-primary" value="Borrar">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning" role="alert">No se han encontrado Usuarios</div>
                        @endif
                        </div>
                        @if(count($users) > 0)
                        <div class="row d-flex justify-content-center">{{$users->links()}}</div>
                        @endif
                        {{-- Videos --}}
                        @isset($videos)
                        <br><br>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="section-title">
                                    <h4>Video/s</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if(count($users) > 0)
                            <table class="table table-hover table-dark table-users">
                                <thead>
                                  <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Titulo</th>
                                    <th scope="col">Autor</th>
                                    <th scope="col">Tags</th>
                                    <th scope="col">Visitas</th>
                                    <th scope="col">Fecha Creación</th>
                                    <th scope="col">Fecha Actualización</th>
                                    <th scope="col">Acciones</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @foreach($videos as $video)
                                    <tr>
                                        <th scope="row">{{$video->id}}</th>
                                        <td>{{$video->title}}</td>
                                        <td>{{$video->user->email}}</td>
                                        <td>
                                            @foreach($video->tags as $tag)
                                                @if ($loop->last)
                                                    {{$tag->name}}
                                                @else
                                                    {{$tag->name}},
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{$video->usersWatched()->count()}}</td>
                                        <td>{{$video->created_at}}</td>
                                        <td>
                                            @if($video->updated_at == $video->created_at)
                                                &nbsp;
                                            @else
                                            {{$video->updated_at}}
                                            @endif
                                        </td>
                                        <td class="actions">
                                            <a href="{{route('video.show', $video->id)}}" class="fas fa-play-circle info"></a>
                                            <a href="{{route('video.edit', $video->id)}}" class="fas fa-edit edit"></a>
                                            <i data-id="{{$video->id}}" data-title="{{$video->title}}" class="fas fa-trash-alt delete deleteVideo" data-toggle="modal" data-target="#VideoModal"></i>
                                        </td>
                                    </tr>
                                @endforeach
                                    </tbody>
                                </table>

                                <!-- Modal Video -->
                                <div class="modal fade" id="VideoModal" tabindex="-1" role="dialog" aria-labelledby="VideoModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="VideoModalLabel">Borrar video</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Estás seguro que deseas borrar el video con titulo <span id="video-info"></span> </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                <form method="post" id="video-form-id" action="#">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="submit" class="btn btn-primary" value="Borrar">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning" role="alert">No se han encontrado Videos</div>
                        @endif
                        </div>
                        @if(count($users) > 0)
                        <div class="row d-flex justify-content-center">{{$users->links()}}</div>
                        @endif
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('extraCSS')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endsection
@section('extraJS')
    <script>
        // Lo habia intentado hacer con JS normal con un onclick desde el mismo html llamando a una funcion
        // pero me daba error undefined function, así que por eso he optado por jquery, ya que es mas facil
        $( document ).ready(function() {
            $(".deleteUser").on("click", function () {
                let email = $(this).data("email");
                let idUser = $(this).data("id");

                let action = "{{route('admin.user.destroy', ['user'=> ':userId','back'=>'back'])}}";
                action = action.replace(':userId',idUser);

                $("#user-form-id").attr('action', action);
                $("#user-info").html("<strong>"+email+"</strong> con la ID <strong>"+idUser+"</strong>");
            });

            $(".deleteVideo").on("click", function () {

                let title = $(this).data("title");
                let idVideo = $(this).data("id");

                let action = "{{route('admin.video.destroy', ['video'=>':videoId', 'back'=>'back'])}}";
                action = action.replace(':videoId',idVideo);

                $("#video-form-id").attr('action', action);
                $("#video-info").html("<strong>"+title+"</strong> con la ID <strong>"+idVideo+"</strong>");
            });
        });
    </script>
    <script>
        var searchButtonEmail = document.getElementById("search-button-user");

        searchButtonEmail.addEventListener("click", function () {
            let searchTextEmail = document.getElementById("email");
            let searchRoles = document.getElementsByClassName('roles');

            let url = "{{route('admin.user.search', ['email' => ':email', 'role' => ':role'])}}";
            let email = 'no-email';
            let role = '';

            let valueEmail = searchTextEmail.value.trim();
            if (valueEmail != '' && searchTextEmail.validity.valid) {
                email = valueEmail;
            }
            //Lo habia pensado para seleccionar los usuarios con todos esos roles
            //lo tenia en checkbox, pero lo he cambiado a radio para solo poder seleccionar uno
            //ya que no encuentro la forma de hacer el sql correcto
            for(var i=0; searchRoles[i]; ++i){
                if(searchRoles[i].checked){
                    if (role != '') {
                        role += ',';
                    }
                    role += searchRoles[i].value;
                }
            }

            url = url.replace(':email',email).replace(':role', role);
            window.location.href = url;
        });
    </script>
@endsection
