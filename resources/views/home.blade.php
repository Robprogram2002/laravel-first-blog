@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.success_message')

            @foreach ($images as $image)
            @include('includes.image', ['image' => $image])
            @endforeach

        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-6 text-center">
            <div class="clearfix"></div>
            {{$images->links()}}
        </div>
    </div>
</div>
@endsection
