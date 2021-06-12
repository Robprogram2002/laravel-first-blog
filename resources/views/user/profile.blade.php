@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        
            @foreach ($user->images as $image)
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
                            <a href= "{{route('image.detail', ['id' => $image->id] )}}">
                            <img src="{{route('image.file', ['filename' => $image->image_path])}}" alt="">
                            </a>
                        </div>
    
                        <div class="description">
                            <span class="nickname">{{$image->user->nick}}</span>  <p>{{$image->description}}</p>
                        </div>
                        <div class="likes">
                            <!--Comprobar si el usuario ya dio like a la publicacion  -->
                            <?php $user_like = false; ?>
                            @foreach ($image->likes as $like)
                                @if ($like->user->id == \Auth::user()->id)
                                    <?php $user_like = true; ?>
                                @endif
                            @endforeach
    
                            @if ($user_like)
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-heart-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" class="btn-like red"/>
                            </svg>
                            @else
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-heart-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" class="btn-like black"/>
                            </svg>
                            @endif
                            <span>{{count($image->likes)}}</span>
                        </div>
                        <div class="comments">
                            <a href="" class="btn btn-info btn-sm">Comments ({{count($image->comments)}})</a>
                        </div>
                    </div>
                </div>
            @endforeach
            
        </div>
    </div>
</div>
@endsection