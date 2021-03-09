@extends('layouts.app')

@section('content')
    <!-- Anime Section Begin -->
    <section class="anime-details spad">
        <div class="container">
            <div class="anime__details__content">
                <div class="row">
                    <div class="col-lg-3">
                        <div
                            class="anime__details__pic set-bg"
                            data-setbg="{{asset('storage/'.$video->route_miniature)}}"
                        >
                            <div class="comment"><i
                                    class="fa fa-comments"></i> {{$video->scores()->whereNotNull('comment')->count()}}
                            </div>
                            <div class="view"><i class="fa fa-eye"></i> {{$video->usersWatched()->count()}}</div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="anime__details__text">
                            <div class="anime__details__title">
                                <h3>{{$video->title}}</h3>
                            </div>
                            <p>{{$video->cont}}</p>
                            <div class="anime__details__widget">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Puntuación:</span> {{round($video->scores()->avg('score'),2) *2}}
                                                <span> - {{$video->scores()->count()}} votos</span>
                                            </li>
                                            <li><span>Visitas:</span> {{$video->usersWatched()->count()}}</li>
                                            <li><span>Autor:</span> {{$video->user->name}}</li>

                                            <li><span>Tags:</span>
                                                @foreach($video->tags as $tag)
                                                    @if ($loop->last)
                                                        {{$tag->name}}
                                                    @else
                                                        {{$tag->name}},
                                                    @endif
                                                @endforeach
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Publicado:</span> {{$video->created_at}}</li>
                                            @if($video->created_at != $video->updated_at)
                                                <li><span>Modificado:</span> {{$video->updated_at}}</li>
                                            @endif

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="anime__details__btn">
                                @if($video->user_id == Auth::user()->id || Auth::user()->hasRole('admin'))
                                    <a href="{{route('videos.edit', $video->id)}}" class="follow-btn"><span
                                            class="icon_pencil"></span> Editar</a>

                                    <button type="button" class="follow-btn" data-toggle="modal" data-target="#exampleModal" style="border:none;">
                                        <span class="icon_trash"></span> Borrar</a>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Borrar video</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Estás seguro que deseas borrar el video: <strong>{{$video->title}}</strong></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    <form method="post" action="{{route('videos.destroy',$video->id)}}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="submit" class="btn btn-primary" value="Borrar">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endif
                                <a href="{{route('video.watch',$video->id)}}" class="watch-btn"><span>Ver Ahora</span> <i
                                        class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Comentarios -->
            @include('includes.videos.comments')
        </div>
    </section>
@endsection
@section('extraJS')
    <script>
        var score = document.getElementById("score");
        var scoreStars = document.getElementById("score-stars");
        score.addEventListener("mousemove", function () {
            let v = score.value;
            let result = "";

            let cero = '<span class="icon_star_alt" style="color:red;"></span>';
            let media =
                '<span class="icon_star-half_alt" style="color:red;"></span>';
            let una = '<span class="icon_star" style="color:red;"></span>';

            switch (v) {
                case "0":
                    result = cero + cero + cero + cero + cero;
                    break;
                case "0.5":
                    result = media + cero + cero + cero + cero;
                    break;
                case "1":
                    result = una + cero + cero + cero + cero;
                    break;
                case "1.5":
                    result = una + media + cero + cero + cero;
                    break;
                case "2":
                    result = una + una + cero + cero + cero;
                    break;
                case "2.5":
                    result = una + una + media + cero + cero;
                    break;
                case "3":
                    result = una + una + una + cero + cero;
                    break;
                case "3.5":
                    result = una + una + una + media + cero;
                    break;
                case "4":
                    result = una + una + una + una + cero;
                    break;
                case "4.5":
                    result = una + una + una + una + media;
                    break;
                default:
                    result = una + una + una + una + una;
                    break;
            }
            scoreStars.innerHTML = result;
        });
    </script>
@endsection
