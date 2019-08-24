@extends('layouts.app')

@section('title', 'Preferences')

@section('content')
    <p>Choose your age preference</p>
    <div class="col-3">
        <span id="lowerAge"></span>
        <div id="ageSlider"></div>
        <span id="upperAge"></span>
    </div>

    <div class="col-3">
        <p>Max distance</p>
        <span id="lowerDistance"></span>
        <div id="distanceSlider"></div>
    </div>

    <div class="col-3">
        <p class="pt-3">Sex preferences</p>
        <div class="radio">
            <label><input type="radio" name="radio" checked> Bisexual</label>
        </div>
        <div class="radio">
            <label><input type="radio" name="radio"> Male</label>
        </div>
        <div class="radio">
            <label><input type="radio" name="radio"> Female</label>
        </div>
    </div>

    <script>

        let ageSlider = document.getElementById('ageSlider');
        let distanceSlider = document.getElementById('distanceSlider');

        noUiSlider.create(distanceSlider, {
            start: [0],
            step: 1,
            connect: 'lower',
            range: {
                'min': [0],
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
            document.getElementById("upperAge").innerHTML = parseInt(ageGap[1]);
        });

        distanceSlider.noUiSlider.on('update', function (values, handle) {
            let distanceGap = distanceSlider.noUiSlider.get();
            document.getElementById("lowerDistance").innerHTML = parseInt(distanceGap);
        });
    </script>
@endsection
