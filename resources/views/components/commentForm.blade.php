<div class="mb-2 mt-2">
    @auth()
        <h3>{{__("Comments")}}</h3>
        <form action="{{ $route }}" method="post">
            @csrf

            <div class="form-group">
        <textarea class="form-control" id="content"
                  name="content"></textarea>
            </div>
            {{--            <input type="submit" value="comment" class="btn btn-primary btn-block">--}}
            <button class="btn btn-primary btn-block">{{__("Add comment")}}</button>
            @component('components.errors')
            @endcomponent
        </form>
    @else
        <p><a href="{{ route('login') }}">{{__("Login")}}</a> to comment to a post</p>
    @endauth
</div>
<hr>
