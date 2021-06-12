@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('includes.success_message')

            <div class="card pub_img">
                <div class="card-header">
                    @if ($image->user->image)
                    <div class="container-avatar">
                        <img src="{{route('user.avatar',['file_name' => $image->user->image])}}" class="avatar">
                    </div>    
                    @endif
                    <div class="data-user">
                        {{ $image->user->name.' '.$image->user->surname }}
                    </div>
                </div>

                <div class="card-body">
                    <div class="image-container" >

                            <img src="{{route('image.file', ['filename' => $image->image_path])}}" alt="">  
                        
                    </div>

                    <div class="description">
                        <span class="nickname">{{$image->user->nick}}</span>  <p>{{$image->description}}</p>
                    </div>
                    <div class="likes">
                        <?php $user_like = false; ?>
                        @foreach ($image->likes as $like)
                            @if ($like->user->id == \Auth::user()->id)
                                <?php $user_like = true; ?>
                            @endif
                        @endforeach

                        @if ($user_like)
                            <img src="{{ asset('icons/like-red.png')}}"  style="width: 20px" class="btn-dislike" data-id="{{$image->id}}">
                        @else
                            <img src="{{ asset('icons/favorite-64.png')}}" style="width: 20px" class="btn-like" data-id="{{$image->id}}">
                        @endif
                        <span data-id="{{$image->id}}" class="number-likes">{{count($image->likes)}}</span>
                    </div>

                    @if (Auth::user() && Auth::user()->id == $image->user_id)
                    <div class="actions">
                        <a href="{{route('image.edit', ['id' => $image->id])}}" class="btn btn-info btn-sm">Actualizar</a>
                        <a href="{{route('image.delete', ['id' => $image->id])}}" class="btn btn-danger btn-sm">Eliminar</a>
                    </div>
                    <br>
                    @endif


                    <div class="comments">
                        <h2>Comments ({{count($image->comments)}})  </h2>
                        <hr>

                        <form action= "{{route('comment.save')}}" method = 'POST'>
                            @csrf

                            <input type = 'hidden' name = 'image_id' value= '{{$image->id}}'>
                            <p>
                                <textarea  class = 'form-control' name = 'content' required = 'required' placeholder = 'comment here...'></textarea> 
                            </p>
                            <button type="submit" class="btn btn-success">Enviar</button>
                        </form>     
                        <hr>
                         
                        @foreach ($image->comments as $comment) 
                            <div class="single-comment">
                                <div class="description">
                                    <span class="nickname">{{'@'.$comment->user->nick}}</span>
                                    <p>{{$comment->content}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
