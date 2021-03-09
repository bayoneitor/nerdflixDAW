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
            'score' => ['required', 'string', 'min:1'],
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
        //
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Score  $score
     * @return \Illuminate\Http\Response
     */
    public function destroy(Score $score)
    {
        //
    }
    
    //Añadidas
    public function deleteComment(Score $score){
        //Mirar si es tipo admin puede "borrar"(actualizar a null el comentario) sin comprobar si es suyo
        if ($score->user->id == Auth::user()->id || Auth::user()->hasRole('admin')){
            $score->comment = null;
            $score->save();
            return back()->withErrors(['commentDelete']);
        }
        return back()->withErrors(['commentDeleteError']);
    }
}
