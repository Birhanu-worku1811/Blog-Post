<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>
<p> Hi {{ $comment->commentable->user->name }}</p>

<p>
    Someone has commennted on you post
    <a href="{{ route('posts.show', ['post' => $comment->commentable->id]) }}">{{ $comment->commentable->title }}</a>
</p>

<hr>

<p>
    {{--    {{ dd($message->embed($comment->user->image->url())) }}--}}
    <img src="{{ $message->embedData($comment->user->image->url(), 'profile.jpg') }}">
    <a href="{{ route('users.show', ['user'  =>$comment->user->id]) }}">{{ $comment->user->name }}</a> said:
</p>

<p>
    {{ $comment->content }}
</p>
