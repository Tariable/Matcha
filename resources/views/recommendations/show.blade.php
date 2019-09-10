@extends('layouts.app')

@section('title', 'Matcha')

@section('content')

  <div class="container-card">
    <div class="row mb-5">
    </div>
    <div class="card" id="card">
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
        <button  class="btn btn-success" id="like" onclick="like()">Like</button>
        <button  class="btn btn-danger" id="ban" onclick="ban()">Dislike</button>
    </div>

  </div>
  <div class="m-2">
    <h4><a href="/profiles/edit">Edit profile</a></h4>
    <h4><a href="/preferences/edit">Edit preferences</a></h4>
  </div>
  <div id="expandDiv">

  </div>
  <script>
    let recommendations;
    let iterator;
    let profile;
    let photos;

        window.onload = async function () {
            recommendations = await getRecommendations();
            iterator = 0;
            pref = await getMyPref();
            if(recommendations[iterator]){
                profile = await getProfile(recommendations[iterator]);
                photos = await getPhotos(recommendations[iterator]);
                displayProfile(profile, photos);
            } else {
                alert('pull is empty');
            }
        };

        async function getMyPref(){
            let urlGetMyPref = '/preferences';

            let getPrefResponse = await fetch(urlGetMyPref);

            let response = await getPrefResponse.json();

            return response.pref;
        }

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

        function displayProfile(profile, photos) {
            showPhotos(photos);
            showProfile(profile);
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
                if (recommendations[iterator]){
                    profile = await getProfile(recommendations[iterator]);
                    photos = await getPhotos(recommendations[iterator]);
                    displayProfile(profile, photos);
                } else {
                    createSuggestionToExpandPref();
                }
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
                if (recommendations[iterator]){
                    profile = await getProfile(recommendations[iterator]);
                    photos = await getPhotos(recommendations[iterator]);
                    displayProfile(profile, photos);
                } else {
                    createSuggestionToExpandPref();
                }
            }
        }

        function createSuggestionToExpandPref() {
            document.getElementById('card').style.display = "none";
            let expandButton = document.createElement('button');
            expandButton.setAttribute('class', 'btn btn-danger');
            expandButton.setAttribute('id', 'expandButton');
            expandButton.setAttribute('onclick', 'expandPref()');
            expandButton.innerHTML = 'You can expand selection criteria';
            document.getElementById('expandDiv').append(expandButton);
        }

        async function expandPref() {
            if (pref.distance <= 90 || pref.upperAge <= 98 || pref.lowerAge >= 20) {
                if (pref.distance + 10 <= 100)
                    pref.distance += 10;
                if(pref.lowerAge - 2 >= 18)
                    pref.lowerAge -= 2;
                if (pref.upperAge + 2 <= 100)
                    pref.upperAge += 2;

                let urlUpdatePref = '/preferences/{{ Auth::id() }}';

                let headers = new Headers();
                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                headers.append('X-CSRF-TOKEN', token);

                let formData = new FormData();
                formData.append('lowerAge', pref.lowerAge);
                formData.append('upperAge', pref.upperAge);
                formData.append('distance', pref.distance);
                formData.append('sex', pref.sex);

                let options = {
                    method: 'POST',
                    headers: headers,
                    body: formData
                }

                let preferencesUpdateResponse = await fetch (urlUpdatePref, options);

                if (preferencesUpdateResponse.ok){
                    location.href = '/recs';
                }

            } else {
                document.getElementById('expandButton').hidden = true;
                let cantExpand = document.createElement('h3');
                cantExpand.innerHTML = 'Sorry, we cant expand you preferences';
                document.getElementById('expandDiv').append(cantExpand);
            }
        }

        (function(d){
            let itemClassName = "carousel__photo";
            let items = d.getElementsByClassName(itemClassName);
            let totalItems = items.length;
            let slide = 0;
            let moving = true;

            // items[totalItems - 1].classList.add
        }(document));

    </script>


@endsection
