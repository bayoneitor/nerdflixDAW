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
                                    <h4>Crear un video</h4>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="{{route('videos.store')}}" enctype="multipart/form-data" class="row video">
                            @csrf
                            <div class="col-lg-6">
                                <label><h6>Título</h6></label>
                                <input type="text" placeholder="Título" name="title" required/>
                                <label><h6>Descripción</h6></label>
                                <textarea placeholder="Descripción" name="description" required></textarea>
                                <label><h6>Etiquetas</h6></label>
                                <input type="text" placeholder="Etiqueta1,Etiqueta2" name="tags" required/>
                            </div>
                            <div class="col-lg-6">
                                <h6>Video</h6>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="video" aria-describedby="video" name="video" required>
                                        <label class="custom-file-label" for="video">Escoger archivo</label>
                                    </div>
                                </div>
                                <h6>Frame Video</h6>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="frame" aria-describedby="frame" name="frame" required>
                                        <label class="custom-file-label" for="frame">Escoger archivo</label>
                                    </div>
                                </div>
                                <h6>Miniatura</h6>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="miniature" aria-describedby="miniature" name="miniature" required>
                                        <label class="custom-file-label" for="miniature">Escoger archivo</label>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-success" value="Crear Video">
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
