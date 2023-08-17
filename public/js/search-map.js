function getFirstPhotoName(inputString) {
    if (!inputString) {
        return null; // Return null if the input string is empty
    }
    
    // Split the input string by commas
    var splitStrings = inputString.split(',');
    
    // Return the first string after removing leading and trailing whitespace
    return splitStrings[0].trim();
}

function showHotelsMap(map) {

    navigator.geolocation.getCurrentPosition(function(position) {
        var userLat = position.coords.latitude;
        var userLon = position.coords.longitude;
        map.setView([userLat, userLon], 13);
    });

    $.get('/api/hotel/getHotels', function(response) {
        var hotels = response["data"]; // Assuming the API returns an array of hotels

        hotels.forEach(function(hotel) {
            var marker = L.marker([hotel.latitude, hotel.longitude]).addTo(map);

            var photo = getFirstPhotoName(hotel.photos);

            var popupContent = `
                <div class="popup-container justify-centent-center">
                    <img src="/images/Hotels/${hotel.id}/${photo}" alt="${hotel.name}" class="popup-photo">
                    <h3 class="popup-title mb-2">${hotel.name}</h3>
                    <span class="text-muted" style="font-size:14px;">Hotel</span>
                    <div class="row mt-2">
                        <div class="col-6 text-center">
                            <a href="/chatify/${hotel.user_manager}" style="color:#1cc3b5;"><i class="fa fa-comments"></i> Contact</a>
                        </div>
                        <div class="text-reberto col-6 text-center"><i class="fa fa-phone"></i> ${hotel.phone}</div>
                    </div>
                    <div class="popup-button-container">
                        <a href="/en/u/hotel/${hotel.id}" class="popup-button mt-3">Details</a>
                    </div>
                </div>
            `;

            var popup = L.popup({
                maxWidth: 250,  // Adjust the maximum width of the popup as needed
            }).setContent(popupContent);

            marker.bindPopup(popup);
        });
    });
}

function showChaletsMap(map) {

    navigator.geolocation.getCurrentPosition(function(position) {
        var userLat = position.coords.latitude;
        var userLon = position.coords.longitude;
        map.setView([userLat, userLon], 13);
    });

    $.get('/api/chalet/getChalets', function(response) {
        var chalets = response["data"]; // Assuming the API returns an array of hotels

        chalets.forEach(function(chalet) {
            var marker = L.marker([chalet.latitude, chalet.longitude]).addTo(map);

            var photo = getFirstPhotoName(chalet.photos);
            
            var popupContent = `
                <div class="popup-container justify-centent-center">
                    <img src="/images/Chalets/${chalet.id}/${photo}" alt="${chalet.name}" class="popup-photo">
                    <h3 class="popup-title mb-2">${chalet.name}</h3>
                    <span class="text-muted" style="font-size:14px;">Chalet</span>
                    <div class="row mt-2">
                        <div class="col-6 text-center">
                            <a href="/chatify/${chalet.user_manager}" style="color:#1cc3b5;"><i class="fa fa-comments"></i> Contact</a>
                        </div>
                        <div class="text-reberto col-6 text-center"><i class="fa fa-phone"></i> ${chalet.phone}</div>
                    </div>
                    <div class="popup-button-container">
                        <a href="/en/u/chalet/${chalet.id}" class="popup-button mt-3" onclick="">Details</a>
                    </div>
                </div>
            `;

            var popup = L.popup({
                maxWidth: 250,  // Adjust the maximum width of the popup as needed
            }).setContent(popupContent);

            marker.bindPopup(popup);
        });
    });
}

function showRestaurantsMap(map) {

    navigator.geolocation.getCurrentPosition(function(position) {
        var userLat = position.coords.latitude;
        var userLon = position.coords.longitude;
        map.setView([userLat, userLon], 13);
    });


    $.get('/api/restaurent/getRestaurents', function(response) {
        var restaurants = response["data"]; // Assuming the API returns an array of hotels

        restaurants.forEach(function(restaurant) {
            var marker = L.marker([restaurant.latitude, restaurant.longitude]).addTo(map);
            
            var photo = getFirstPhotoName(restaurant.photos);

            var popupContent = `
                <div class="popup-container justify-centent-center">
                    <img src="/images/Restaurents/${restaurant.id}/${photo}" alt="${restaurant.name}" class="popup-photo">
                    <h3 class="popup-title mb-2">${restaurant.name}</h3>
                    <span class="text-muted" style="font-size:14px;">Restaurant</span>
                    <div class="row mt-2">
                        <div class="col-6 text-center">
                            <a href="/chatify/${restaurant.user_manager}" style="color:#1cc3b5;"><i class="fa fa-comments"></i> Contact</a>
                        </div>
                        <div class="text-reberto col-6 text-center"><i class="fa fa-phone"></i> ${restaurant.phone}</div>
                    </div>
                    <div class="popup-button-container">
                        <a href="/en/u/restaurent/${restaurant.id}" class="popup-button mt-3" onclick="">Details</a>
                    </div>
                </div>
            `;

            var popup = L.popup({
                maxWidth: 250,  // Adjust the maximum width of the popup as needed
            }).setContent(popupContent);

            marker.bindPopup(popup);
        });
    });
}

function removeMarkers(map) {
    map.eachLayer(function (layer) {
        if (layer instanceof L.Marker) {
            map.removeLayer(layer);
        }
    });
}