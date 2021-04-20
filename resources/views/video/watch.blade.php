@extends('layouts.app')
@section('content')
    <!-- Anime Section Begin -->
    <section class="anime-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="anime__details__title h3" style="color:white;"><i class="fas fa-angle-double-right"></i> {{$video->title}}</h1>
                    <div class="anime__video__player">
                        <video
                            id="player"
                            playsinline
                            controls
                            data-poster="{{asset('storage/'.$video->route_frame)}}"
                        >
                            <source src="{{asset('storage/'.$video->route_video)}}" type="video/mp4" />
                        </video>
                    </div>
                </div>
            </div>
             <!-- Comentarios -->
            @include('includes.videos.comments')
        </div>
    </section>
@endsection
@section('extraJS')
    <script src="https://cdn.plyr.io/3.6.4/plyr.polyfilled.js"></script>
    <script>
        const player = new Plyr('#player');
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
