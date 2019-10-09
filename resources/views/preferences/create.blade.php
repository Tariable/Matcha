@extends('layouts.app')

@section('title', 'Preferences')

@section('content')
  <div class="container-pref">
    <form action="/preferences" method="post">
      <h1>Preferences</h1>

      <div class="col-3">
        <p class="slider-info">Age preference
          <span id="lowerAge" class="custom-span"></span>
          <span id="upperAge" class="custom-span"></span>
        </p>
        <div class="age-slider">

          <input type="number" id="lowerAgeInput" name="lowerAge" hidden>
          <div>
            <div><input type="text" id="ageSlider"></div>
          </div>
          <input type="number" id="upperAgeInput" name="upperAge" hidden>

        </div>
      </div>
      <div class="col-3">
        <p class="slider-info">Max distance <span id="distance"></span></p>
        <input type="number" id="distanceInput" name="distance" hidden>
        <div>
          <div><input type="text" id="distanceSlider"></div>
        </div>
      </div>
      <div class="col-3 center">
        <p class="mb-10">Sex preferences</p>
        <div class="form-group radio justify-content-center">
          <input type="radio" id="genderBi" class="form-radio" name="sex" checked value="%ale">
          <label for="genderBi">Bisexual</label>
          <input type="radio" id="genderMale" class="form-radio" name="sex" value="male">
          <label for="genderMale">Male</label>
          <input type="radio" id="genderFemale" class="form-radio" name="sex" value="female">
          <label for="genderFemale">Female</label>
        </div>
      </div>
      <div class="col-3">
        <button class="btn btn-primary" type="submit" id="storePref">Submit</button>
        @csrf
      </div>
    </form>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  <script src="{{ URL::asset('js/Preference/create.js') }}">
  </script>
@endsection
