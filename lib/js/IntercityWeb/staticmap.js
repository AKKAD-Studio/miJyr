var MONITORING_SERVICE_URL = "../rs/staticmap/";
var DEFAULT_ZOOM = 15;

var map;
var parameterToServiceMap = {"busId": "bus", "routeId": "route", "stationId": "station", "geozoneId": "geozone", "webNotificationId": "webNotification"};

$(document).ready(function () {
	initMap();
	readRequestParams();
	
	if($.url().param("lon") && $.url().param("lat"))
		drawMarker($.url().param("lon"), $.url().param("lat"));
});


function drawMarker(lon, lat)
{
	var i = L.icon({
	    iconUrl: '../img/marker_red.png',
	    iconSize: [20, 34],
	    iconAnchor: [10, 34]
	});
	
	var marker = L.marker([lat, lon], {icon:i, title: lat + " " + lon});
	marker.addTo(map);
	map.setView(new L.LatLng(lat, lon), DEFAULT_ZOOM);
}


function initMap() {	
	if(!isUndefined(map)){
		map._container._leaflet = false;
	}
	
	map = L.map('map').setView([MAP_LAT, MAP_LON], 4);
	var osm = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 18
    }).addTo(map);
	    
	    
    var googleRoadMap = new L.Google('ROADMAP');
    var googleSatellite= new L.Google('SATELLITE');
    var googleHybrid = new L.Google('HYBRID');
    var yandex = new L.Yandex();
    var yandexSattelite = new L.Yandex("satellite");
    var yandexHybrid = new L.Yandex("hybrid");
    var yandexPublicMap = new L.Yandex("publicMap");
    var yandexPublicMapHybrid = new L.Yandex("publicMapHybrid");
    
    var baseMaps = {
        "OSM": osm,
        "Google Streets": googleRoadMap,
        "Google Satellite": googleSatellite,        
        "Google Hybrid": googleHybrid,    
        "Yandex": yandex,
        "Yandex Sattelite": yandexSattelite,
        "Yandex Hybrid": yandexHybrid,
        "Yandex Public Map": yandexPublicMap,
        "Yandex Public Map Hybrid": yandexPublicMapHybrid,
    };
    
    L.control.layers(baseMaps).addTo(map);
}

function readRequestParams(){
	var params = $.url().param(); 
	console.log(params);
	for(var key in params){
		if(key=="lon" || key=="lat")
			continue;
		v = params[key];
		
		if(v instanceof Array){
			for(var i=0; i<v.length; i++){
				console.log(key + ": " + v[i]);
				load(key, v[i]);
			}  
		}else{
			console.log(key + ": " + v);
			load(key, v);
		}
	}
}

function load(parameterKey, parameterValue){
	$.ajax({
		url: MONITORING_SERVICE_URL + parameterToServiceMap[parameterKey] , 
		type: "GET",
		data: {"id": parameterValue},
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function (data) {				
			console.log(data);
			drawObject(parameterToServiceMap[parameterKey], data);
		}
});
}

function drawObject(type, data){
	if(type == "bus"){
		drawBus(data);
	}else if(type == "route"){
		drawRoute(data);
	}else if(type == "station"){
		drawStation(data);
	}else if(type == "geozone"){
		drawGeozone(data);
	}else if(type == "webNotification"){
		drawWebNotification(data);
	}
}

