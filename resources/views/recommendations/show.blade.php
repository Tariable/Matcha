@extends('layouts.app')

@section('title', 'Matcha')

@section('content')
    <div class="m-2">
        <h4><a href="/profiles/edit">Edit profile</a></h4>
        <h4><a href="/preferences/edit">Edit preferences</a></h4>
    </div>


    <div class="container my-3 py-5 text-center">
        <div class="row mb-5">

        </div>
        <button  class="btn btn-success" id="like" onclick="like()" style="float:right">Like</button>
        <button  class="btn btn-danger" id="ban" onclick="ban()" style="float:left">Dislike</button>
        <div class="card">
            <div class="card-body" id="cardBody" hidden>
                <div id="mainInfo">
                    <h1 id="name"></h1>
                    <h5 id="age"></h5>
                </div>

                <div id="gallery">

                </div>

                <div id="info">
                    <p id="distance"></p>
                    <p id="description"></p>
                    <p>Common tags:

                    </p>
                </div>
            </div>
        </div>

    </div>
    <script>
        let recommendation;

        window.onload = async function () {
            recommendations = await getRecommendations();
            let profileNum = 0;
            let profile = await getProfile(recommendations[profileNum]);
            let photos = await getPhotos(recommendations[profileNum]);
            showProfile(profile, photos);
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

            photos.forEach(function (photo) {
                createPhotoElem(photo);
            });
        }

        function createPhotoElem(photo){
            let photoElem = document.createElement('img');
            photo.path = photo.path.substring(6);
            photoElem.src = photo.path;
            photoElem.id = photo.id;
            photoElem.width = 150;
            document.getElementById('gallery').append(photoElem);
        }

        function showProfile(profile, photos) {
            let id = document.createElement('span');
            id.innerHTML = profile['id'];
            id.hidden = true;

            document.getElementById('cardBody').append(id);
            document.getElementById('name').innerHTML = profile['name'];
            document.getElementById('age').innerHTML = profile['age'];
            document.getElementById('distance').innerHTML = profile['distance'] + ' km from you';
            document.getElementById('description').innerHTML = profile['desc'];
            document.getElementById('cardBody').removeAttribute('hidden');
        }

        // AJAX query to like account

        async function like() {
            let id = document.getElementById('id');
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
                console.log(recommendation);
            }
        }

        async function ban() {

        }



    </script>

@endsection
