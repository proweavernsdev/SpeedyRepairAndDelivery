<template>
  <div>
  <div class="p-4 bg-white rounded shadow-lg relative">
    <div id="map" class="w-full h-64 rounded border mb-4"></div>
    <input
      type="text"
      v-model="searchQuery"
      @input="searchLocation"
      class="absolute top-0 mt-5 bg-white border rounded py-2 px-4 mx-2"
      placeholder="Search Location"
    />
    <ul v-if="searchResults.length" class="absolute top-11 mt-5 bg-white border rounded py-2 px-4 mx-2 overflow-auto">
      <li
        v-for="(result, index) in searchResults"
        :key="index"
        @click="selectLocation(result)"
        class="py-1 cursor-pointer hover:bg-gray-200"
      >
        {{ result.place_name }}
      </li>
    </ul>
    <div class="flex flex-col text-center">
      <button 
        @click="!props.isPickUpLocation ? calculateDistanceAndDirections() : getCurrentPosition()" 
        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition mb-1"
      >
        {{ !props.isPickUpLocation ? 'Calculate Distance' : 'Get Current Location' }}
      </button>
    </div>
  </div>
  <div class="flex flex-col text-center bg-white p-5 mt-5 rounded-md">
    <h3 class="text-lg font-semibold text-gray-800 -mt-2">Additional Information</h3>
      <textarea
        type="text"
        v-model="additionalAddressInfo"
        class="px-2 py-1 border rounded"
        placeholder="Additional Address Info">
        </textarea>
      <input
        type="text"
        v-model="receiverSenderName"
        class="mt-4 px-2 py-1 border rounded"
        placeholder="Receiver/Sender Name"
      />
      <input
        type="text"
        v-model="contactNumber"
        class="mt-4 px-2 py-1 border rounded"
        placeholder="Contact Number"
      />
  </div>
  <div class="flex flex-col text-center mt-3">
    <button @click="confirmLocation" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition ">
          Confirm
    </button>
  </div>
</div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import mapboxgl from 'mapbox-gl';
import axios from 'axios';
import { Geolocation } from '@capacitor/geolocation';

const props = defineProps({
  isPickUpLocation: Boolean,
  pickupLocation: Object
});

const emit = defineEmits(['pickupLocation', 'dropoffLocation']);

const map = ref(null);
const marker = ref(null);
const marker1 = ref(null);
const searchQuery = ref('');
const searchResults = ref([]);
const selectedLocation = ref({ lng: -74.5, lat: 40, place_name: '' });
let distance = ref(null);
let directions = ref(null);
let routeLayerId = null;


mapboxgl.accessToken = 'pk.eyJ1Ijoiam9obi0yMDAxIiwiYSI6ImNsdm1yaXRxNDA2NHgyanBlY2oxanFja3gifQ.W_pQHATCMu0KrjHWAHF-CA';
onMounted(() => {
  map.value = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [props.pickupLocation.lng?props.pickupLocation.lng:selectedLocation.value.lng, props.pickupLocation.lat?props.pickupLocation.lat:selectedLocation.value.lat],
    zoom: 15,
  });
  marker.value = new mapboxgl.Marker()
    .setLngLat([selectedLocation.value.lng, selectedLocation.value.lat])
    .addTo(map.value);

  map.value.on('move', updateMarkerPosition);

   if (!props.isPickUpLocation) {
      if (marker1.value) {
          marker1.value.remove();
      }
      marker.value.setLngLat([props.pickupLocation.lng, props.pickupLocation.lat]);
      marker1.value = new mapboxgl.Marker({color: '#AA0927'})
      .setLngLat([props.pickupLocation.lng, props.pickupLocation.lat]) 
      .addTo(map.value);
  }
  else {
      if(marker.value){
          marker.value.remove();
      }
      map.value.center = [selectedLocation.value.lng, selectedLocation.value.lat];
      marker.value = new mapboxgl.Marker()
      .setLngLat([selectedLocation.value.lng, selectedLocation.value.lat])
      .addTo(map.value);
  }
});

