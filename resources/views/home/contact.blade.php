@extends('layouts.app')

@section('title', 'Contact')

@section('content')
    <h1>Contact page</h1>

    @can('home.secret')
        <p>
            <a href="{{ route('secret') }}">
                Special contact page
            </a>
        </p>
    @endcan
@endsection
