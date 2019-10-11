@extends('layouts.app')

@section('title', 'Developers')

@section('content')

  <div class="about-container">
    <div class="container-card about">
      <div class="card" id="card">
      </div>
      <div class="card-body" id="cardBody" style="visibility: visible">
        <div id="carousel" class="carousel" style="height: auto">
          <img src="https://i.imgur.com/Fj1n66U.png" alt="pashok">
        </div>
        <div id="match">
          <div id="likeResponse">It's a Match!</div>
        </div>
        <div id="mainInfo" class="card-info">
          <div>
            <p id="cardName">Pavel</p>
          </div>
          <p id="cardDistance">Moscow</p>
        </div>
      </div>

      <p id="cardDescription" class="about-description">Backend developer</p>
      <p id="cardDescription" style="margin-top: 0; margin-bottom: 2rem;" class="about-description">
          <a href="https://github.com/Tariable" class="btn-link">github.com/Tariable</a>
      </p>

    </div>

    <div class="container-card about">
      <div class="card" id="card">
      </div>
      <div class="card-body" id="cardBody" style="visibility: visible">
        <div id="carousel" class="carousel" style="height: auto">
          <img src="https://i.imgur.com/X1noUMa.jpg" alt="arseny">
        </div>
        <div id="match">
          <div id="likeResponse">It's a Match!</div>
        </div>
        <div id="mainInfo" class="card-info">
          <div>
            <p id="cardName">Arseny</p>
          </div>
          <p id="cardDistance">Moscow</p>
        </div>
      </div>

      <p id="cardDescription" class="about-description">Web master</p>
      <p id="cardDescription" style="margin-top: 0; margin-bottom: 2rem;" class="about-description">
          <a href="https://github.com/baryshkov" class="btn-link">github.com/baryshkov</a>
      </p>

    </div>
    <div class="container-card about">
      <div class="card" id="card">
      </div>
      <div class="card-body" id="cardBody" style="visibility: visible">
        <div id="carousel" class="carousel" style="height: auto">
          <img src="https://i.imgur.com/oDqdVdw.jpg" alt="maxix">
        </div>
        <div id="match">
          <div id="likeResponse">It's a Match!</div>
        </div>
        <div id="mainInfo" class="card-info">
          <div>
            <p id="cardName">Max</p>
          </div>
          <p id="cardDistance">Moscow</p>
        </div>
      </div>

      <p id="cardDescription" class="about-description">Backend developer</p>
      <p id="cardDescription" style="margin-top: 0; " class="about-description">
          <a href="https://github.com/Maksix" class="btn-link">github.com/Maksix</a>
      </p>
    </div>
  </div>

@endsection
