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
                    $.getJSON('https://ipapi.co/217.67.187.54/latitude', function(data) {
                        console.log(JSON.stringify(data));
                        // document.getElementById('current_longitude').value = JSON.stringify(data.geoplugin_longitude);
                        // document.getElementById('current_latitude').value = JSON.stringify(data.geoplugin_latitude);
                    });
                };

                navigator.geolocation.getCurrentPosition(geoSuccess, geoError);
            };
        </script>
    </div>
</div>
@endsection
