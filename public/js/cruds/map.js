let Gmap, marker, latitude = $('#latitude_form'), longitude = $('#longitude_form');

$('#modals').append(
    '<div class="modal fade" id="m_modal_map" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">' +
    '<div class="modal-dialog modal-lg" role="document">' +
    '<div class="modal-content">' +
    '<div class="modal-header">' +
    '<h5 class="modal-title" id="m_modal_map-title"></h5>' +
    '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>' +
    '</div>' +
    '<div class="modal-body m--align-center"><div id="map"></div></div>' +
    '</div>' +
    '</div>' +
    '</div>'
);

function addMarker(lat, lng) {
    lat = parseFloat(lat);
    lng = parseFloat(lng);

    openMap(lat, lng, '', false);

    marker = new google.maps.Marker({
        map: Gmap,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: {lat: lat, lng: lng}
    });

    marker.addListener('drag', function (e) {
        latitude.val(e.latLng.lat());
        longitude.val(e.latLng.lng());
    });
}

function getMarker() {
    if (latitude.val() !== '' && longitude.val() !== '') {
        addMarker(latitude.val(), longitude.val())
    } else  if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            addMarker(position.coords.latitude, position.coords.longitude);
        }, function () {
            addMarker(0, 0);
        });
    } else {
        alert("Geolocation is not Supported for this browser");
    }
}

function openMap(lat, lng, title = '', drawMarker = true) {
    let position = {lat: parseFloat(lat), lng: parseFloat(lng)};
    if (Gmap === undefined) Gmap = new google.maps.Map(document.getElementById('map'), {zoom: 15});
    if (marker !== undefined) marker.setMap(null);
    if (drawMarker) marker = new google.maps.Marker({position: position, map: Gmap});
    Gmap.getStreetView().setVisible(false);
    Gmap.setMapTypeId('roadmap');
    Gmap.setZoom(15);
    Gmap.setCenter(position);
    latitude.val(lat);
    longitude.val(lng);
    $('#m_modal_map-title').html(title);
    $('#m_modal_map').modal('show');
}