function drawRoute(route){
	var stationsInRoutes = {};
	route.routePaths.sort(function(a, b){
    	if(a.sortOrder>b.sortOrder) return 1;
    	if(a.sortOrder<b.sortOrder) return -1;
    	return 0;
    });
	var pointList = Array();
	$.each(route.routePaths, function(rpIndex, rp){
		pointList.push.apply(pointList, convertFromStringToLatLngs(rp.stationPair.geometry));
		if(!(rp.stationPair.beginStation.id in stationsInRoutes)){
			stationsInRoutes[rp.stationPair.beginStation.id] = rp.stationPair.beginStation;
		}
		
		if(!(rp.stationPair.endStation.id in stationsInRoutes)){
			stationsInRoutes[rp.stationPair.endStation.id] = rp.stationPair.endStation;
		}
	});
	
	if (pointList.length != 0) {			
        var routePolyline = new L.Polyline(pointList, {
            color: '#'+route.trackColor,
            weight: 3,
            opacity: 0.5,
            smoothFactor: 1
        });
        routePolyline.bindPopup("<div><h3>"+route.name+"</h3><p>"+getEmptyStringIfNull(route.description)+"</p></div>");
        map.addLayer(routePolyline);
        //map.fitBounds(routePolyline.getBounds());	        
    }
	var markerList = Array();
    for(var stationId in stationsInRoutes){
    	var item = stationsInRoutes[stationId];
        markerList.push(L.marker([item.lat, item.lon], { title: item.name }));
    }

    map.addLayer(L.layerGroup(markerList));
}

function drawBus(b){
	var myIcon = L.icon({
	    iconUrl: '../img/navigation_arrow.png',
	    iconRetinaUrl: '../img/navigation_arrow.png',
	    iconSize: [32, 34],
	    iconAnchor: [16, 0],
	    popupAnchor: [-16, -17]
	});
	
	
	var marker = L.marker([b.lat, b.lng], {title:b.name, icon: myIcon, iconAngle: b.course});
	
	
	var lmt = new Date(parseInt(b.lastMessageTime));
	var popupContent = "<div><h3>"+b.name+
		"</h3><p>IMEI: <strong>"+b.imei+
		"</strong></p><p>Местоположение (широта долгота): <strong>"+b.lat+" "+b.lng+
		"</strong></p><p>Скорость: <strong>"+b.speed+" км/час"+
		"</strong></p><p>Направление: <strong>"+b.course+
		"</strong></p><p>Дата и время фиксации местоположения: <strong>"+lmt.toLocaleDateString()+" "+lmt.toLocaleTimeString()+
		"</strong></p><p>Признак передачи сигнала бедствия: <strong>"+getEmptyStringIfNull(b.alarmButtonInput)+"</strong></p></div>";
	marker.bindPopup(popupContent);		
	marker.addTo(map);	
}

function drawStation(station){
	L.marker([station.lat, station.lon], { title: station.name }).addTo(map);
}

function drawGeozone(geozone){
	var latlngs = convertFromStringToLatLngs(geozone.geometry);		
	var polygon = new L.Polygon(latlngs);
	polygon.bindPopup("<div><h3>"+geozone.name+"</h3></div>");
	polygon.addTo(map);
}

function drawWebNotification(wn){
	var marker = L.marker([wn.lat, wn.lon], { title: "Уведомление" });
	marker.bindPopup("<div><p>"+wn.notificationText+"</p></div>");
	marker.addTo(map);
}

function isUndefined(p){
	if(typeof p === "undefined" || p === null){
		return true;
	}
	return false;
}

function IsNullOrEmpty(value)
{
    return (value == null || value === "");
}
function IsNullOrWhiteSpace(value)
{
    return (value == null || !/\S/.test(value));
}



function clearMap() {    
    for (var i in map._layers) {
        if (map._layers[i]._path != undefined) {
            map.removeLayer(map._layers[i]);
        }
    }
}


function getEmptyStringIfNull(value){
	if(typeof value == "undefined" || value == null){
		return "";
	}
	return value;
}


function convertFromLatLngsToSting(latlngs){
	var str = "";
	for(var i=0; i<latlngs.length; i++){
		str += latlngs[i].lng + " " + latlngs[i].lat;
		if(i + 1 < latlngs.length){
			str += ", ";
		}
	}
	
	return str;
}

function convertFromStringToLatLngs(latlngsString){
	var latlngs = new Array();
	var points = latlngsString.split(",");
	for(var i=0; i<points.length; i++){
		
		var pa = points[i].trim().split(" ");
		latlngs.push(new L.LatLng(pa[1].trim(), pa[0].trim()));
	}
	return latlngs;
}

