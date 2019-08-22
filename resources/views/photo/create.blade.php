@extends('layouts.app')

@section('title', 'Add Photos')

@section('content')
    <div class="container">
            <form action="/photos" method="post" enctype="multipart/form-data">
                <input name="photo[]" type="file" class="pb-3">
                <input name="photo[]" type="file" class="pb-3">
                <input name="photo[]" type="file" class="pb-3">
                <input name="photo[]" type="file" class="pb-3">
                <input name="photo[]" type="file" class="pb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
                @csrf
            </form>
    </div>


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection
