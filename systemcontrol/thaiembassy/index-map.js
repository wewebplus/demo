function initAutocomplete() {
		var latitude = parseFloat($("#latitude").val());
		var longitude = parseFloat($("#longitude").val());
		const map = new google.maps.Map(document.getElementById("map"), {
			center: { lat: latitude, lng: longitude },
			zoom: 13,
			mapTypeId: "roadmap"
		});

const geocoder = new google.maps.Geocoder();
const infowindow = new google.maps.InfoWindow();
geocodeLatLng(geocoder, map, infowindow,latitude,longitude);
// Create the search box and link it to the UI element.
const input = document.getElementById("pac-input");
const searchBox = new google.maps.places.SearchBox(input);

//map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
// Bias the SearchBox results towards current map's viewport.
map.addListener("bounds_changed", () => {

searchBox.setBounds(map.getBounds());
});

let markers = [];

// [START maps_places_searchbox_getplaces]
// Listen for the event fired when the user selects a prediction and retrieve
// more details for that place.
searchBox.addListener("places_changed", () => {
const places = searchBox.getPlaces();
if (places.length == 0) {
	return;
}

// Clear out the old markers.
markers.forEach((marker) => {
	marker.setMap(null);
});
markers = [];

// For each place, get the icon, name and location.
const bounds = new google.maps.LatLngBounds();



places.forEach((place) => {
	if (!place.geometry || !place.geometry.location) {
		console.log("Returned place contains no geometry");
		return;
	}

		var lat= place.geometry.location.lat();
		var lng= place.geometry.location.lng()
		$("#latitude").val(lat);
		$("#longitude").val(lng);

	const icon = {
		url: place.icon,
		size: new google.maps.Size(71, 71),
		origin: new google.maps.Point(0, 0),
		anchor: new google.maps.Point(17, 34),
		scaledSize: new google.maps.Size(25, 25),
	};

	// Create a marker for each place.
	markers.push(
		new google.maps.Marker({
			map,
			icon,
			title: place.name,
			position: place.geometry.location,
		})
	);

	if (place.geometry.viewport) {
		// Only geocodes have viewport.
		bounds.union(place.geometry.viewport);
	} else {
		bounds.extend(place.geometry.location);
	}
});
map.fitBounds(bounds);

});
// [END maps_places_searchbox_getplaces]
}
// [END maps_places_searchbox]
$(document).ready(function(){
$('body').on('keyup', '#latitude, #longitude', function(){
		var lat = parseFloat($('#latitude').val());
		var lng = parseFloat($('#longitude').val());
		if(lng && lat){
				const map = new google.maps.Map(document.getElementById("map"), {
								 center: { lat: lat, lng: lng },
								 zoom: 13,
								 mapTypeId: "roadmap",
				 });
				 const uluru = { lat: lat, lng: lng };
				 const marker = new google.maps.Marker({
						position: uluru,
						map: map
				});

				const geocoder = new google.maps.Geocoder();
				const infowindow = new google.maps.InfoWindow();
				geocodeLatLng(geocoder, map, infowindow,lat,lng);
		}
});

});


function geocodeLatLng(geocoder, map, infowindow,lat,lng) {
const latlng = {
lat: parseFloat(lat),
lng: parseFloat(lng)
};

geocoder
.geocode({ location: latlng })
.then((response) => {
	if (response.results[0]) {
		map.setZoom(11);
		const marker = new google.maps.Marker({
			position: latlng,
			map: map,
		});
		$("#pac-input").val(response.results[0].formatted_address);
	} else {
		window.alert("No results found");
	}
})
.catch((e) => window.alert("Geocoder failed due to: " + e));
}
