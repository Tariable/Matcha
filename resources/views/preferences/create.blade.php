@extends('layouts.app')

@section('title', 'Preferences')

@section('content')
  <div class="container-pref">

    <form action="/preferences" method="post">
      <div class="col-3">
        <p class="pt-4" style="margin-bottom: 0 !important;">Age preference</p>
        <div class="age-slider">
          <span id="lowerAge" class="custom-span"></span>
          <input type="number" id="lowerAgeInput" name="lowerAge" hidden>
          <div>
            <div id="ageSlider"></div>
          </div>
          <input type="number" id="upperAgeInput" name="upperAge" hidden>
          <span id="upperAge" class="custom-span"></span>
        </div>
      </div>
      <div class="col-3">
        <p class="pt-4" style="margin-bottom: 0 !important;">Max distance</p>
        <input type="number" id="distanceInput" name="distance" hidden>
        <span id="distance"></span>
        <div id="distanceSlider"></div>
      </div>
      <div class="col-3">
        <p class="pt-4" style="margin-bottom: 0 !important;">Sex preferences</p>
        <div class="form-group radio">
          <input type="radio" id="genderBi" class="form-radio" name="sex" checked value="%ale">
          <label for="genderBi">Bisexual</label>
          <input type="radio" id="genderMale" class="form-radio" name="sex" value="male">
          <label for="genderMale">Male</label>
          <input type="radio" id="genderFemale" class="form-radio" name="sex" value="female">
          <label for="genderFemale">Female</label>
        </div>
      </div>
      <div class="col-3">
        <p class="pt-4" style="margin-bottom: 0 !important;">Tags</p>
      </div>
      <div class="col-3">

        <div class="container-tag form-group radio" data-toggle="buttons">
          @foreach($tags as $i => $tag)
            <div><label for="t{{ $i + 1 }}"><input name="tags[]" id="t{{ $i + 1 }}" type="checkbox" value="{{ $i + 1 }}" checked>
                {{ $tag }}</label></div>
          @endforeach
        </div>
      </div>
      <div class="col-3">
        <button class="btn btn-primary" type="submit">Submit</button>
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

  <script>

    let ageSlider = document.getElementById('ageSlider');
    let distanceSlider = document.getElementById('distanceSlider');

    noUiSlider.create(distanceSlider, {
      start: [20],
      step: 1,
      connect: 'lower',
      range: {
        'min': [3],
        'max': [100]
      }
    });

    noUiSlider.create(ageSlider, {
      start: [18, 28],
      connect: true,
      margin: 3,
      step: 1,
      range: {
        'min': [18],
        'max': [100]
      }
    });

    ageSlider.noUiSlider.on('update', function (values, handle) {
      let ageGap = ageSlider.noUiSlider.get();
      document.getElementById("lowerAge").innerHTML = parseInt(ageGap[0]);
      document.getElementById("lowerAgeInput").value = parseInt(ageGap[0]);
      document.getElementById("upperAge").innerHTML = parseInt(ageGap[1]);
      document.getElementById("upperAgeInput").value = parseInt(ageGap[1]);
    });

    distanceSlider.noUiSlider.on('update', function (values, handle) {
      let distanceGap = distanceSlider.noUiSlider.get();
      document.getElementById("distance").innerHTML = parseInt(distanceGap) + " km";
      document.getElementById("distanceInput").value = parseInt(distanceGap);
    });
  </script>
@endsection
