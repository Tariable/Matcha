@extends('layouts.app')

@section('title', 'Create profile')

@section('content')
  <div class="container-create">
    <div class="photoContainer">
      <h2>Your photos</h2>
      <form action="/photos" name="photoForm" id="photoForm" method="post"
            enctype="multipart/form-data">
        <div id="photoFormContent">
          <label id="labelPhotoInput" for="photoInput">Choose a photo</label>
          <input name="photoInput" id="photoInput" onchange="sendImage()" type="file" class="pb-3">
        </div>
      </form>
      <div id="photoErrors"></div>
      <div id="gallery"></div>
      <span class="hidden">Click on a picture to delete</span>
    </div>
    <div class="profileContainer">
      <h2>Your data</h2>
      <form action="/profiles" method="post" id="profileForm" novalidate>
        <div class="form-group">
          <input name="name" id="name" type="text" class="form-control"
                 value="{{ old('name') }}" placeholder="First Name">
        </div>

        <div class="form-group">
          <label class="m-2" for="date_of_birth">Date of birth</label>
          <input name="date_of_birth" id="date_of_birth" type="date" class="form-control"
                 max="2002-01-01"
                 value="{{ old('date_of_birth') }}">
        </div>

        <div class="form-group">
          <textarea name="description" id="description" cols="15" rows="8"
                    class="form-control" placeholder="Here you can describe yourself.&#10;What do you like to do in your freetime?">{{ old('description') }}</textarea>
        </div>
        <div class="mb-10">Your gender is:</div>
        <div class="form-group radio">

          <input class="form-radio" id="genderMale" name="gender" type="radio" value="male" checked
                  {{ old('gender') == 'male' ? 'checked' : ''}}>
          <label for="genderMale">Male</label>
          <input class="form-radio" id="genderFemale" name="gender" type="radio" value="female"
                  {{ old('gender') == 'female' ? 'checked' : ''}}>
          <label for="genderFemale">Female</label>
        </div>
        <div>
          <input type="number" id="longitude" name="longitude" hidden>
          <input type="number" id="latitude" name="latitude" hidden>
        </div>

        <div class="form-group" id="profileErrors">

        </div>

        <div class="form-group col">
          <div>
            <button class="btn btn-primary m-2" id="profileStore" type="submit">Create profile
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <script src="{{ URL::asset('js/Profile/create.js') }}"></script>
@endsection
