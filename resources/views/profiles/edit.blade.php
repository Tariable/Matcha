@extends('layouts.app')

@section('content')
  <div class="container-create">
    <div class="photoContainer">
      <h2>Your photos</h2>
      <form action="/photos" name="photoForm" id="photoForm" method="post"
            enctype="multipart/form-data">
        <div id="photoFormContent">
          <label id="labelPhotoInput" for="photoInput">Choose a photo</label>
          <input name="photoInput" id="photoInput" onchange="sendImage()" type="file" class="pb-3">
        </div>
      </form>
      <div id="photoErrors"></div>
      <div id="gallery"></div>
      <span class="hidden">Click on a picture to delete</span>
    </div>
    <div class="profileContainer">
      <h2>Your data</h2>
      <form action="/profiles/{{ Auth::id() }}" method="post" novalidate>
        <div class="form-group">
          <input name="name" id="name" type="text" class="form-control"
                 value="{{ old('name') ?? $profile->name }}">
        </div>

        <div class="form-group">
          <label class="m-2" for="date_of_birth">Date of birth</label>
          <input name="date_of_birth" id="date_of_birth" type="date" class="form-control"
                 max="2002-01-01"
                 value="{{ old('date_of_birth') ?? $profile->date_of_birth }}">
        </div>

        <div class="form-group">
          <textarea name="description" id="description" cols="15" rows="8"
                    class="form-control">{{ old('description') ?? $profile->description }}</textarea>
        </div>
        <div class="mb-10">Your gender is:</div>
        <div class="form-group radio">

          <input class="form-radio" id="genderMale" name="gender" type="radio" value="male"
                  {{ $profile->gender == "male" ? 'checked' : '' }} >
          <label for="genderMale">Male</label>
          <input class="form-radio" id="genderFemale" name="gender" type="radio" value="female"
                  {{ $profile->gender == "female" ? 'checked' : '' }} >
          <label for="genderFemale">Female</label>
        </div>

        <div class="form-group check">
          {{--                           TODO: RADIO --> CHECKBOX--}}
          <input class="form-check-input" id="notification" name="notification" type="checkbox"
                  {{ $profile->notification == '1' ? 'checked' : '' }} >
          <label for="notificationOn">Notifications</label>

        </div>

        <div>
          <input type="number" id="current_longitude" name="longitude" hidden>
          <input type="number" id="current_latitude" name="latitude" hidden>
        </div>

        <div class="form-group" id="profileErrors">

        </div>

        <div class="form-group col">
          <div>
          <button class="btn btn-primary m-2" id="profileUpdate" type="submit">Edit profile</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <script>
    let hiddenSpan = document.querySelector('.hidden')
    window.onload = function () {
      showAllPhotos();
      hiddenSpan.style.display = 'block';
      getCurrentLocation();
    };

    // AJAX query to store profiles info

    let update = document.getElementById('profileUpdate');
    update.onclick = async function(evt) {
      evt.preventDefault();
      if (!getQuantityOfPhotos() && !document.getElementById('errors')){
        displayError('You must add at least one photo', 'photoErrors');
      } else {
        removeAllChildrenElemFrom('profileErrors');
        let urlUpdateProfile = '/profiles/{{ Auth::id() }}';

        let headers = new Headers();
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        headers.append('X-CSRF-TOKEN', token);
        headers.append('Accept', 'application/json');

        let formData = new FormData();
        let name = document.getElementById('name').value;
        let date_of_birth = document.getElementById('date_of_birth').value;
        let description = document.getElementById('description').value;
        let gender = document.querySelector('input[name="gender"]:checked').value;
        let notification = document.getElementById('notification');
        notification.hasAttribute('checked') ? notification = '1' : notification = '0';
        console.log(notification);
        let current_longitude = document.getElementById('current_longitude').value;
        let current_latitude = document.getElementById('current_latitude').value;
        formData.append('name', name);
        formData.append('date_of_birth', date_of_birth);
        formData.append('description', description);
        formData.append('gender', gender);
        formData.append('notification', notification);
        formData.append('longitude', current_longitude);
        formData.append('latitude', current_latitude);

        let options = {
          method: 'POST',
          headers: headers,
          body: formData
        };

        let profileStoreResponse = await fetch(urlUpdateProfile, options);

        if(profileStoreResponse.ok){
          location.href = '/recs';
        } else {
          let profileJsonErrors = await profileStoreResponse.json();
          for(let key in profileJsonErrors.errors){
            let value = profileJsonErrors.errors[key];
            displayError(value, 'profileErrors');
          }
        }
      }
    };

    // AJAX query to get profiles photo

    async function showAllPhotos() {
      let urlShowAllPhotos = "/photos/{{ Auth::id() }}";

      let showAllPhotosResponse = await fetch(urlShowAllPhotos);

      let photos = await showAllPhotosResponse.json();

      photos.forEach(function (photo) {
        createPhotoElem(photo);
      });
      checkPhotoLimit();
    }

    // Getting current location coordinates

    function getCurrentLocation() {
      var geoLocation = function (position) {
        document.getElementById('current_longitude').value = position.coords.longitude;
        document.getElementById('current_latitude').value = position.coords.latitude;
      };

      var ipLocation = async function () {
        let urlLocationApi = 'https://ipapi.co/latlong/';

        let getLocationResponse = await fetch(urlLocationApi);

        if (getLocationResponse.ok) {
          let location = await getLocationResponse.text();
          location = location.split(',');
          document.getElementById('current_latitude').value = location[0];
          document.getElementById('current_longitude').value = location[1];
        } else {
          console.log("Bad location request");
        }
      };
      navigator.geolocation.getCurrentPosition(geoLocation, ipLocation);
    }

    // AJAX query to store profile photo

    async function sendImage() {
      let urlStore = '/photos';

      let headers = new Headers();
      let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      headers.append('X-CSRF-TOKEN', token);
      headers.append('Accept', 'application/json');

      let formData = new FormData();
      let input = document.querySelector('input[type="file"]');
      formData.append('photo', input.files[0]);

      let options = {
        method: 'POST',
        headers: headers,
        body: formData
      }

      let imageStoreResponse = await fetch(urlStore, options);

      input.value = '';
      if (imageStoreResponse.ok) {
        removeAllChildrenElemFrom("photoErrors");
        displayLastPhoto();
      } else {
        let photoJsonErrors = await imageStoreResponse.json();
        removeAllChildrenElemFrom("photoErrors");
        photoJsonErrors.errors.photo.forEach(function (error) {
          displayError(error, 'photoErrors');
        })
      }
    }

    // AJAX query to delete photo

    let gallery = document.getElementById('gallery');
    gallery.onclick = function(event){
      let target = event.target;
      if (target.tagName === 'IMG'){
        destroyPhoto(target);
      }
    }

    async function destroyPhoto(target){
      let urlDestroyPhoto = '/photos/' + target.id;

      let headers = new Headers();
      let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      headers.append('X-CSRF-TOKEN', token);
      headers.append('Accept', 'application/json');

      let options = {
        method: 'DELETE',
        headers : headers,
      }

      let imageDestroyResponse = await fetch(urlDestroyPhoto, options)

      if (imageDestroyResponse.ok){
        target.remove();
        checkPhotoLimit();
      }
    }

    // AJAX query to get the last one photo

    async function displayLastPhoto() {
      let urlShowLastPhoto = "/photos/last/{{ Auth::id() }}";

      let showLastPhotoResponse = await fetch(urlShowLastPhoto);

      let photo = await showLastPhotoResponse.json();

      createPhotoElem(photo);
      checkPhotoLimit();
    }

    function displayError(textOfError, typeOfError){
      if (!document.getElementById('errors')){
        let errorDiv = document.createElement('div');
        errorDiv.setAttribute('class', 'alert alert-danger');
        errorDiv.setAttribute('id', 'errors');
        document.getElementById(typeOfError).append(errorDiv);
      }
      let error = document.createElement('p');
      error.innerHTML = textOfError;
      document.getElementById('errors').append(error);
    }


    function createPhotoElem(photo){
      let photoElem = document.createElement('img');
      photo.path = photo.path.substring(6);
      photoElem.src = photo.path;
      photoElem.id = photo.id;
      photoElem.width = 150;
      document.getElementById('gallery').append(photoElem);
    }

    function removeAllChildrenElemFrom(Div) {
      let div = document.getElementById(Div);
      while (div.firstChild) {
        div.firstChild.remove()
      }
    }

    function checkPhotoLimit() {
      if (getQuantityOfPhotos() >= 5) {
        document.getElementById('photoForm').hidden = true;
      } else {
        document.getElementById('photoForm').hidden = false;
      }
    }

    function getQuantityOfPhotos() {
      let photosQuantity = document.getElementById('gallery').childElementCount;
      return photosQuantity;
    }
  </script>
  </div>
  </div>
@endsection
