$(document).ready(function () {
    if (navigator.geolocation) {
        console.log('Geolocation is supported!');
    }
    else {
        console.log('Geolocation is not supported for this Browser/OS.');
    }

    window.onload = function() {
        var startPos;
        var geoSuccess = function(position) {
            startPos = position;
            document.getElementById('startLat').innerHTML = startPos.coords.latitude;
            document.getElementById('startLon').innerHTML = startPos.coords.longitude;
        };
        navigator.geolocation.getCurrentPosition(geoSuccess);
        console.log(geoSuccess);
    };
});

