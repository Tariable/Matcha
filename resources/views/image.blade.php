@extends('layouts.app')

@section('content')
{{--    <img src="storage/images/test_1566141616.jpg" alt="">--}}
    <div class="container">
            <form action="image" method="post" enctype="multipart/form-data">
                <input name="image" type="file" class="pb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
                @csrf
            </form>
    </div>
@endsection
