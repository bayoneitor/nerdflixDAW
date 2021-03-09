<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $videos = Video::orderBy('id','desc')->take(6)->get();
        $month = Carbon::now()->subDays(30);
        $popularVideosMonth = Video::orderByDesc(DB::table('user_video')->groupBy('user_video.video_id')->whereColumn('user_video.video_id','videos.id')->select(DB::raw('count(*) as total'))->whereDate('date','>', $month))->get();
        $popularVideos = Video::orderByDesc(DB::table('user_video')->groupBy('user_video.video_id')->whereColumn('user_video.video_id','videos.id')->select(DB::raw('count(*) as total')))->get();

        return view('index')->with(['videos'=> $videos, 'popularVideos'=> $popularVideos, 'popularVideosMonth'=> $popularVideosMonth,'month'=>$month]);
    }
}
