
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

function initializeAutocomplete_departure(id) {
    var element = document.getElementById(id);
    if (element) {
      var autocomplete = new google.maps.places.Autocomplete(element, { types: ['geocode'] });
      google.maps.event.addListener(autocomplete, 'place_changed', onPlaceChanged_departure);
    }
   }
   
function onPlaceChanged_departure() {
var place = this.getPlace();


var ville_departure ={};

for(let i=0;i<place.address_components.length;i++){
    var component = place.address_components[i];

    if(component.types[0]=="street_number")
    ville_departure.number_streert = component.long_name;

    else if(component.types[0]=="route")
    ville_departure.name_street = component.long_name;

    else if(component.types[0]=="locality")
    ville_departure.name_ville = component.long_name;
    

    else if(component.types[0]=="postal_code")
    ville_departure.postal_code = component.long_name;
        
    else if(component.types[0]=="country")
    ville_departure.name_country = component.long_name;
}
    
console.log(ville_departure);
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

var ville_arrival ={};

for(let i=0;i<place.address_components.length;i++){
    var component = place.address_components[i];

    if(component.types[0]=="street_number")
    ville_arrival.number_streert = component.long_name;

    else if(component.types[0]=="route")
    ville_arrival.name_street = component.long_name;

    else if(component.types[0]=="locality")
    ville_arrival.name_ville = component.long_name;
    

    else if(component.types[0]=="postal_code")
    ville_arrival.postal_code = component.long_name;
        
    else if(component.types[0]=="country")
    ville_arrival.name_country = component.long_name;
}
    
console.log(ville_arrival);
    // affichage de l'objet Json de la ville d'arrivée
    //console.log(ville_arrival);

}

google.maps.event.addDomListener(window, 'load', function() {
initializeAutocomplete_arrival('input_address_arrival');
});

google.maps.event.addDomListener(window, 'load', function() {
initializeAutocomplete_departure('input_address_departure');
});

