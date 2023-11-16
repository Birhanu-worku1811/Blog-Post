<div class="col-4">
    <div class="container">
        <div class="row mt-4">
            @component('components.card', ['title' => 'Most Commented', 'subtitle' => 'Posts with most number of Comments'])
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
            @component('components.card', ['title' => 'Most Active', 'subtitle' => 'Users with most number of posts'])
                @slot('items', collect($most_active)->pluck('name'))
            @endcomponent
        </div>
        <div class="row mt-4">
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <h5 class="card-title">Most Active Last Month</h5>
                    <p class="card-subtitle mb-2 text-muted">Users with most blog posts in the last month</p>
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
