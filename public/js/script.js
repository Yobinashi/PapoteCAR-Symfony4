// UPLOAD IMAGE DANS INSCRPTION.HTML

/* function handle(input) {
    console.log(input);
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = document.getElementById('choose-img');
            img.setAttribute('style', 'background-image:url('+e.target.result+')');
        }
        reader.readAsDataURL(input.files[0]);
        console.log("Image chargé");
    } 
};*/

/**
 * API GOOGLE MAP JAVASCRIPT
 */

var location_array = [];
var ville_arrival = {};
var ville_departure = {};
var time_trip;
var distance_trip;

function initializeAutocomplete_departure(id) {
    var element = document.getElementById(id);
    if (element) {
        var autocomplete = new google.maps.places.Autocomplete(element, { types: ['geocode'] });
        google.maps.event.addListener(autocomplete, 'place_changed', onPlaceChanged_departure);
    }
}

function onPlaceChanged_departure() {
    var place = this.getPlace();
    var latlng = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());

    geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'latLng': latlng }, function(results, status) {

        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                for (j = 0; j < results[0].address_components.length; j++) {
                    if (results[0].address_components[j].types[0] == 'postal_code')
                    //alert("Zip Code: " + results[0].address_components[j].short_name);
                        ville_departure.postal_code = results[0].address_components[j].short_name;
                }
            }
        } else {
            alert("Geocoder failed due to: " + status);
        }
    });

    for (let i = 0; i < place.address_components.length; i++) {
        var component = place.address_components[i];

        if (component.types[0] == "street_number")
            ville_departure.number_streert = component.long_name;

        else if (component.types[0] == "route")
            ville_departure.name_street = component.long_name;

        else if (component.types[0] == "locality")

            ville_departure.name_ville = component.long_name;

        else if (component.types[0] == "postal_code")

            ville_departure.postal_code = component.long_name;

        else if (component.types[0] == "country")

            ville_departure.name_country = component.long_name;
    }

    var location = { lat: place.geometry.location.lat(), lng: place.geometry.location.lng() };

    location_array[0] = location;

    if ((typeof location_array[0] != 'undefined') && (typeof location_array[1] != 'undefined'))

        mapFunction(location_array);
    //return location;
}

// Ville d'arrivée
function initializeAutocomplete_arrival(id) {
    var element = document.getElementById(id);
    if (element) {
        var autocomplete = new google.maps.places.Autocomplete(element, { types: ['geocode'] });
        google.maps.event.addListener(autocomplete, 'place_changed', onPlaceChanged_arrival);
    }
}

function onPlaceChanged_arrival() {
    var place = this.getPlace();
    var latlng = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());

    geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'latLng': latlng }, function(results, status) {

        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                for (j = 0; j < results[0].address_components.length; j++) {
                    if (results[0].address_components[j].types[0] == 'postal_code')
                    //alert("Zip Code: " + results[0].address_components[j].short_name);
                        ville_arrival.postal_code = results[0].address_components[j].short_name;
                }
            }
        } else {
            alert("Geocoder failed due to: " + status);
        }
    });

    for (let i = 0; i < place.address_components.length; i++) {

        var component = place.address_components[i];

        if (component.types[0] == "street_number")
            ville_arrival.number_streert = component.long_name;

        else if (component.types[0] == "route")
            ville_arrival.name_street = component.long_name;

        else if (component.types[0] == "locality")
            ville_arrival.name_ville = component.long_name;

        else if (component.types[0] == "postal_code")
            ville_arrival.postal_code = component.long_name;

        else if (component.types[0] == "country")
            ville_arrival.name_country = component.long_name;
    }

    var location = { lat: place.geometry.location.lat(), lng: place.geometry.location.lng() };
    location_array[1] = location;
    if ((typeof location_array[0] != 'undefined') && (typeof location_array[1] != 'undefined'))
        mapFunction(location_array);
}

google.maps.event.addDomListener(window, 'load', function() {
    initializeAutocomplete_arrival('run_arrival');
});

google.maps.event.addDomListener(window, 'load', function() {
    initializeAutocomplete_departure('run_departure');
});

google.maps.event.addDomListener(window, 'load', function() {
    initializeAutocomplete_arrival('search-run_arrival');
});

google.maps.event.addDomListener(window, 'load', function() {
    initializeAutocomplete_departure('search-run_departure');
});

function mapFunction(location_array) {
    var location = { lat: location_array[0].lat, lng: location_array[0].lng };
    var bounds = new google.maps.LatLngBounds();
    var options = {
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    var map = new google.maps.Map(document.getElementById("map"), options);

    for (var i = 0; i < location_array.length; i++) {
        bounds.extend(location_array[i]);
        var thisMarker = addThisMarker(location_array[i], i);
        thisMarker.setMap(map);
    }

    map.fitBounds(bounds);

    direction = new google.maps.DirectionsRenderer({
        map: map,
    });

    var request = {
        origin: ville_departure.name_ville,
        destination: ville_arrival.name_ville,
        travelMode: google.maps.DirectionsTravelMode.DRIVING
    }

    var directionsService = new google.maps.DirectionsService();

    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            direction.setDirections(response);
            time_trip = direction.directions.routes[0].legs[0].duration.text;
            distance_trip = direction.directions.routes[0].legs[0].distance.text;
            affichageFunction();
        }
    });
}

function addThisMarker(point, m) {
    var marker = new google.maps.Marker({ position: point });
    return marker;
}

function affichageFunction() {
    console.log('Ville départ: ' + ville_departure.name_ville);
    console.log("Ville d'arrivée: " + ville_arrival.name_ville);
    console.log('Temps trajet: ' + time_trip);
    console.log('Distance trajet: ' + distance_trip);
    /*document.getElementById("panel_time").innerHTML ='Temps trajet: ' + time_trip;
    document.getElementById("panel_distance").innerHTML ='Distance trajet: ' + distance_trip;*/
    document.getElementById("panel_time").innerHTML = time_trip;
    document.getElementById("panel_distance").innerHTML = distance_trip;
}

<<<<<<< HEAD
/**
 * Requestes AJAX pour la recherche d'un trajet
 */
=======
document.getElementById('search-run-date').valueAsDate = new Date();
>>>>>>> origin-Jor/master
