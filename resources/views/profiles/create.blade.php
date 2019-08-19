@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <form action="/profiles" method="post">
                @csrf
                <div class="form-group">
                    <label class="m-2" for="name">Name:</label>
                    <input name="name" id="name" type="text" class="form-control">
                </div>

                <div class="form-group">
                    <label class="m-2" for="date_of_birth">Date of birth</label>
                    <input name="date_of_birth" id="date_of_birth" type="date" class="form-control" value="01-01-2000" max="01-01-2002">
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
</div>
@endsection
