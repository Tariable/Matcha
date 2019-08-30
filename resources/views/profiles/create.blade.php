@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="photoContainer">
                    <form action="/photos" name="photo-form" id="photo-form" method="post"
                          enctype="multipart/form-data">
                        <input name="photo" onchange="sendImage()" type="file" class="pb-3">
                        @csrf
                    </form>
                    <div id="errorDiv"></div>
                    <div id="gallery"></div>
                </div>

                <div class="profileContainer">
                    <form action="/profiles" method="post" novalidate>
                        @csrf
                        <div class="form-group">
                            <label class="m-2" for="name">Name:</label>
                            <input name="name" id="name" type="text" class="form-control" value="{{ old('name') }}">
                        </div>

                        <div class="form-group">
                            <label class="m-2" for="date_of_birth">Date of birth</label>
                            <input name="date_of_birth" id="date_of_birth" type="date" class="form-control"
                                   max="2002-01-01"
                                   value="{{ old('date_of_birth') }}">
                        </div>

                        <div class="form-group">
                            <label class="m-2" for="description">Say some words about yourself:</label>
                            <textarea name="description" id="description" cols="30" rows="3" class="form-control"
                                      value="{{ old('description') }}">
                    </textarea>
                        </div>

                        <div class="form-group">
                            <label class="m-2" for="gender">Choose your gender:</label>
                            <input class="m-2" id="gender" name="gender" type="radio" value="Male"><span>Male</span>
                            <input class="m-2" id="gender" name="gender" type="radio" value="Female"><span>Female</span>
                        </div>

                        <div class="form-group">
                            <label class="m-2" for="notification">Notifications</label>
                            <input class="m-2" id="notification" name="notification" type="radio"
                                   value=1><span>Turn on</span>
                            <input class="m-2" id="notification" name="notification" type="radio"
                                   value=0><span>Turn off</span>
                        </div>

                        <div>
                            <input type="number" id="current_longitude" name="current_longitude" hidden>
                            <input type="number" id="current_latitude" name="current_latitude" hidden>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary m-2" type="submit">Create profile</button>
                        </div>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                </div>

            </div>
            <script>
                window.onload = function () {
                    var geoSuccess = function (position) {

                        document.getElementById('current_longitude').value = position.coords.longitude;
                        document.getElementById('current_latitude').value = position.coords.latitude;
                    };

                    var geoError = function () {
                        var xhr = new XMLHttpRequest();
                        xhr.onload = function () {
                            if (xhr.status >= 200 && xhr.status < 300) {
                                var latlong = xhr.response.split(',');
                                document.getElementById('current_latitude').value = latlong[0];
                                document.getElementById('current_longitude').value = latlong[1];
                            } else {
                                console.log('The request failed!');
                            }
                        };
                        xhr.open('GET', 'https://ipapi.co/latlong/');
                        xhr.send();
                    };

                    navigator.geolocation.getCurrentPosition(geoSuccess, geoError);
                };
            </script>

            <script>
                async function sendImage() {
                    let urlStore = '/photos';

                    let headers = new Headers();
                    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    headers.append('X-CSRF-TOKEN', token);
                    headers.append('Accept', 'application/json');

                    let formData = new FormData();
                    let input = document.querySelector('input[type="file"]');
                    formData.append('photo', input.files[0]);

                    let option = {
                        method: 'POST',
                        headers: headers,
                        body: formData
                    }

                    let storeResponse = await fetch(urlStore, option);

                    if (storeResponse.ok) {
                        removeAllChildElemFrom("errorDiv");
                        displayLastPhoto();
                    } else {
                        let jsonErrors = await storeResponse.json();
                        jsonErrors.errors.photo.forEach(function (error) {
                            let errorElem = document.createElement('p');
                            errorElem.innerHTML = error;
                            document.getElementById('errorDiv').appendChild(errorElem);
                        })
                    }
                    async function displayLastPhoto() {
                        let urlShow = "/lastPhoto/{{ Auth::id() }}";
                        let showResponse = await fetch(urlShow);
                        let photo = await showResponse.json();
                        let photoElem = document.createElement('img');
                        photoElem.src = photo.path;
                        photoElem.id = photo.id;
                        photoElem.width = 150;
                        document.getElementById('gallery').appendChild(photoElem);
                    }

                    function removeAllChildElemFrom(Div) {
                        let div = document.getElementById(Div);
                        while (div.firstChild) {
                            div.removeChild(div.firstChild);
                        }
                    }
                }
            </script>
        </div>
    </div>
@endsection
