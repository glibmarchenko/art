<style>
    .pac-container{

    }

    .pac-matched{
        font-size: 13px;
        font-weight: bold;
    }
</style>
<script>
    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

    /*function initMap() {
        var input = document.getElementById('country-input');
        if (!input) {
            return;
        }

        var autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        //autocomplete.bindTo('bounds', map);

       // var infowindow = new google.maps.InfoWindow();

        autocomplete.addListener('place_changed', function() {
          //  infowindow.close();
            var place = autocomplete.getPlace();


            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }

            console.log(place);

            //input.value = place.formatted_address;
            //console.log(place.formatted_address);
        });


    }*/
</script>
<!--<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_JS_API')}}&libraries=places&callback=initMap"
        async defer></script>-->