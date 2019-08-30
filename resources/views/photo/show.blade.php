@extends('layouts.app')

@section('title', 'Show Photos')

@section('content')

    @foreach ($photos as $photo)
        <img class="pt-3 pr-2" style="width: 25%" src="{{ $photo->path }}" alt="">
    @endforeach
@endsection
