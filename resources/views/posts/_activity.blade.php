<div class="col-4">
    <div class="container">
        <div class="row mt-4">
            @component('components.card', ['title' => __("Most Commented"), 'subtitle' => __("What people are currently talking about")])
                @slot('items')
                    @foreach($most_commented as $post)
                        <li class="list-group-item">
                            <a
                                href="{{ route('posts.show', ['post'=>$post->id]) }}">
                                {{ $post->title }}
                            </a>
                        </li>
                    @endforeach
                @endslot
            @endcomponent
        </div>
        <div class="row mt-4">
            @component('components.card', ['title' => __("Most Active"), 'subtitle' => __("Writers with most posts written")])
                @slot('items', collect($most_active)->pluck('name'))
            @endcomponent
        </div>
        <div class="row mt-4">
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <h5 class="card-title">{{__("Most Active Last Month")}}</h5>
                    <p class="card-subtitle mb-2 text-muted">{{__("Users with most posts written in the month")}}</p>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($most_active_last_month as $user)
                        <li class="list-group-item">{{ $user->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
