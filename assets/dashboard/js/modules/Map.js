import Places from 'places.js'
import L from 'leaflet'

export default class Map {
    map(elements) {
        elements.forEach(map => {
            const center = [map.getAttribute('data-lat'), map.getAttribute('data-lng')];
            const icon = L.icon({iconUrl: '/images/position-marker.png'});

            console.log("Displaying Map for : ", center);
            map = L.map('map').setView(center, 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                minZoom: 12,
                attribution: '<a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            L.marker(center, {icon}).addTo(map);
        })
    }

    places(elements) {
        elements.forEach(input => {
            let places = Places({
                container: input
            });

            places.configure({
                type: 'address',
                language: 'fr_FR',
            })

            places.on('change', e => {
                try {
                    const form = input.closest('form');
                    const lat = form.querySelector(`input[name="${form.name}[addressLat]"]`);
                    const lng = form.querySelector(`input[name="${form.name}[addressLng]"]`);

                    if (lat && lng) {
                        lat.value = e.suggestion.latlng.lat;
                        lng.value = e.suggestion.latlng.lng;
                    }
                    console.log("Set data for location : ", {data: e.suggestion})
                } catch (e) {
                    console.error({e});
                }
            });
        })
    }
}
