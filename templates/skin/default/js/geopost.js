String.prototype.hashCode = function(){
    var hash = 0;
    if (this.length == 0) return hash;
    for (i = 0; i < this.length; i++) {
        char = this.charCodeAt(i);
        hash = ((hash<<5)-hash)+char;
        hash = hash & hash; // Convert to 32bit integer
    }
    return hash;
}

$(document).ready(function () {
    var mapContainer = $('#map_edit');
    if (!mapContainer.length) {
        return false;
    }

    var location = getViewData();
    var lat = location[0];
    var long = location[1];
    var defaultPos = false;

    if (!lat || !long) {
        defaultPos = true;
        lat = 0;
        long = 0;
    }

    var marksLayer = L.layerGroup();
    var map = L.map('map_edit', { layers: [marksLayer]}).setView([lat, long], 7);

    L.tileLayer(tileProvider, {
        attribution: mapCopyright
    }).addTo(map);

    if (defaultPos) {
        map.locate({setView: true, watch: false});
    }

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


$(document).ready(function () {
    var cache = {};
    var mapContainer = $('#map');
    if (!mapContainer.length) {
        return false;
    }

    var marksLayer = L.layerGroup();
    var map = L.map('map', { layers: [marksLayer], zoom: 10}).setView([0, 0], 7);

    L.tileLayer(tileProvider, {
        attribution: mapCopyright
    }).addTo(map);
    map.locate({setView: true, watch: false});

    map.on('dragend', function(e) {
        var pointLT = map.getBounds().getNorthWest();
        var pointRB = map.getBounds().getSouthEast();
        getMarks(pointLT.lat, pointLT.lng, pointRB.lat, pointRB.lng);
    }).on('zoomend', function(e) {
        var pointLT = map.getBounds().getNorthWest();
        var pointRB = map.getBounds().getSouthEast();
        getMarks(pointLT.lat, pointLT.lng, pointRB.lat, pointRB.lng);
    });

    var markers = L.markerClusterGroup({ spiderfyOnMaxZoom: false, showCoverageOnHover: false, zoomToBoundsOnClick: false });
    map.addLayer(markers);

    function getMarks(x1,y1,x2,y2) {
        $.ajax({
            url: aRouter.ajax +"map",
            method: 'post',
            data: {x1: x1, y1: y1, x2: x2, y2: y2, security_ls_key: LIVESTREET_SECURITY_KEY}
        }).success(function(result) {
            if (result.data) {
                //marksLayer.res
                for (var i = 0; i < result.data.length; i++) {
                    setMarker(result.data[i]);
                }
            }
        });
    }

    function setMarker(data) {
        if (cache[data.t_id] != undefined) {
            return;
        }
        cache[data.t_id] = true;
        var name = data.name;
        var size = 20;
        if (name.length > size) {
            name = data.name.substr(0, size) + '...'
        }

        var marker = L.marker(data.gps, {
            draggable : false,
            clickable : true
        }).bindPopup(
            '<a href="' + data.url + '">' + name + '</a>'
        );

        markers.addLayer(marker);
    }
});

