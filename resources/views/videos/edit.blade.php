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
                                    <h4>Editar un video</h4>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="{{route('videos.update',$video->id)}}" enctype="multipart/form-data" class="row video">
                            @csrf
                            @method('PUT')
                            <div class="col-lg-6">
                                <label><h6>Título</h6></label>
                                <input type="text" placeholder="Título" name="title" value="{{$video->title}}" required/>
                                <label><h6>Descripción</h6></label>
                                <textarea placeholder="Descripción" name="description">{{$video->cont}}</textarea>
                                <label><h6>Etiquetas</h6></label>
                                <input type="text" placeholder="Etiqueta1,Etiqueta2" name="tags" value="@foreach($video->tags as $tag)@if($loop->last){{$tag->name}}@else{{$tag->name}},@endif @endforeach"/>
                            </div>
                            <div class="col-lg-6">
                                <h6>Frame Video</h6>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="frame" aria-describedby="frame" name="frame">
                                        <label class="custom-file-label" for="frame">Escoger archivo</label>
                                    </div>
                                </div>
                                <h6>Miniatura</h6>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="miniature" aria-describedby="miniature" name="miniature">
                                        <label class="custom-file-label" for="miniature">Escoger archivo</label>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-success" value="Actualizar Video">
                            </div>
                        </form>
                        <div class="row">
                            @if($errors->any())
                                {!!  implode('', $errors->all('<span class="invalid-feedback" role="alert"> <strong>:message</strong></span><br>')) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->
@endsection