function updateMarkerPosition() {
  const center = map.value.getCenter();
  selectedLocation.value = { lng: center.lng, lat: center.lat };
  marker.value.setLngLat([center.lng, center.lat]);
  fetchLocationName(center.lng, center.lat);
}
const  getCurrentPosition = async () => {
  const coordinates = await Geolocation.getCurrentPosition();
  selectLocation({
    center: [coordinates.coords.longitude, coordinates.coords.latitude],
    place_name: fetchLocationName(coordinates.coords.longitude, coordinates.coords.latitude),
  })
}

async function calculateDistanceAndDirections() {
  const origin = [marker.value.getLngLat().lng, marker.value.getLngLat().lat];
  const destination = [marker1.value.getLngLat().lng, marker1.value.getLngLat().lat];
  console.log(origin, destination)

  const directionsUrl = `https://api.mapbox.com/directions/v5/mapbox/driving/${origin[0]},${origin[1]};${destination[0]},${destination[1]}?geometries=geojson&access_token=${mapboxgl.accessToken}`;
  
  try {
    const response = await axios.get(directionsUrl);
    console.log(response)
    const data = response.data;
    console.log(data);

    // Extract distance
    distance.value = (data.routes[0].distance * 0.000621371).toFixed(2); // Convert meters to miles

    // Extract directions
    directions.value = data.routes[0].legs[0].steps.map(step => step.maneuver.instruction);

    if (routeLayerId) {
      map.value.removeLayer(routeLayerId);
      map.value.removeSource(routeLayerId);
    }
  
    // Add a new route layer
    map.value.addLayer({
      id: 'route',
      type: 'line',
      source: {
        type: 'geojson',
        data: {
          type: 'Feature',
          properties: {},
          geometry: data.routes[0].geometry
        }
      },
      layout: {
        'line-join': 'round',
        'line-cap': 'round'
      },
      paint: {
        'line-color': '#FF0000',
        'line-width': 4
      }
    });
  
    // Store the layer ID for cleanup
    routeLayerId = 'route';
  } catch (error) {
    console.error('Error calculating distance and directions:', error);
  }
}

async function fetchLocationName(lng, lat) {
  const queryUrl = `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxgl.accessToken}`;
  try {
    const response = await axios.get(queryUrl);
    const placeName = response.data.features[0]?.place_name || '';
    searchQuery.value = placeName;
    selectedLocation.value.place_name = placeName;
  } catch (error) {
    console.error('Error fetching location name:', error);
  }
}

async function searchLocation() {
  if (!searchQuery.value) {
    searchResults.value = [];
    return;
  }
  const searchUrl = `https://api.mapbox.com/geocoding/v5/mapbox.places/${searchQuery.value}.json?access_token=${mapboxgl.accessToken}&autocomplete=true`;
  try {
    const response = await axios.get(searchUrl);
    searchResults.value = response.data.features;
  } catch (error) {
    console.error('Error searching location:', error);
  }
}

function selectLocation(location) {
  selectedLocation.value = {
    lng: location.center[0],
    lat: location.center[1],
    place_name: location.place_name,
  };
  searchQuery.value = location.place_name;
  searchResults.value = [];
  map.value.flyTo({ center: [location.center[0], location.center[1]], essential: true });
  marker.value.setLngLat([location.center[0], location.center[1]]);
}

function confirmLocation() {
  const locationData = {
      lat: selectedLocation.value.lat,
      lng: selectedLocation.value.lng,
      address: selectedLocation.value.place_name // include the address
  };
  if (props.isPickUpLocation) {
    emit('pickupLocation', locationData);
  } else {
    emit('dropoffLocation', {distance: distance.value, location: locationData});
  }
}

onBeforeUnmount(() => {
  if (map.value) {
    map.value.remove();
  }
});
</script>

<style scoped>
p {
  margin: 0;
}

button {
  transition: background-color 0.3s;
}

button:hover {
  cursor: pointer;
}

</style>