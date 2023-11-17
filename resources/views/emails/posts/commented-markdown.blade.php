<x-mail::message>
    # Comment was posted on your post

    Hi {{ $comment->commentable->user->name }}

    Someone has commented on you post

    <x-mail::button :url="route('posts.show', ['post' => $comment->commentable->id])" color="success">
        View The Post
    </x-mail::button>

    <x-mail::button :url="route('users.show', ['user'  =>$comment->user->id])" color="success">
        visit {{ $comment->user->name }}'s profile
    </x-mail::button>

    <x-mail::panel>
        {{$comment->content}}
    </x-mail::panel>

    Thanks,
    <br>
    {{ config('app.name') }}
</x-mail::message>
