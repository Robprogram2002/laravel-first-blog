<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Image;

Route::get('/', function () {

    /*
    $images = Image::all();
    foreach($images as $image) {
        echo $image->image_path.'<br>';
        echo $image->description.'<br>';

        echo $image->user->name.'  '.$image->user->surname;

        echo '<br><strong>Comentarios</strong><br>';
        foreach($image->comments as $comment) {
            echo $comment->user->name.' '.$comment->user->surname.'<br>';
            echo $comment->content.'<br>';
        }

        echo 'Likes: '.count($image->likes);

        echo '<hr>';
    }
    */


    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/configuracion','UserController@config')->name('config');
Route::post('/user/update','UserController@update')->name('user.update');
Route::get('/user/avatar/{file_name}','UserController@getImage')->name('user.avatar');
Route::get('/up_image','ImageController@create')->name('create_img');
Route::post('/image/save','ImageController@save')->name('save_img');
Route::get('/image/file/{filename}','ImageController@getImage')->name('image.file');
Route::get('/image/detail/{id}','ImageController@detail')->name('image.detail');
Route::post('/comment/save','CommentController@save')->name('comment.save');
Route::get('/like/{image_id}','LikeController@like')->name('like.save');
Route::get('/dislike/{image_id}','LikeController@dislike')->name('dislike.delete');
Route::get('/user/likes','LikeController@getAll')->name('user.likes');
Route::get('/image/delete/{id}', 'ImageController@delete')->name('image.delete');
Route::get('/image/edit/{id}', 'ImageController@edit')->name('image.edit');
Route::post('image/update/','ImageController@update')->name('image.update');


Route::get('/user/profile/{id}','UserController@profile')->name('user.profile');
