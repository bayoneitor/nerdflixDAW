<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user, $back = null)
    {
        $userAuth = Auth::user();
        if ($userAuth->id != $user->id && !$userAuth->hasRole('admin')) {
            abort(401, 'Non authorized action.');
        }

        $videosUser = $user->videos()->get();
        foreach ($videosUser as $video) {
            unlink(public_path('storage/' . $video->route_video));
            unlink(public_path('storage/' . $video->route_miniature));
            unlink(public_path('storage/' . $video->route_frame));
            $video->delete();
        }

        $user->delete();

        if ($back == 'back') {
            return redirect()->back();
        }
        return redirect()->route('index');
    }

    //Propias
    public function profile()
    {
        $videos = Auth::user()->videosWatched()->orderByDesc('date')->paginate(3);
        return view('settings')->with('videos', $videos);
    }

    public function updateProfile(Request $request)
    {
        if ($request->filled('name') || $request->filled('email')) {
            $validator = Validator::make($request->all(), [
                'name' => ['nullable', 'string', 'min:3', 'max:255'],
                'email' => ['nullable', 'string', 'email', 'max:255'],
            ]);
            if (!$validator->fails()) {
                $user = Auth::user();
                if ($request->filled('name') && $user->name != $request->name) {
                    $user->name = $request->name;
                }
                if ($request->filled('email') && $user->email != $request->email) {
                    $user->email = $request->email;
                }
                $user->save();

                return redirect()->route('settings.profile', ['success' => true]);
            }
        }
        return redirect()->route('settings.profile')->withErrors($validator);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldPassword' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!$validator->fails()) {
            $user = Auth::user();
            if (!Hash::check($request->oldPassword, $user->getAuthPassword())) {
                $validator->errors()->add('oldPassword', '¡La contraseña antigua no concuerda con la actual!');
            } else {
                $user->password = Hash::make($request->newPassword);
                $user->save();
                return redirect()->route('settings.profile', ['success' => true]);
            }
        }
        return redirect()->route('settings.profile')->withErrors($validator);
    }
}
