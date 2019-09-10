@extends('layouts.app')

@section('title', 'Preferences')

@section('content')
    <div class="container-pref">
    <form action="/preferences/{{ Auth::id() }}" method="post">
        <div class="col-3">
            <p class="pt-4" style="margin-bottom: 0 !important;">Age preference
                <span id="lowerAge" class="custom-span"></span>
                <span id="upperAge" class="custom-span"></span>
            </p>
            <div class="age-slider">

                <input type="number" id="lowerAgeInput" name="lowerAge" value="{{ $preference->lowerAge }}" hidden>
                <div>
                    <div><input type="text" id="ageSlider"></div>
                </div>
                <input type="number" id="upperAgeInput" name="upperAge" value="{{ $preference->upperAge }}" hidden>

            </div>
        </div>
        <div class="col-3">
            <p class="pt-4" style="margin-bottom: 0 !important;">Max distance
                <span id="distance"></span>
            </p>
            <input type="number" id="distanceInput" name="distance" value="{{ $preference->distance }}" hidden>
            <div>
                <div><input type="text" id="distanceSlider"></div>
            </div>
        </div>
        <div class="col-3">
            <p class="pt-4" style="margin-bottom: 0 !important;">Sex preference</p>
            <div class="container" style="display: flex; padding-left: 0;">
                <div class="btn-group-toggle pr-2" data-toggle="buttons">
                    <label class="btn btn-secondary active" style="background-color:#FF7373">
                        <input type="radio" name="sex" {{ $preference->pref_sex === '%ale' ? 'checked' : '' }}
                        value="%ale"> Bisexual</label>
                    <label class="btn btn-secondary" style="background-color:#FF7373">
                        <input type="radio" name="sex" {{ $preference->pref_sex === 'male' ? 'checked' : '' }}
                        value="male"> Male</label>
                    <label class="btn btn-secondary" style="background-color:#FF7373">
                        <input type="radio" name="sex" {{ $preference->pref_sex === 'female' ? 'checked' : '' }}
                        value="female"> Female</label>
                </div>
            </div>
        </div>
        <div class="col-3">
            <p class="pt-4" style="margin-bottom: 0 !important;">Tags</p>
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
        $("#ageSlider").ionRangeSlider({
            type: "int",
            skin: "round",
            min: 18,
            max: 100,
            from: $("#lowerAgeInput")[0].value,
            min_interval: 3,
            to: $("#upperAgeInput")[0].value,
            hide_min_max: true,
            hide_from_to: true,
            grid: false,

            onChange: function (data) {
                $("#lowerAge")[0].innerHTML = data.from + " -";
                $("#lowerAgeInput")[0].value = data.from;
                $("#upperAge")[0].innerHTML = data.to;
                $("#upperAgeInput")[0].value = data.to;
            },
            onStart: function (data) {
                $("#lowerAge")[0].innerHTML = data.from + " -";
                $("#lowerAgeInput")[0].value = data.from;
                $("#upperAge")[0].innerHTML = data.to;
                $("#upperAgeInput")[0].value = data.to;
            },

        });

        $("#distanceSlider").ionRangeSlider({
            type: "single",
            skin: "round",
            min: 5,
            max: 100,
            from: $("#distanceInput")[0].value,
            hide_min_max: true,
            hide_from_to: true,
            grid: false,

            onStart: function (data) {
                $("#distance")[0].innerHTML = data.from + " km";
                $("#distanceInput")[0].value = data.from;
            },

            onChange: function (data) {
                $("#distance")[0].innerHTML = data.from + " km";
                $("#distanceInput")[0].value = data.from;
            },

        });

    </script>

@endsection
