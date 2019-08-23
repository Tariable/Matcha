@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <form action="/profiles" method="post" novalidate>
                @csrf
                <div class="form-group">
                    <label class="m-2" for="name">Name:</label>
                    <input name="name" id="name" type="text" class="form-control">
                </div>

                <div class="form-group">
                    <label class="m-2" for="date_of_birth">Date of birth</label>
                    <input name="date_of_birth" id="date_of_birth" type="date" class="form-control" max="2002-01-01">
                </div>

                <div class="form-group">
                    <label class="m-2" for="description">Say some words about yourself:</label>
                    <textarea name="description" id="description" cols="30" rows="10" class="form-control">
                    </textarea>
                </div>

                <div class="form-group">
                    <label class="m-2" for="gender">Choose your gender:</label>
                    <input class="m-2" id="gender" name="gender" type="radio" value="Male"><span>Male</span>
                    <input class="m-2" id="gender" name="gender" type="radio" value="Female"><span>Female</span>
                </div>

                <div class="form-group">
                    <label class="m-2" for="notification">Notifications</label>
                    <input class="m-2" id="notification" name="notification" type="radio" value=true><span>Turn on</span>
                    <input class="m-2" id="notification" name="notification" type="radio" value=false><span>Turn off</span>
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
        <script>
            window.onload = function() {
                var geoSuccess = function(position) {

                    document.getElementById('current_longitude').value = position.coords.longitude;
                    document.getElementById('current_latitude').value = position.coords.latitude;
                };

                var geoError = function() {
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
    </div>
</div>
@endsection
