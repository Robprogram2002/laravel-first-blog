<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //indicar la tabla con la que se relaciona
    protected $table = 'images';

    //Relacion One to Many para comentarios (sacar todos los comentarios relacionados a una imagen)
    public function comments() {
        return $this->hasMany('App\Comment')->orderBy('id','desc');
    }

    //relacion one to many para likes
    public function likes() {
        return $this->hasMany('App\Like');
    }

    //relacion many to one (sacar el usuario que haya creado la imagen)
    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

}
