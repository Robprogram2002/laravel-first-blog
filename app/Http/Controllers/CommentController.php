<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request) {
        $validate = $this->validate($request, [
            'content' => 'string|required',
            'image_id' => 'integer|required'
        ]);

        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->content = $content;
        $comment->image_id = $image_id;

        $comment->save();

        return \redirect()->route('image.detail', [ 'id' => $image_id])->with([
            'message' => 'Tu commentario se ha publicado exitosamente!'
        ]);
    }
}
