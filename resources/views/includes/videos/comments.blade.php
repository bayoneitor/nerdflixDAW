<div class="row">
    <div class="col-lg-8 col-md-8">
        <!-- Dejar comentario -->
        <div class="anime__details__form">
            <div class="section-title">
                <h5>Deja tu opinión</h5>
            </div>
            @if($video->scores()->where('user_id',Auth::user()->id)->count() == 0)
                <form method="POST" action="{{route('video.score.store')}}">
                    @csrf
                    <input value="{{$video->id}}" name="video" hidden/>
                    <div style="display: flex">
                        <label for="score" style="color: white">* Puntuar:</label>
                        <input
                            type="range"
                            name="score"
                            id="score"
                            min="0"
                            max="5"
                            step="0.5"
                            value="2.5"
                            required
                            style="margin: 0 20px 20px 20px"
                        />
                        <div id="score-stars">
                                <span class="icon_star" style="color: red"></span
                                ><span class="icon_star" style="color: red"></span
                            ><span class="icon_star-half_alt" style="color: red"></span
                            ><span class="icon_star_alt" style="color: red"></span
                            ><span class="icon_star_alt" style="color: red"></span>
                        </div>
                    </div>
                    <textarea
                        placeholder="Tu comentario" name="comment"
                    ></textarea>
                    <button type="submit">
                        <i class="fa fa-location-arrow"></i> Enviar
                    </button>
                </form>
            @else
                <div class="alert alert-warning text-center" role="alert">
                    ¡¡¡ Ya has puntuado/comentado en este video !!!
                </div>
            @endif
        </div>
        <!-- COMENTARIOS -->
        <div class="anime__details__review">
            <div class="section-title" style="margin-top: 30px">
                <h5>Opiniones</h5>
            </div>
            @if($errors->any())
                @if($errors->first() == 'commentAdded')
                    <div class="alert alert-success text-center" role="alert">
                        Comentario añadido correctamente.
                    </div>
                @elseif($errors->first() == 'commentAddedError')
                    <div class="alert alert-danger text-center" role="alert">
                        No se ha podido añadir el comentario.
                    </div>
                @elseif($errors->first() == 'commentDelete')
                    <div class="alert alert-success text-center" role="alert">
                        Se ha eliminado el comentario correctamente.
                    </div>
                @elseif($errors->first() == 'commentDeleteError')
                    <div class="alert alert-danger text-center" role="alert">
                        No se ha podido eliminar el comentario.
                    </div>
                @elseif($errors->first() == 'updateCorrect')
                    <div class="alert alert-success text-center" role="alert">
                        Comentario actualizado correctamente.
                    </div>
                @elseif($errors->first() == 'updateError')
                    <div class="alert alert-danger text-center" role="alert">
                        No se ha podido actualizar el comentario.
                    </div>
                @endif
            @endif

            @if($video->scores()->whereNotNull('comment')->count() > 0)
                @foreach($video->scores()->whereNotNull('comment')->orderBy('created_at', 'desc')->get() as $score)
                    <div class="anime__review__item">
                        <div
                            class="anime__review__item__text  @if($score->user_id == Auth::user()->id) mine @endif">
                            <h6>{{$score->user->name}} - <span>{{$score->score}}</span> <span
                                    class="icon_star"></span> -
                                <span>
                                                @if($currentTime->diffInMinutes($score->created_at) < 60)
                                        hace {{$currentTime->diffInMinutes($score->created_at)}}
                                        @if($currentTime->diffInMinutes($score->created_at) == 1)
                                            minuto
                                        @else
                                            minutos
                                        @endif
                                    @elseif($currentTime->diffInHours($score->created_at) < 24)
                                        hace {{$currentTime->diffInHours($score->created_at)}}
                                        @if($currentTime->diffInHours($score->created_at) == 1)
                                            hora
                                        @else
                                            horas
                                        @endif
                                    @else
                                        hace {{$currentTime->diffInDays($score->created_at)}}
                                        @if($currentTime->diffInDays($score->created_at) == 1)
                                            día
                                        @else
                                            días
                                        @endif
                                    @endif

                                            </span>
                                @if($score->user_id == Auth::user()->id || Auth::user()->hasRole('admin'))
                                <span class="delete">
                                    <form method="post" action="{{route('video.destroy.score',$score->id)}}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="Borrar" class="btn btn-danger btn-sm">
                                    </form>
                                </span>
                                    @if($score->user_id == Auth::user()->id)
                                        <span class="delete" style="margin-right: 10px">
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#scoreModal">
                                                Editar
                                            </button>
                                        </span>
                                        <!-- Modal -->
                                        <div class="modal fade" id="scoreModal" tabindex="-1" role="dialog" aria-labelledby="scoreModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="scoreModalLabel">Actualizar comentario/puntuación</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <form method="POST" action="{{route('video.update.score',$score->id)}}">
                                                    <div class="modal-body">
                                                            @method('PUT')
                                                            @csrf
                                                            <div style="display: flex">
                                                                <label for="score" style="color: black">Puntuación:</label>
                                                                <input
                                                                    type="range"
                                                                    name="score"
                                                                    id="score"
                                                                    min="0"
                                                                    max="5"
                                                                    step="0.5"
                                                                    value="{{$score->score}}"
                                                                    style="margin: 0 20px 20px 20px"
                                                                />
                                                                <div id="score-stars">
                                                                        <span class="icon_star" style="color: red"></span
                                                                        ><span class="icon_star" style="color: red"></span
                                                                    ><span class="icon_star-half_alt" style="color: red"></span
                                                                    ><span class="icon_star_alt" style="color: red"></span
                                                                    ><span class="icon_star_alt" style="color: red"></span>
                                                                </div>
                                                            </div>
                                                            <label for="comment" style="color: black">Comentario:</label>
                                                            <br>
                                                            <textarea
                                                                placeholder="{{$score->comment}}" id="comment" name="comment" style="width: 100%"
                                                            >{{$score->comment}}</textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    <input type="submit" class="btn btn-primary" value="Guardar Cambios"/>
                                                    </div>
                                                </form>
                                            </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </h6>
                            <p>{{$score->comment}}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-info text-center" role="alert">
                    ¡¡¡ Se el primero en opinar !!!
                </div>
            @endif
        </div>
    </div>
</div>
