@extends('layouts.app')

@section('title', 'Matcha')

@section('content')
    <div id="app">
        <chat-app :user="{{ auth()->user() }}"></chat-app>
    </div>
@endsection
