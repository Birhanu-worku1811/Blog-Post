@extends('layouts.app')
{{--@include('posts.partials.post')--}}
@section('title', 'Blog Posts')

@section('content')
    <div class="row">
        <div class="col-8">
            @if(count($posts))
                @foreach($posts as $post)
                    @include('posts.partials.post')
                @endforeach
            @else
                <h1>No posts found</h1>
            @endif
        </div>
        @include('posts._activity')
    </div>
@endsection
