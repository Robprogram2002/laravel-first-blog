<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use App\Image;
use App\Comment;
use App\Like;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create() {

        return view('image.create');
    }

    public function save(Request $request) {

        //validacion
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'required|image'
        ]);

        $image_path = $request->file('image_path');
        $description = $request->input('description');

        //asignar valores al objeto
        $user = \Auth::user();
        $image = new Image();
        $image->user_id = $user->id;
        $image->description = $description;

        //subir fichero
        if($image_path) {
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));

            $image->image_path = $image_path_name;
        }

        $image->save();

        return redirect()->route('home')
            ->with(['message' => 'La foto ha sido subida correctamente!!']);

    }

    public function getImage($filename) {
        $file = Storage::disk('images')->get($filename);
        return new Response($file,200);
    }

    public function detail($id) {
        $image = Image::find($id);

        return view('image.detail', [
            'image' => $image
        ]);
    }

    public function delete($id) {
        $user = \Auth::user();
        $image = Image::find($id);
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();

        if($user && $image->user_id == $user->id) {

            if($comments) {
                foreach($comments as $comment) {
                    $comment->delete();
                }
            }

            if($likes) {
                foreach($likes as $like) {
                    $like->delete();
                }
            }

            //eliminar ficheros de imagen

            Storage::disk('images')->delete($image->image_path);

            $image->delete();

            $message = array('message' => 'La imagen y la publicacion han sido borrados con exito');
        }else {
            $message = array('message' => 'La imagen y la publicacion no han sido borrados con exito');
        }


        return redirect()->route('home')->with($message);
    }

    public function edit($id) {
        $user = \Auth::user();
        $image = Image::find($id);

        if ($user && $image && $user->id == $image->user->id) {
            return view('image.edit', ['image' => $image]);
        }else {
            return \redirect()->route('home');
        }
    }

    public function update(Request $request) {
        
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'image'
        ]);

        $image = Image::find($request->input('image_id'));
        $description = $request->input('description');
        $image_path = $request->file('image_path');

        $image->description = $description;

        if($image_path) {
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));

            $image->image_path = $image_path_name;
        }


        $image->update();

        return redirect()->route('image.detail', ['id' => $request->input('image_id')])
            ->with(['message' => 'imagen actualizada con exito']);
    }
}
