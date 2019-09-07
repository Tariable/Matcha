@extends('layouts.app')

@section('title', 'Matcha')

@section('content')
    <h4><a href="/profiles/edit">Edit profile</a></h4>
    <h4><a href="/preferences/edit">Edit preferences</a></h4>

    <div class="container my-3 py-5 text-center">
        <div class="row mb-5">
            <div class="col">
                <h1> {{ $data['name'] }}, {{ $data['age'] }}</h1>
            </div>
        </div>
        <button  class="btn btn-success" style="float:right">Like</button>
        <button class="btn btn-danger" style="float:left">Dislike</button>
        <div class="card">
            <div class="card-body">
                <img src="/storage/photos/3ea54fb0e0d9845b3c0c.jpg" alt="" class="img-fluid mb-3">
                <h3>{{ $data['distance'] }} km from you</h3>
                <p> {{ $data['desc'] }}</p>
                <p>Common tags:
                @foreach($data['common_tags'] as $tag)
                    {{ $tag }}
                @endforeach
                </p>
            </div>
        </div>
    </div>

@endsection
