import { ref, onMounted, onBeforeUnmount } from 'vue';
import { mapboxgl, accessToken } from '@/services/mapbox';
import { receivercoordinatesLong, receivercoordinatesLat, sendercoordinatesLong, sendercoordinatesLat, receiverfullAddress, senderfullAddress } from '@/services/reactiveVariables';

const map = ref(null);
const marker = ref(null);
const map2 = ref(null);
const marker2 = ref(null);

const selectedLocation = ref({ lng: -74.5, lat: 40, place_name: '' });
const selectedLocation2 = ref({ lng: -74.5, lat: 40, place_name: '' });

const initializeMap = (mapRef, markerRef, containerId, updateMarkerFn) => {
    mapRef.value = new mapboxgl.Map({
        container: containerId,
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [selectedLocation.value.lng, selectedLocation.value.lat],
        zoom: 13
    });
    markerRef.value = new mapboxgl.Marker().setLngLat([selectedLocation.value.lng, selectedLocation.value.lat]).addTo(mapRef.value);
    mapRef.value.on('move', updateMarkerFn);
    mapRef.value.on('zoom', updateMarkerFn);
    mapRef.value.dragRotate.disable();
};

const fetchGeocodingData = (lng, lat, locationRef) => {
    return fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${accessToken}`)
        .then(response => response.json())
        .then(data => {
            const place = data.features[0];
            if (place) {
                locationRef.value = place.place_name;
            } else {
                console.log('No address found');
            }
        })
        .catch(error => console.error('Error with geocoding API: ', error));
};

const updateMarkerAndStoreCoordinates = () => {
    const center = map.value.getCenter();
    marker.value.setLngLat(center);
    receivercoordinatesLong.value = center.lng;
    receivercoordinatesLat.value = center.lat;
    console.info("receivercoordinatesLong:" + receivercoordinatesLong.value, "receivercoordinatesLat: " + receivercoordinatesLat.value);
    fetchGeocodingData(center.lng, center.lat, receiverfullAddress);
};

const updateMarkerAndStoreCoordinates2 = () => {
    const center = map2.value.getCenter();
    marker2.value.setLngLat(center);
    sendercoordinatesLong.value = center.lng;
    sendercoordinatesLat.value = center.lat;
    console.info("sendercoordinatesLong:" + sendercoordinatesLong.value, "sendercoordinatesLat: " + sendercoordinatesLat.value);
    fetchGeocodingData(center.lng, center.lat, senderfullAddress);
};

onMounted(() => {
    navigator.geolocation.getCurrentPosition(position => {
        selectedLocation.value = { lng: position.coords.longitude, lat: position.coords.latitude };
        initializeMap(map, marker, 'map', updateMarkerAndStoreCoordinates);
        initializeMap(map2, marker2, 'map2', updateMarkerAndStoreCoordinates2);
    });
});

onBeforeUnmount(() => {
    if (map.value) map.value.remove();
    if (map2.value) map2.value.remove();
});

export {
    map,
    marker,
    map2,
    marker2,
    selectedLocation,
    selectedLocation2,
    initializeMap,
    fetchGeocodingData,
    updateMarkerAndStoreCoordinates,
    updateMarkerAndStoreCoordinates2
};
