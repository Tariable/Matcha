@extends('layouts.app')

@section('title', 'Matcha')

@section('content')
    <p>{{ Auth::id() }}</p>
    <div id="app">
        <chat-app :user="{{ auth()->user() }}"></chat-app>
    </div>
@endsection
