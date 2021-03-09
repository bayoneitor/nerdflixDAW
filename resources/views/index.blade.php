@extends('layouts.app')

@section('content')
    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Recientes -->
                    <div class="recent__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Agregados Recientemente</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="{{route('video.index')}}" class="primary-btn">Ver Todos <span class="arrow_right"></span></a>
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
                    </div>
                    <!-- populares month-->
                    <div class="popular__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Más Vistos Último Mes</h4>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="{{route('video.index')}}" class="primary-btn"
                                    >Ver Todos <span class="arrow_right"></span
                                        ></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if(count($popularVideosMonth) > 0)
                                @foreach($popularVideosMonth as $video)
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
                                                <div class="view"><i class="fa fa-eye"></i> {{$video->usersWatched()->whereDate('date','>',$month)->count()}}</div>
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
                    </div>

                    <!-- populares all-->
                    <div class="popular__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>Más Vistos</h4>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="{{route('video.index')}}" class="primary-btn"
                                    >Ver Todos <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if(count($popularVideos) > 0)
                                @foreach($popularVideos as $video)
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
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->
@endsection
