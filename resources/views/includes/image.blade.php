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
            <a href= "{{route('image.detail', ['id' => $image->id] )}}" class="btn btn-success btn-sm">Comments ({{count($image->comments)}}) </a>
        </div>
    </div>
</div>