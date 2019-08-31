@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="photoContainer">
                    <h2>Photo section</h2>
                    <form action="/photos" name="photo-form" id="photo-form" method="post"
                          enctype="multipart/form-data">
                        <label for="photo">Add some pretty photos:</label>
                        <input name="photo" id="photo" hidden onchange="sendImage()" type="file" class="pb-3">
                        @csrf
                    </form>
                    <div id="errorDiv"></div>
                    <div id="gallery"></div>
                </div>

                <hr>

                <div class="profileContainer">
                    <h2>Profile section</h2>
                    <form action="/profiles/{{ Auth::id() }}" method="post" novalidate>
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label class="m-2" for="name">Name:</label>
                            <input name="name" id="name" type="text" class="form-control"
                                   value="{{ old('name') ?? $profile->name }}">
                        </div>

                        <div class="form-group">
                            <label class="m-2" for="date_of_birth">Date of birth</label>
                            <input name="date_of_birth" id="date_of_birth" type="date" class="form-control"
                                   max="2002-01-01"
                                   value="{{ old('date_of_birth') ?? $profile->date_of_birth }}">
                        </div>

                        <div class="form-group">
                            <label class="m-2" for="description">Say some words about yourself:</label>
                            <textarea name="description" id="description" cols="30" rows="3"
                                      class="form-control">{{ old('description') ?? $profile->description }}
                            </textarea>
                        </div>

                        <div class="form-group">
                            <span class="m-2">Choose your gender: </span>
                            <input class="m-2" id="genderMale" name="gender" type="radio" value="male"
                                {{ $profile->gender == "male" ? 'checked' : '' }} >
                            <label for="genderMale">Male</label>
                            <input class="m-2" id="genderFemale" name="gender" type="radio" value="female"
                                {{ $profile->gender == "female" ? 'checked' : '' }} >
                            <label for="genderFemale">Female</label>
                        </div>

                        <div class="form-group">
                            <span class="m-2">Notifications: </span>
                            <input class="m-2" id="notificationOn" name="notification" type="radio" value=1
                                {{ $profile->notification == 1 ? 'checked' : '' }} >
                            <label for="notificationOn">Turn on</label>
                            <input class="m-2" id="notificationOff" name="notification" type="radio" value=0
                                {{ $profile->notification == 0 ? 'checked' : '' }} >
                            <label for="notificationOff">Turn off</label>
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
                    showAllPhotos();
                    getCurrentLocation();
                };

                function quantityOfPhotos() {
                    let photosQuantity = document.getElementById('gallery').childElementCount;
                    return photosQuantity;
                }

                function getCurrentLocation() {
                    var geoSuccess = function (position) {
                        document.getElementById('current_longitude').value = position.coords.longitude;
                        document.getElementById('current_latitude').value = position.coords.latitude;
                    };

                    var geoError = async function () {
                        let urlLocationApi = 'https://ipapi.co/latlong/';
                        let getLocationResponse = await fetch(urlLocationApi);
                        if (getLocationResponse.ok) {
                            let location = await getLocationResponse.text();
                            location = location.split(',');
                            document.getElementById('current_latitude').value = location[0];
                            document.getElementById('current_longitude').value = location[1];
                        } else {
                            console.log("Bad location request");
                        }
                    };

                    navigator.geolocation.getCurrentPosition(geoSuccess, geoError);
                }


                async function showAllPhotos() {
                    let urlShowAllPhotos = "/photos/{{ Auth::id() }}";
                    let showAllPhotosResponse = await fetch(urlShowAllPhotos);
                    let photos = await showAllPhotosResponse.json();
                    photos.forEach(function (photo) {
                        let photoElem = document.createElement('img');
                        photoElem.src = photo.path;
                        photoElem.id = photo.id;
                        photoElem.width = 150;
                        document.getElementById('gallery').appendChild(photoElem);
                    });
                    if (quantityOfPhotos() >= 5) {
                        document.getElementById('photo-form').remove();
                    } else {
                        document.getElementById('photo').removeAttribute("hidden");
                    }
                }

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
                        removeAllChildrenElemFrom("errorDiv");
                        showLastPhoto();
                    } else {
                        let jsonErrors = await storeResponse.json();
                        jsonErrors.errors.photo.forEach(function (error) {
                            let errorElem = document.createElement('p');
                            errorElem.innerHTML = error;
                            document.getElementById('errorDiv').append(errorElem);
                        })
                    }
                }

                async function showLastPhoto() {
                    let urlShowLastPhoto = "/lastPhoto/{{ Auth::id() }}";
                    let showLastPhotoResponse = await fetch(urlShowLastPhoto);
                    let photo = await showLastPhotoResponse.json();
                    let photoElem = document.createElement('img');
                    photoElem.src = photo.path;
                    photoElem.id = photo.id;
                    photoElem.width = 150;
                    document.getElementById('gallery').appendChild(photoElem);
                    if (quantityOfPhotos() >= 5) {
                        document.getElementById('photo-form').remove();
                    } else {
                        document.getElementById('photo').removeAttribute("hidden");
                    }

                }

                function removeAllChildrenElemFrom(Div) {
                    let div = document.getElementById(Div);
                    while (div.firstChild) {
                        div.firstChild.remove()
                    }
                }
            </script>
        </div>
    </div>
@endsection
