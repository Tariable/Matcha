let store = document.getElementById('storePref');
store.onclick = async function (evt) {
    evt.preventDefault();
    let urlStorePref = '/preferences';

    let headers = new Headers();
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    headers.append('X-CSRF-TOKEN', token);
    headers.append('Accept', 'application/json');

    let formData = new FormData();
    let lowerAge = document.getElementById('lowerAgeInput').value;
    let upperAge = document.getElementById('upperAgeInput').value;
    let distance = document.getElementById('distanceInput').value;
    let sex = document.querySelector('input[name="sex"]:checked').value;

    formData.append('lowerAge', lowerAge);
    formData.append('upperAge', upperAge);
    formData.append('distance', distance);
    formData.append('sex', sex);

    let options = {
        method: 'POST',
        headers: headers,
        body: formData
    };

    let updatePrefResponse = await fetch(urlStorePref, options);

    if (updatePrefResponse.ok) {
        location.href = '/recs';
    } else {
        let prefJsonErrors = await updatePrefResponse.json();
        for (let key in prefJsonErrors.errors) {
            let value = prefJsonErrors.errors[key];
            displayError(value, 'prefErrors');
        }
    }
};

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

$("#ageSlider").ionRangeSlider({
    type: "int",
    skin: "round",
    min: 18,
    max: 100,
    from: 20,
    min_interval: 3,
    to: 28,
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
    from: 20,
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
