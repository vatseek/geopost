$(document).ready(function () {
    var mapContainer = $('#map');
    if (!mapContainer.length) {
        return false;
    }

    var location = getViewData();

    console.log(location);

    var lat = location[0];
    var long = location[1];
    var defaultPos = false;

    if (!lat || !long) {
        defaultPos = true;
        lat = 0;
        long = 0;
    }

    var marksLayer = L.layerGroup();
    var map = L.map('map', { layers: [marksLayer]}).setView([lat, long], 7);

    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a>'
    }).addTo(map);

    if (defaultPos) {
        map.locate({setView: true, watch: true});
    }

    //map.on('dragend', function(e) {
    //
    //});
    //
    //map.on('zoomend', function(e) {
    //
    //});

    var marker = false;
    if (!defaultPos) {
        map.setView([lat, long]);
        setMarker([lat, long]);
    } else {
        map.on('locationfound', function () {
            var location = map.getBounds().getCenter();
            setMarker([location.lat, location.lng]);
            setViewData([location.lat, location.lng]);
        }).on('locationerror', function () {
            setMarker([0, 0]);
            setViewData([0, 0]);
        });
    }

    function setMarker(positionLanLong) {
        marker = L.marker(positionLanLong, {
            draggable : true,
            clickable : true
        }).addTo(marksLayer);

        marker.on('dragend', function(e){
            var location = marker.getLatLng();
            setViewData([location.lat, location.lng]);
        });
    }

    function setViewData(latLong) {
        var lat = $('#map_form_container input[name="lat"]');
        var lon = $('#map_form_container input[name="long"]');
        lat.val(latLong[0]);
        lon.val(latLong[1]);
    }

    function getViewData() {
        return [
            parseFloat($('#map_form_container input[name="lat"]').val().replace(',','.')),
            parseFloat($('#map_form_container input[name="long"]').val().replace(',','.'))
        ];
    }
});
