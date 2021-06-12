<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use App\User;   

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function config() {
        
        return view('user.config');
    }

    public function update(Request $request) {
        $user = \Auth::user();
        $id = \Auth::user()->id;

        $validate = $this->validate($request, [
            'name' => 'required', 'string', 'max:255',
            'surname' => 'required', 'string', 'max:255',
            'nick' => 'required', 'string', 'max:255','unique:users,nick,'.$id,
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users,email'.$id,
        ]);

        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        //subir la imagen
        $imagen_path = $request->file('image_path');
        if($imagen_path) {

            //poner nombre unico
            $image_path_name = time().$imagen_path->getClientOriginalName();
            //guardar en storage
            Storage::disk('users')->put($image_path_name,File::get($imagen_path));

            $user->image = $image_path_name;
        }

        //consulta a la BD
        $user->update();

        return redirect()->route('config')
            ->with(['message' => 'Usuario actualizado correctamente']);


    }

    public function getImage($file_name) {
        $file = Storage::disk('users')->get($file_name);

        return new Response($file, 200);
    }

    public function profile($id) {
        $user = User::find($id);

        return view('user.profile', [
            'user' => $user
        ]);
    }

    public function index($search = null) {
        if(!empty($search)) {
            $users = User::where('nick', 'LIKE', '%'.$search.'%')
                            ->orWhere('name', 'LIKE', '%'.$search.'%')
                            ->orWhere('surname', 'LIKE', '%'.$search.'%')
                            ->orderBy('id', 'desc')
                            ->paginate(5);
        }else {
            $users = User::orderBy('id', 'desc')->paginate(5);
        }

        return view('user.index', ['users' => $users]);
        //falta craer esta vista
    }
}
