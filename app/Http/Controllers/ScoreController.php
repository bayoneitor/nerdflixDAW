<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScoreController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'score' => ['required', 'numeric', 'min:0', 'max:5'],
            'comment' => ['required', 'string', 'min:1'],
            'video' => ['required', 'string', 'min:1'],
        ]);
        if (!$validator->fails()) {
            $video = new score();
            $video->score = $request->score;
            $video->comment = $request->comment;
            $video->user_id = Auth::user()->id;
            $video->video_id = $request->video;
            $video->save();

            return back()->withErrors(['commentAdded']);
        }
        return back()->withErrors(['commentAddedError']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $score
     * @param  \App\Models\Score  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Score $score)
    {
        $validator = Validator::make($request->all(), [
            'score' => ['required', 'numeric', 'min:0', 'max:5'],
            'comment' => ['required', 'string', 'min:1']
        ]);
        if (!$validator->fails()) {
            if ($score->user->id == Auth::user()->id || Auth::user()->hasRole('admin')) {
                $score->update($request->all());
                return back()->withErrors(['updateCorrect']);
            }
        }
        return back()->withErrors(['updateError']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Score  $score
     * @return \Illuminate\Http\Response
     */
    public function destroy(Score $score)
    {
        if ($score->user->id == Auth::user()->id || Auth::user()->hasRole('admin')) {
            $score->delete();
            return back()->withErrors(['commentDelete']);
        }
        return back()->withErrors(['commentDeleteError']);
    }
}
