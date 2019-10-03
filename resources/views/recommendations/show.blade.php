@extends('layouts.app')

@section('title', 'Matcha')

@section('content')

  <div class="container-card">
    <div class="row mb-5">
    </div>
    <div class="card" id="card">
      <div class="lds-heart"><div></div></div>
      <div class="card-body" id="cardBody" hidden>
          <div id="carousel" class="carousel">
          </div>
          <div id="mainInfo" class="card-info">
            <div>
              <p id="cardName"></p>
            </div>
            <p id="cardDistance"></p>
            <p id="cardId" hidden></p>
          </div>
        </div>
      <div class="buttons">
        <button class="btn btn-danger" id="ban" onclick="ban()">Dislike</button>
          <button class="btn btn-success" id="like" onclick="like()">Like</button>
      </div>
      <p id="cardDescription"></p>
      </div>
    </div>

  <div class="m-2">
      <h4><a href="/messages">Messages</a></h4>
      <h4><a href="/profiles/edit">Edit profile</a></h4>
    <h4><a href="/preferences/edit">Edit preferences</a></h4>
  </div>
  <div id="expandDiv">

  </div>
  <script src="{{ URL::asset('js/Recommendations/recommendations.js') }}"></script>

@endsection
