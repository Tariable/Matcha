@extends('layouts.app')

@section('title', 'Show Photos')

@section('content')

    @foreach ($paths as $path)
        <img class="pt-3 pr-2" style="width: 25%" src="{{ $path }}" alt="">
    @endforeach
@endsection
