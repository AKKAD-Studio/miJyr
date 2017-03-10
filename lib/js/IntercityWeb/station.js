var editMap; // карта для редактирования
var drawnItems; // слой для редактирования
var isAdded = false;
var stationMarker;

$(document).ready(function () {
});

function dialogShow()
{
	isAdded = false;
	//if(typeof editMap == "undefined" || editMap == null){
		setupEditorMap();
	//}
	if(typeof drawnItems != 'undefinded'){
		drawnItems.clearLayers();
	}
	stationMarker = null;
	setPlacemark();
	$("#dataItemDialogForm\\:txtLon").change(setPlacemark);
	$("#dataItemDialogForm\\:txtLat").change(setPlacemark);
}

function setupEditorMap() {	
    editMap = L.map('divMap').setView([MAP_LAT, MAP_LON], 15);
	var osm = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 18
    }).addTo(editMap);
	    
	    
    var googleRoadMap = new L.Google('ROADMAP');
    var googleSatellite= new L.Google('SATELLITE');
    var googleHybrid = new L.Google('HYBRID');
    var yandex = new L.Yandex();
    var yandexSattelite = new L.Yandex("satellite");
    var yandexHybrid = new L.Yandex("hybrid");
    var yandexPublicMap = new L.Yandex("publicMap");
    var yandexPublicMapHybrid = new L.Yandex("publicMapHybrid");
    
    // var baseMaps = {
        // "OSM": osm,
        // "Google Streets": googleRoadMap,
        // "Google Satellite": googleSatellite,        
        // "Google Hybrid": googleHybrid,    
        // "Yandex": yandex,
        // "Yandex Sattelite": yandexSattelite,
        // "Yandex Hybrid": yandexHybrid,
        // "Yandex Public Map": yandexPublicMap,
        // "Yandex Public Map Hybrid": yandexPublicMapHybrid,
    // };    
    var baseMaps = {
        "OSM": osm, 
        "Yandex": yandex,
        "Yandex Sattelite": yandexSattelite,
        "Yandex Hybrid": yandexHybrid,
        "Yandex Public Map": yandexPublicMap,
        "Yandex Public Map Hybrid": yandexPublicMapHybrid,
    };
    
    L.control.layers(baseMaps).addTo(editMap);

    drawnItems = new L.FeatureGroup();
    editMap.addLayer(drawnItems);

    var drawControl = new L.Control.Draw({
        draw: {
            position: 'topleft',
            polygon: false,
            circle: false,
            marker: true,
            rectangle: false,
            polyline: false
        },
        edit: {
            featureGroup: drawnItems
        }
    });
    editMap.addControl(drawControl);

    editMap.on('draw:created', function (e) {
        layer = e.layer;

        if (!isAdded) {
            drawnItems.addLayer(layer);
            updateValue(layer._latlng.lng, layer._latlng.lat);
            isAdded = true;
        }

        //drawControl.setDrawingOptions({ polyline: { shapeOptions: { color: '#004a80' } } });			
    });

    editMap.on('draw:edited', function (e) {
        var layers = e.layers;
        layers.eachLayer(function (layer) {
        	updateValue(layer._latlng.lng, layer._latlng.lat);
            return false; // only one marker
        });
    });

    editMap.on('draw:deleted', function (e) {
        isAdded = false;
        updateValue("", "");
    });
}

function setPlacemark()
{
	var lon = document.getElementById('dataItemDialogForm:txtLon').value;
	var lat = document.getElementById('dataItemDialogForm:txtLat').value;
	if(lon != "" && lat != "")
	{
		var p = new L.LatLng(lat, lon);
		if (typeof stationMarker == "undefined" || stationMarker == null){
			stationMarker = new L.marker(p);
			drawnItems.addLayer(stationMarker);
		}else{
			stationMarker.setLatLng(p);
			stationMarker.update();
		}
		
		editMap.panTo(p);
		isAdded = true;
	}
}

function updateValue(lon, lat)
{
	document.getElementById('dataItemDialogForm:txtLon').value = lon;
	document.getElementById('dataItemDialogForm:txtLat').value = lat;
}
// ------- end setup map -------