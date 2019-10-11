@extends('layouts.app')

@section('title', 'Edit profile')

@section('content')
  <div class="container-create">
    <div class="photoContainer">
      <h2>Your photos</h2>
      <form action="/photos" name="photoForm" id="photoForm" method="post"
            enctype="multipart/form-data">
        <div id="photoFormContent">
          <label id="labelPhotoInput" class="btn btn-primary m-2" for="photoInput">Choose a photo</label>
          <input name="photoInput" id="photoInput" onchange="sendImage()" type="file" class="pb-3">
        </div>
      </form>
      <div id="photoErrors"></div>
      <div id="gallery"></div>
      <span class="hidden">Click on a picture to delete</span>
    </div>
    <div class="profileContainer">
      <h2>Your data</h2>
      <form action="/profiles/{{ Auth::id() }}" method="post" novalidate>
        <div class="form-group">
          <input name="name" id="name" type="text" class="form-control" placeholder="Name"
                 value="{{ old('name') ?? $profile->name }}">
        </div>

        <div class="form-group">
          <label class="m-2" for="date_of_birth">Date of birth</label>
          <input name="date_of_birth" id="date_of_birth" type="date" class="form-control"
                 max="2002-01-01"
                 value="{{ old('date_of_birth') ?? $profile->date_of_birth }}">
        </div>

        <div class="form-group">
          <textarea name="description" id="description" cols="15" rows="8"
                    placeholder="Here you can describe yourself.&#10;What do you like to do in your freetime?"
                    class="form-control">{{ old('description') ?? $profile->description }}</textarea>
        </div>
        <div class="mb-10">Your gender is:</div>
        <div class="form-group radio">

          <input class="form-radio" id="genderMale" name="gender" type="radio" value="male"
                  {{ $profile->gender == "male" ? 'checked' : '' }} >
          <label for="genderMale">Male</label>
          <input class="form-radio" id="genderFemale" name="gender" type="radio" value="female"
                  {{ $profile->gender == "female" ? 'checked' : '' }} >
          <label for="genderFemale">Female</label>
        </div>

        <div>
          <input type="number" id="current_longitude" name="longitude" hidden>
          <input type="number" id="current_latitude" name="latitude" hidden>
        </div>

        <div class="form-group" id="profileErrors">

        </div>

        <div class="form-group col">
          <div>
          <button class="btn btn-primary m-2" id="profileUpdate" type="submit">Edit profile</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <script src="{{ URL::asset('js/Profile/edit.js') }}"></script>
@endsection
