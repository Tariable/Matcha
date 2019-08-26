@extends('layouts.app')

@section('title', 'Add Photos')

@section('content')
    <div class="container">
            <form action="/photos" name="photo-form" id="photo-form" method="post" enctype="multipart/form-data">
                <input name="photo" onchange="sendImage()" type="file" class="pb-3">
                <span id="photoError"></span>
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
    <script>
        function sendImage() {
            let error = document.getElementById('photoError');
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let url = '/photos';
            let input = document.querySelector('input[type="file"]');
            let headers = {"X-CSRF-TOKEN": token};
            let formData = new FormData();
            formData.append('photo', input.files[0]);

            let option = {
                method: 'POST',
                headers: headers,
                body: formData
            }

            fetch(url, option)
                .then((res) => res.json())
                .then((data) => alert(data))
                .catch((error) => alert(error))
        }
    </script>
@endsection
