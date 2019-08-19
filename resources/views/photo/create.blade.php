@extends('layouts.app')

@section('title', 'Add Photos')

@section('content')
{{--    <img src="storage/images/test_1566141616.jpg" alt="">--}}
    <div class="container">
            <form action="/photos" method="post" enctype="multipart/form-data">
                <input name="photo" type="file" class="pb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
                @csrf
            </form>
    </div>
@endsection
