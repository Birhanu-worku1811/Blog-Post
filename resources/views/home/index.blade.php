@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <h1>{{ __('messages.home') }}</h1>
    <h1>@lang('messages.home')</h1>

    <p>{{ __('messages.example_with_value', ['name'=>'Birhanu']) }}</p>

    <p>@lang('messages.example_with_value', ['name'=>'Birhanu']) </p>

    <p>{{ trans_choice('messages.plural', 0) }}</p>
    <p>{{ trans_choice('messages.plural', 1) }}</p>
    <p>{{ trans_choice('messages.plural', 2) }}</p>

    <p> using json {{ __('home') }}</p>
    <p> using json {{ __('Hello :name', ['name' => 'Abebe']) }}</p>
@endsection
