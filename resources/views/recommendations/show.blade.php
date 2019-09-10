@extends('layouts.app')

@section('title', 'Matcha')

@section('content')

  <div class="container-card">
    <div class="row mb-5">
    </div>
    <div class="card">
      <div class="card-body" id="cardBody" hidden>
        <div class="carousel-wrapper">
          <div id="carousel">
          </div>
        </div>
        <div class="carousel__button--next"></div>
        <div class="carousel__button--prev"></div>
        <div id="mainInfo">
          <h1 id="cardName"></h1>
          <h5 id="cardAge"></h5>
        </div>
        <div id="info">
          <p id="cardDistance"></p>
          <p id="cardDescription"></p>
          <p id="cardId" hidden></p>
        </div>
      </div>
    </div>
    <button  class="btn btn-success" id="like" onclick="like()">Like</button>
    <button  class="btn btn-danger" id="ban" onclick="ban()">Dislike</button>
  </div>
  <div class="m-2">
    <h4><a href="/profiles/edit">Edit profile</a></h4>
    <h4><a href="/preferences/edit">Edit preferences</a></h4>
  </div>
  <script>
    let recommendations;
    let iterator;
    let profile;
    let photos;

    window.onload = async function () {
      recommendations = await getRecommendations();
      iterator = 0;
      profile = await getProfile(recommendations[iterator]);
      photos = await getPhotos(recommendations[iterator]);
      showProfile(profile);
      showPhotos(photos);
    };

    async function getRecommendations() {
      let urlGetRecommendations = '/recs/all';

      let getRecommendationsResponse = await fetch(urlGetRecommendations);

      let response = await getRecommendationsResponse.json();

      return response.recommendationsId;
    }

    async function getProfile(id) {
      let urlGetProfile = '/recs/' + id;

      let getProfileResponse = await fetch(urlGetProfile);

      let response = await getProfileResponse.json();

      return response.profileData;
    }

    // AJAX query to get profiles photo

    async function getPhotos(id) {
      let urlShowAllPhotos = '/photos/' + id;

      let showAllPhotosResponse = await fetch(urlShowAllPhotos);

      let photos = await showAllPhotosResponse.json();

      return photos;
    }

    function showPhotos(photos) {
      let gallery = document.getElementById('carousel');
      while (gallery.firstChild){
        gallery.firstChild.remove();
      }

      photos.forEach((photo, i) => createPhotoElem(photo, i));
    }

    function createPhotoElem(photo, i) {
      let photoElem = document.createElement('img');
      console.dir(photoElem);
      photo.path = photo.path.substring(6);
      photoElem.src = photo.path;
      photoElem.id = photo.id;
      photoElem.style.width = '100%';
      photoElem.classList.add('carousel__photo');
      i === 0 ? photoElem.classList.add('initial') : 0;
      document.getElementById('carousel').append(photoElem);
    }

    function showProfile(profile) {
      document.getElementById('cardId').innerHTML = profile['id'];
      document.getElementById('cardName').innerHTML = profile['name'];
      document.getElementById('cardAge').innerHTML = profile['age'];
      document.getElementById('cardDistance').innerHTML = profile['distance'] + ' km from you';
      document.getElementById('cardDescription').innerHTML = profile['desc'];
      document.getElementById('cardBody').removeAttribute('hidden');
    }

    // AJAX query to like account

    async function like() {
      let id = document.getElementById('cardId').innerHTML;
      let urlLike = '/like/' + id;

      let headers = new Headers();
      let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      headers.append('X-CSRF-TOKEN', token);

      let options = {
        method: 'POST',
        headers: headers
      }

      let LikeResponse = await fetch(urlLike, options);

      if (LikeResponse.ok) {
        iterator++;
        profile = await getProfile(recommendations[iterator]);
        photos = await getPhotos(recommendations[iterator]);
        showProfile(profile);
        showPhotos(photos);
      }
    }

    async function ban() {
      let id = document.getElementById('cardId').innerHTML;
      let urlBan = '/ban/' + id;

      let headers = new Headers();
      let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      headers.append('X-CSRF-TOKEN', token);

      let options = {
        method: 'POST',
        headers: headers
      }

      let BanResponse = await fetch(urlBan, options);

      if (BanResponse.ok) {
        iterator++;
        profile = await getProfile(recommendations[iterator]);
        photos = await getPhotos(recommendations[iterator]);
        showProfile(profile);
        showPhotos(photos);
      }
    }
    (function(d){
      let itemClassName = "carousel__photo";
      let items = d.getElementsByClassName(itemClassName);
      let totalItems = items.length;
      let slide = 0;
      let moving = true;

      items[totalItems - 1].classList.add
    }(document));



  </script>


@endsection
