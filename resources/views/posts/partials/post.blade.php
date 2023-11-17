@if($post->trashed())
    <del>
        @endif
        <a href="{{route('posts.show', ['post' => $post->id])}} " class="text-muted"><h3>{{ $post->title }}</h3></a>
        @if($post->trashed())
    </del>
@endif

@component('components.updated', ['date' => $post->created_at, 'name' => $post->user->name, 'userId' => $post->user->id])
@endcomponent

@component('components.tags', ['tags' => $post->tags]) @endcomponent

@if($post->comments_count)
    <p>{{ $post->comments_count }} comments</p>
@else
    <p> no comments yet</p>
@endif
<div>
    @auth()
        @can('update', $post)
            <a href="{{route('posts.edit', ['post' => $post->id])}}" class="btn btn-outline-info">Edit</a>
        @endcan
    @endauth
    {{--    @cannot('delete', $post)--}}
    {{--        <p>can't delete post</p>--}}
    {{--    @endcannot--}}
    @auth()
        @if(!$post->trashed())
            @can('delete', $post)
                <form class="d-inline" action="{{ route('posts.destroy', ['post' =>$post->id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Delete" class="btn btn-outline-info">
                </form>
            @endcan
        @endif
    @endauth
</div>
