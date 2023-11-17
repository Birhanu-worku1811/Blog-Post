@foreach($comments as $comment)
    <p>
        {{ $comment->content }},
    </p>
    @component('components.updated', ['date' => $comment->created_at, 'name' => $comment->user->name, 'userId' => $comment->user->id])
    @endcomponent

    @component('components.tags', ['tags' => $comment->tags]) @endcomponent
@endforeach
