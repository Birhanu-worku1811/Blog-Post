<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>Laravel App - @yield('title')</title>
</head>
<body>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4
    bg-white border-bottom shadow-sm mb-3">
    <h5 class="my-0 me-md-auto font-weight-normal"> Laravel App</h5>
    <nav class="my-2 my-md-0 me-md-3">
        <a class="p-2 my-md-0 me-md-3" href="{{ route('home.index') }}">Home</a>
        <a class="p-2 my-md-0 me-md-3" href="{{ route('home.contact') }}">contact</a>
        <a class="p-2 my-md-0 me-md-3" href="{{ route('posts.index') }}">BlogPosts</a>
        <a class="p-2 my-md-0 me-md-3" href="{{route('posts.create')}}">Add</a>

        @guest()
            @if(Route::has('register'))
                <a class="p-2 my-md-0 me-md-3" href="{{route('register')}}">Register</a>
            @endif
            <a class="p-2 my-md-0 me-md-3" href="{{route('login')}}">Login</a>
        @else
            <a class="p-2 my-md-0 me-md-3" href="{{route('logout')}}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout({{ Auth::user()->name }}
                )</a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none">
                @csrf
            </form>
        @endguest
    </nav>
</div>
<div class="container">
    @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    @endif
    @yield('content')
</div>
</body>
</html>
