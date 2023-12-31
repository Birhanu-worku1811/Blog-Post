<?php


namespace App\Http\Controllers;

use App\Contracts\CounterContract;
use App\Events\BlogPostPosted;
use App\Facades\CounterFacade;
use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\Image;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use function redirect;
use function view;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private CounterContract $counter;

    public function __construct()
    {
        $this->middleware('auth')->only([
            'create', 'store', 'update', 'destroy', 'edit'
        ]);
//        $this->middleware('locale');
    }

    public function index()
    {

        //with comments count
        return view('posts.index',
            [
                'posts' => BlogPost::latestWithRelations()->get()
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePost $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $post = BlogPost::create($validated);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');
            $post->image()->save(
                Image::make(['path' => $path])
            );
        }

        event(new BlogPostPosted($post));

        $request->session()->flash('status', 'the blog post was created!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
//        return view('posts.show', [
//            'post' => BlogPost::with([
//                'comments' => function ($query) {
//                    return $query->latest();
//                }
//            ])->findOrFail($id)
//        ]);
        $blog_post = Cache::tags(['blog_post'])->remember("blog-post-{$id}", 10, function () use ($id) {
            return BlogPost::with('comments', 'tags', 'user', 'comments.user')->findOrFail($id);
        });

//        $counter = resolve(Counter::class);

        return view('posts.show', [
            'post' => $blog_post,
            'counter' => CounterFacade::increment("blog-post-{$id}", ['blog-post'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = BlogPost::findOrFail($id);
        $this->authorize('update', $post);
        return view('posts.edit', ['post' => BlogPost::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePost $request, string $id)
    {
        // Rest of your logic
        $post = BlogPost::findOrFail($id);

//        if (Gate::denies('update-post', $post)) {
//            abort(403, "You are not allowed to do this, Okay!");
//        }
        $this->authorize('update', $post);

        $validated = $request->validated();
        $post->fill($validated);
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');
            if ($post->image) {
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            } else {
                $post->image()->save(
                    Image::make(['path' => $path])
                );
            }
        }

        $post->save();

        $request->session()->flash('status', 'Blog post updated');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = BlogPost::findOrFail($id);
        $this->authorize('delete', $post);
//        if (Gate::denies('posts.delete', $post)) {
//            abort(403, "You are not allowed to do this, Okay!");
//        }
        $post->delete();

        session()->flash('status', 'Blog Post delete successfully!');

        return redirect()->route('posts.index');
    }
}
