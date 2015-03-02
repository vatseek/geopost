function laterFromData(data) {
    return L.tileLayer(data.link, data.attributes);
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

    var defaultLayer = false;
    var baseLayers = { };
    for (var item in tileLayerProviders) {
        var layer = laterFromData(tileLayerProviders[item]);
        baseLayers[tileLayerProviders[item].name] = layer;
        if (!defaultLayer) {
            defaultLayer = layer;
        }

        if ($.cookie('map-layer-selected') == tileLayerProviders[item].name) {
            defaultLayer = layer;
        }
    }

    var marksLayer = L.layerGroup();
    var map = L.map('map_edit', { layers: [defaultLayer, marksLayer]}).setView([lat, long], 7);

    L.control.layers(baseLayers).addTo(map);

    if (defaultPos) {
        map.locate({setView: true, watch: false});
    }

    map.on('baselayerchange', function(e) {
        $.cookie('map-layer-selected', e.name);
    });

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

    var defaultLayer = false;
    var baseLayers = { };
    for (var item in tileLayerProviders) {
        var layer = laterFromData(tileLayerProviders[item]);
        baseLayers[tileLayerProviders[item].name] = layer;
        if (!defaultLayer) {
            defaultLayer = layer;
        }

        if ($.cookie('map-layer-selected') == tileLayerProviders[item].name) {
            defaultLayer = layer;
        }
    }

    var marksLayer = L.layerGroup();
    var map = L.map('map', { layers: [defaultLayer, marksLayer], zoom: 10, minZoom: 7 }).setView([0, 0], 7);

    L.control.layers(baseLayers).addTo(map);
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

    map.on('baselayerchange', function(e) {
        $.cookie('map-layer-selected', e.name);
    });

    function getMarks(x1,y1,x2,y2) {
        $.ajax({
            url: aRouter.ajax +"map",
            method: 'post',
            data: {x1: x1, y1: y1, x2: x2, y2: y2, security_ls_key: LIVESTREET_SECURITY_KEY}
        }).success(function(result) {
            if (result.data) {
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

