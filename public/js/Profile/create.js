window.onload = function () {
    showAllPhotos();
    getCurrentLocation();
};

// AJAX query to store profiles info

let store = document.getElementById('profileStore')
store.onclick = async function(evt) {
    evt.preventDefault();
    if (!getQuantityOfPhotos()) {
        removePhotoErrors();
        displayError('You must add at least one photo', 'photoErrors');
    } else {
        removeAllChildrenElemFrom('profileErrors');
        let urlStoreProfile = '/profiles';

        let headers = new Headers();
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        headers.append('X-CSRF-TOKEN', token);
        headers.append('Accept', 'application/json');

        let formData = new FormData();
        let name = document.getElementById('name').value;
        let date_of_birth = document.getElementById('date_of_birth').value;
        let description = document.getElementById('description').value;
        let gender = document.querySelector('input[name="gender"]:checked').value;
        let longitude = document.getElementById('longitude').value;
        let latitude = document.getElementById('latitude').value;
        formData.append('name', name);
        formData.append('date_of_birth', date_of_birth);
        formData.append('description', description);
        formData.append('gender', gender);
        formData.append('longitude', longitude);
        formData.append('latitude', latitude);

        let options = {
            method: 'POST',
            headers: headers,
            body: formData
        };

        let profileStoreResponse = await fetch(urlStoreProfile, options);

        if(profileStoreResponse.ok){
            location.href = '/preferences/create';
        } else {
            let profileJsonErrors = await profileStoreResponse.json();
            for(let key in profileJsonErrors.errors){
                let value = profileJsonErrors.errors[key];
                displayError(value, 'profileErrors');
            }
        }
    }
};

// AJAX query to get profiles photos

async function showAllPhotos() {
    let id = document.getElementById("myId").innerHTML;
    let urlShowAllPhotos = "/photos/" + id;

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
        document.getElementById('longitude').value = position.coords.longitude;
        document.getElementById('latitude').value = position.coords.latitude;
    };

    var ipLocation = async function () {
        let urlLocationApi = 'https://ipapi.co/latlong/';

        let getLocationResponse = await fetch(urlLocationApi);

        if (getLocationResponse.ok) {
            let location = await getLocationResponse.text();
            location = location.split(',');
            document.getElementById('latitude').value = location[0];
            document.getElementById('longitude').value = location[1];
        } else {
            console.log("Bad location request");
        }
    };
    navigator.geolocation.getCurrentPosition(geoLocation, ipLocation);
}

function removePhotoErrors() {
    const photoErrorsDiv = document.getElementById("photoErrors");
    while (photoErrorsDiv.firstChild) {
        photoErrorsDiv.removeChild(photoErrorsDiv.firstChild);
    }
}

// AJAX query to store profile photos

async function sendImage() {
    let urlStore = '/photos';

    let headers = new Headers();
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    headers.append('X-CSRF-TOKEN', token);
    headers.append('Accept', 'application/json');

    let formData = new FormData();
    let input = document.querySelector('input[type="file"]');
    formData.append('photos', input.files[0]);

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
        if (photoJsonErrors.hasOwnProperty('errors')) {
            photoJsonErrors.errors.photos.forEach(function (error) {
                displayError(error, 'photoErrors');
            })
        }
    }
}

// AJAX query to delete photos

let gallery = document.getElementById('gallery');
gallery.onclick = function(event){
    let target = event.target;
    if (target.tagName === 'IMG'){
        destroyPhoto(target);
    }
    // console.log(getQuantityOfPhotos());
    if (getQuantityOfPhotos() === 1) {
        let hiddenSpan = document.querySelector('.hidden');
        hiddenSpan.style.display = 'none';
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

    let imageDestroyResponse = await fetch(urlDestroyPhoto, options);

    if (imageDestroyResponse.ok){
        target.remove();
        checkPhotoLimit();
    }
}

// AJAX query to get the last one photos

async function displayLastPhoto() {
    let id = document.getElementById("myId").innerHTML;
    let urlShowLastPhoto = "/photos/last/" + id;
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
    let hiddenSpan = document.querySelector('.hidden');
    photoElem.src = photo.path;
    photoElem.id = photo.id;
    photoElem.width = 150;
    document.getElementById('gallery').append(photoElem);
    hiddenSpan.style.display = 'inline';
}

function removeAllChildrenElemFrom(Div) {
    let div = document.getElementById(Div);
    while (div.firstChild) {
        div.firstChild.remove()
    }
}

function checkPhotoLimit() {
    let photoQuantityLimit = 5;
    if (getQuantityOfPhotos() >= photoQuantityLimit) {
        document.getElementById('photoFormContent').style.display = "none";
    } else {
        document.getElementById('photoFormContent').style.display = "block";
    }
}

function getQuantityOfPhotos() {
    let photosQuantity = document.getElementById('gallery').childElementCount;
    return photosQuantity;
}