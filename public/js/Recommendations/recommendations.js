let recommendations;
let iterator;
let profile;
let photos;
let pref;

window.onload = async function () {
    recommendations = await getRecommendations();
    iterator = 0;

    if (recommendations[iterator]) {
        [profile, photos] =
            await Promise.all([
                getProfile(recommendations[iterator]),
                getPhotos(recommendations[iterator])
            ]);

        displayProfile(profile, photos);
        pref = await getMyPref();
    } else {
        createSuggestion('Edit preferences to get more', 'redirectToEditPref');
    }
};

async function getMyPref() {
    try {
        let urlGetMyPref = '/preferences';
        let getPrefResponse = await fetch(urlGetMyPref);
        let response = await getPrefResponse.json();

        return response.pref;
    } catch (e) {
        console.log(e);
    }
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

// AJAX query to get profiles photos

async function getPhotos(id) {
    let urlShowAllPhotos = '/photos/' + id;
    let showAllPhotosResponse = await fetch(urlShowAllPhotos);
    let photos = await showAllPhotosResponse.json();

    return photos;
}

function displayProfile(profile, photos) {
    showPhotos(photos);
    showProfile(profile);
    carousel(document);
}

function showPhotos(photos) {
    let gallery = document.getElementById('carousel');
    while (gallery.firstChild) {
        gallery.firstChild.remove();
    }

    photos.forEach((photo, i) => createPhotoElem(photo, i));
}

function createPhotoElem(photo, i) {
    let photoElem = document.createElement('img');
    photoElem.src = photo.path;
    photoElem.id = photo.id;
    document.getElementById('carousel').append(photoElem);
}

function showProfile(profile) {
    document.querySelector('.lds-heart').style.display = 'none';
    document.querySelector('.buttons').style.visibility = 'visible'
    document.getElementById('cardId').innerHTML = profile['id'];
    document.getElementById('cardName').innerHTML = `${profile['name']}, ${profile['age']}`;
    document.getElementById('cardDistance').innerHTML = profile['distance'] + ' km from you';
    document.getElementById('cardDescription').innerHTML = profile['desc'];
    document.getElementById('cardBody').style.visibility = 'visible';
}

// AJAX query to like account

async function like() {
    let match = document.getElementById('likeResponse');
    const matchContainer = document.getElementById('match');
    let id = document.getElementById('cardId').innerHTML;
    let urlLike = '/like/' + id;

    let headers = new Headers();
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    headers.append('X-CSRF-TOKEN', token);

    let options = {
        method: 'POST',
        headers: headers
    };

    let LikeResponse = await fetch(urlLike, options);
    let response = await LikeResponse.json();

    if (LikeResponse.ok) {
        if (response === 'It\'s a match') {
            match.innerText = 'IT\'S A MATCH';
            matchContainer.style.visibility = 'visible';
        }
        iterator++;
        if (recommendations[iterator]) {
            profile = await getProfile(recommendations[iterator]);
            photos = await getPhotos(recommendations[iterator]);
            displayProfile(profile, photos);
            match.innerText = '';
            matchContainer.style.visibility = 'hidden';
        } else {
            createSuggestion('You can expand selection criteria', 'expandPref');
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
    };

    let BanResponse = await fetch(urlBan, options);

    if (BanResponse.ok) {
        iterator++;
        if (recommendations[iterator]) {
            profile = await getProfile(recommendations[iterator]);
            photos = await getPhotos(recommendations[iterator]);
            displayProfile(profile, photos);
        } else {
            createSuggestion('You can expand selection criteria', 'expandPref');
        }
    }
}

function createSuggestion(text, onclick) {
    document.getElementById('card').style.display = "none";
    let expandButton = document.createElement('button');
    expandButton.setAttribute('class', 'btn btn-danger');
    expandButton.setAttribute('id', 'expandButton');
    expandButton.setAttribute('onclick', onclick + '()');
    expandButton.innerHTML = text;
    document.getElementById('expandDiv').append(expandButton);
}

async function expandPref() {
    if (pref.distance <= 90 || pref.upperAge <= 98 || pref.lowerAge >= 20) {
        if (pref.distance + 10 <= 100)
            pref.distance += 10;
        if (pref.lowerAge - 2 >= 18)
            pref.lowerAge -= 2;
        if (pref.upperAge + 2 <= 100)
            pref.upperAge += 2;

        let urlUpdatePref = '/preferences/update';

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
        };

        let preferencesUpdateResponse = await fetch(urlUpdatePref, options);

        if (preferencesUpdateResponse.ok) {
            location.href = '/recs';
        }

    } else {
        document.getElementById('expandButton').hidden = true;
        let cantExpand = document.createElement('h3');
        cantExpand.innerHTML = 'Sorry, we cant expand you preferences';
        document.getElementById('expandDiv').append(cantExpand);
    }
}

function sleep(miliseconds) {
    var currentTime = new Date().getTime();

    while (currentTime + miliseconds >= new Date().getTime()) {
    }
}

function redirectToEditPref() {
    location.href = '/preferences/edit';
}

function carousel(d) {
    'use strict';
    const _C = d.querySelector('.carousel');
    const _CI = d.querySelector('.carousel img');
    let totalImages = _C.children.length;
    document.documentElement.style.setProperty('--n', 0);
    document.documentElement.style.setProperty('--n', `${totalImages}`);
    _C.style.setProperty('--i', 0);

    let x0 = null;

    function lock(e) {
        x0 = unify(e).clientX;
    }

    let i = 0;

    function move(e) {
        let totalImages = _C.children.length;
        if ((x0 || x0 === 0) && totalImages !== 1) {
            let dx = unify(e).clientX - x0;
            let sign = Math.sign(dx);
            if ((i > 0 || sign < 0) && (i < totalImages - 1 || sign > 0)) {
                i -= sign;
                _C.style.setProperty('--i', (totalImages * i));
                _C.style.setProperty('--tx', '0px');
            }
            x0 = null;
        }
    }

    function unify(e) {
        return e.changedTouches ? e.changedTouches[0] : e;
    }

    _C.addEventListener('mousedown', lock, false);
    _C.addEventListener('touchstart', lock, false);

    _C.addEventListener('mouseup', move, false);
    _C.addEventListener('touchend', move, false);
}
