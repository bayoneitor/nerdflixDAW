@extends('layouts.app')

@section('content')
    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <!-- Recientes -->
                    <div class="recent__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Agregados Recientemente</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if(count($videos) > 0)
                                @foreach($videos as $video)
                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="product__item">
                                            <div
                                                class="product__item__pic set-bg"
                                                data-setbg="{{asset('storage/'.$video->route_miniature)}}"
                                            >
                                                <div class="ep">{{round($video->scores()->avg('score'),2)}} <span class="icon_star"></span></div>
                                                <div class="comment">
                                                    <i class="fa fa-comments"></i> {{$video->scores()->whereNotNull('comment')->count()}}
                                                </div>
                                                <div class="view"><i class="fa fa-eye"></i> {{$video->usersWatched()->count()}}</div>
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
                                <p>No se han encontrado Videos</p>
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
    <!-- Product Section End -->
@endsection
