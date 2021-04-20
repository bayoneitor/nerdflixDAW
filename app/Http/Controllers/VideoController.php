<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $videos = Video::orderBy('title', 'asc')->paginate(6);
        return view('video.index')->with(['videos' => $videos]);
    }

    public function search($title)
    {
        $videos = Video::orderBy('title', 'asc')->where('title', 'like', '%' . $title . '%')->paginate(6);
        return view('video.search')->with(['videos' => $videos, 'title' => $title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('video.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'min:4'],
            'description' => ['required', 'string', 'min:20'],
            'tags' => ['required', 'string', 'min:2'],
            'video' => ['required', 'file', 'mimes:mp4,avi'],
            'frame' => ['required', 'file', 'mimes:jpg,bmp,png', 'max:3072'],
            'miniature' => ['required', 'file', 'mimes:jpg,bmp,png', 'max:1024'],
        ]);
        if (!$validator->fails()) {
            //user
            $user = Auth::user();
            //paths
            $pathVideo = $request->file('video')->store('videos', 'public');
            $pathFrame = $request->file('frame')->store('img/frames', 'public');
            $pathMiniature = $request->file('miniature')->store('img/miniature', 'public');
            //FIN video
            $video = new video();
            $video->title = $request->title;
            $video->cont = $request->description;
            $video->user_id = $user->id;
            $video->route_video = $pathVideo;
            $video->route_frame = $pathFrame;
            $video->route_miniature = $pathMiniature;
            $video->save();
            //Tags
            $this->insertTags($request->tags, $video);

            return redirect()->route('video.show', $video->id);
        }
        return redirect()->route('video.create')->withErrors($validator);
    }

    /**
     * Display the specified resource.
     *
     * @param Video $video
     * @return Response
     */
    public function show(Video $video)
    {
        $currentTime = Carbon::now();
        return view('video.show')->with(['video' => $video, 'currentTime' => $currentTime]);
    }

    public function watch(Video $video)
    {
        if (Auth::user()->videosWatched()->where('video_id', $video->id)->count() == 0) {
            Auth::user()->videosWatched()->attach($video);
        }
        $currentTime = Carbon::now();
        return view('video.watch')->with(['video' => $video, 'currentTime' => $currentTime]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Video $video
     * @return Response
     */
    public function edit(Video $video)
    {
        return view('video.edit')->with('video', $video);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Video $video
     * @return Response
     */
    public function update(Request $request, Video $video)
    {
        $user = Auth::user();
        if ($video->user_id != $user->id && !$user->hasRole('admin')) {
            abort(401, 'Non authorized action.');
        }

        $validator = Validator::make($request->all(), [
            'title' => ['nullable', 'string', 'min:4', 'max:150'],
            'description' => ['nullable', 'string', 'min:20'],
            'tags' => ['nullable', 'string', 'min:2'],
            'frame' => ['nullable', 'file', 'mimes:jpg,bmp,png', 'max:3072'],
            'miniature' => ['nullable', 'file', 'mimes:jpg,bmp,png', 'max:1024'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
        ]);

        if ($request->filled('email') && $user->hasRole('admin')) {
            $userEmail = User::where('email', $request->email)->get('id');
            $validator->after(function ($validator) use ($userEmail) {
                if ($userEmail->count() == 0) {
                    $validator->errors()->add('email', '¡El email introducido no existe!');
                }
            });
        }

        if (!$validator->fails()) {
            if ($request->filled('title') && $video->title != $request->title) {
                $video->title = $request->title;
            }
            if ($request->filled('description') && $video->cont != $request->description) {
                $video->cont = $request->description;
            }
            if ($request->file('frame')) {
                unlink(public_path('storage/' . $video->route_frame));

                $pathFrame = $request->file('frame')->store('img/frames', 'public');
                $video->route_frame = $pathFrame;
            }
            if ($request->file('miniature')) {
                unlink(public_path('storage/' . $video->route_miniature));

                $pathMiniature = $request->file('miniature')->store('img/miniature', 'public');
                $video->route_miniature = $pathMiniature;
            }
            if ($request->filled('email') && $user->hasRole('admin')) {
                $video->user_id = $userEmail[0]->id;
            }
            $video->save();
            //Tags
            if ($request->filled('tags')) {
                $video->tags()->detach();
                $this->insertTags($request->tags, $video);
            }
            return redirect()->route('video.show', $video->id);
        }
        return redirect()->route('video.edit', $video->id)->withErrors($validator);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Video $video
     * @return Response
     */
    public function destroy(Video $video, $back = null)
    {
        $user = Auth::user();
        if ($video->user_id != $user->id && !$user->hasRole('admin')) {
            abort(401, 'Non authorized action.');
        }
        //No hace falta, se borra solo de todos los sitios
        //$video->tags()->detach();
        unlink(public_path('storage/' . $video->route_video));
        unlink(public_path('storage/' . $video->route_miniature));
        unlink(public_path('storage/' . $video->route_frame));
        $video->delete();

        if ($back == 'back') {
            return redirect()->back();
        }
        return redirect()->route('index');
    }

    private function insertTags($tags, Video $video)
    {
        $tagArr = explode(',', str_replace(' ', '', $tags));
        for ($i = 0; $i < count($tagArr); $i++) {
            $tagName = ucfirst(strtolower($tagArr[$i]));
            $tagSel = Tag::where('name', $tagName)->get();
            if ($tagSel->count() == 0) {
                $tag = new Tag();
                $tag->name = $tagName;
                $tag->save();
            } else {
                $tag = $tagSel;
            }
            $video->tags()->attach($tag);
        }
    }
}
