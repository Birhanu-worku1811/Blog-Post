@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="row">
        <div class="col-8">
            @if($post->image)
                <div
                    style="background-image: url('{{ asset('storage/' . $post->image->path) }}'); min-height: 500px; color: white; text-align: center; background-attachment: fixed">
                    <h1 style="padding-top: 100px; text-shadow: 1px 2px #000000">
                        @else
                            <h1>
                                @endif
                                <h1>{{ $post->title}}</h1>

                                @if(session('status'))
                                    <div class="alert alert-success">
                                        {{session('status')}}
                                    </div>
                                @endif
                                @if($post->image)
                            </h1>
                </div>
                @else
                    </h1>
            @endif
            <h4>{{ $post->content}}</h4>

            {{--            <img src="{{ asset('storage/'.$post->image->path) }}" alt="Image">--}}
            {{--            <img src="{{ $post->image->url() }}" alt="Image">--}}

            @component('components.updated', ['date' => $post->created_at, 'name' => $post->user->name])
            @endcomponent

            @component('components.updated', ['date' => $post->updated_at, 'userId'=>$post->user->id])
                Updated
            @endcomponent

            {{--    @component('components.tags', ['tags' => $post->tags]) @endcomponent--}}

            <p>{{ $counter }} people reading</p>

            @if(now()->diffInMinutes($post->created_at)<60)
                @component('components.badge', ['type' => 'primary'])
                    New Post!
                @endcomponent
            @endif

            @component('components.commentForm', ['route' => route('posts.comments.store', ['post'=>$post->id])])
            @endcomponent

            @if($post->comments)
                @component('components.comment_list', ['comments' => $post->comments])
                @endcomponent
            @else
                <p>No comments yet</p>
            @endif

        </div>
        @include('posts._activity')
    </div>
@endsection

