@if (Auth::user()->image) 
<div class="container-avatar">
    <img src="{{route('user.avatar',['file_name' => Auth::user()->image])}}" class="avatar">
</div>
@endif