<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function like($image_id) {
        
        $user = \Auth::user();

        $isset_like = Like::where('user_id',$user->id)->where('image_id',$image_id)->count();

        if($isset_like == 0) {
            $like = new Like();
            $like->user_id = $user->id;
            $like->image_id = (int) $image_id;

            $like->save();

            $numberlikes = Like::where('image_id', $image_id)->count();

            return Response()->json(['like'=> $like, 'numberlikes' => $numberlikes,'messege' => 'el like se ha guardado correctamente']);
        }else {
            $numberlikes = Like::where('image_id', $image_id)->count();
            return Response()->json(['message'=> 'El like ya existe', 'numberlikes' => $numberlikes]);
        }
        

    }

    public function dislike($image_id) {

        $user = \Auth::user();

        $like = Like::where('user_id',$user->id)->where('image_id',$image_id)->first();

        if($like) {

            $like->delete();

            $numberlikes = Like::where('image_id', $image_id)->count();

            return \response()->json([
                'like' => $like,
                'numberlikes' => $numberlikes,
                'message' => 'Has borrado el like coorrectamente'
            ]);
        }else {
            $numberlikes = Like::where('image_id', $image_id)->count();
            return Response()->json(['message'=> 'El like no se ha podido eliminar', 'numberlikes' => $numberlikes]);

        }
    }

    public function getAll() {

        $user = \Auth::user();

        $likes = Like::where('user_id',$user->id)->orderBy('id','desc')->paginate(5);

        return view('like.likes', ['likes' => $likes]);
    }
}
