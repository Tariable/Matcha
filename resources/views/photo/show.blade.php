@extends('layouts.app')

@section('title', 'Show Photos')

@section('content')

    @foreach ($paths as $path)
        <img src="{{ $path }}" alt="">
    @endforeach
@endsection
