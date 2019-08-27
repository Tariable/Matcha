@extends('layouts.app')

@section('title', 'Preferences')

@section('content')
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
            <div class="container" style="display: flex; padding-left: 0;">
                <div class="btn-group-toggle pr-2" data-toggle="buttons">
                    <label class="btn btn-secondary active" style="background-color:#FF7373">
                        <input type="radio" name="pref_sex" checked value="bi"> Bisexual</label>
                    <label class="btn btn-secondary" style="background-color:#FF7373">
                        <input type="radio" name="pref_sex" value="male"> Male</label>
                    <label class="btn btn-secondary" style="background-color:#FF7373">
                        <input type="radio" name="pref_sex" value="female"> Female</label>
                </div>
            </div>
        </div>
        <div class="col-3">
            <p class="pt-4" style="margin-bottom: 0 !important;">Tags</p>
        </div>
        <div class="col-3">

            <div class="container pb-4" style="
                    display: flex;
                    padding-left: 0;
                    margin-left: 0;
                    flex-wrap: wrap;
                    justify-content: space-between;
                    width: 85%;
                    align-items: center;
                    height: 150px;">
                @foreach($tags as $i => $tag)
                    <div class="btn-group-toggle pr-2" data-toggle="buttons">
                        <label class="btn btn-info" style="
                            background-color: #6cb2eb;
                            border-radius: 5px;
                            text-align: center;
                            width: 100px;">
                            <input name="tags[]" type="checkbox" value="{{ $i + 1 }}"> {{ $tag }}
                        </label>
                    </div>
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
