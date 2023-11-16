<p>
    @foreach($tags as $tag)
        <a href="{{route('posts.tags.index', ['tag' => $tag->id]) }}" class="alert alert-success">{{ $tag->name }}</a>
    @endforeach
</p>
