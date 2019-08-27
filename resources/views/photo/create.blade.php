@extends('layouts.app')

@section('title', 'Add Photos')

@section('content')
    <div class="container">
            <form action="/photos" name="photo-form" id="photo-form" method="post" enctype="multipart/form-data">
                <input name="photo" onchange="sendImage()" type="file" class="pb-3">
                @csrf
            </form>
            <div id="errors"></div>
            <button id="showImage" class="btn btn-primary">Show images Ajax - fetch request</button>
    </div>

    <script>
        function sendImage() {
            let url = '/photos';
            let errorDiv = document.getElementById('errors');
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let input = document.querySelector('input[type="file"]');
            let headers = new Headers();
            headers.append('X-CSRF-TOKEN', token);
            headers.append('Accept', 'application/json');
            let formData = new FormData();
            formData.append('photo', input.files[0]);

            let option = {
                method: 'POST',
                headers: headers,
                body: formData
            }

            fetch(url, option)
                .then(response => response.json())
                .then(function(response) {
                    response.errors.photo.forEach(function(error){
                        let errorElem = document.createElement('span');
                        errorElem.innerHTML = error;
                        errorDiv.appendChild(errorElem);
                    })
                })
        }
    </script>
@endsection
