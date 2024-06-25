<template>
    <div class="flex flex-col w-full h-auto pt-5 overflow-y-auto md:flex-col md:justify-start">
        <div class="flex items-center gap-3 py-3 sm:py-1">
            <button @click="goBack()" v-html="icons.LeftArrow"
                class="flex ml-[1px] p-2 sm:p-px w-min cursor-pointer rounded-md hover:text-[#AA0927] hover:scale-105 hover:bg-red-100">
            </button>
            <h1 class="text-3xl sm:text-lg font-bold text-[#AA0927]">Current Delivery Task</h1>
        </div>
        <div class="flex justify-between h-full gap-5 py-5 xl:flex-col [&>*]:w-full">
            <div class="flex flex-col gap-5 sm:w-1/2">
                <p class="sm:text-xs">Task details with real-time status updates will be displayed here.</p>
                <div class="flex flex-col gap-2">
                    <div class="flex justify-end">
                        <button @click="getDirections()"
                            class="p-1 border-2 rounded-sm sm:text-xs bg-slate-50 hover:opacity-75">Get
                            Directions</button>
                    </div>
                    <div id="map" style="width: 100%; height: 400px;" class="border-2 border-red-400 rounded-lg"></div>
                </div>
            </div>
            <div class="flex flex-col items-center justify-center gap-5 sm:w-1/2">
                <div class="flex justify-center gap-3 w-full [&>*]:w-[40%] [&>*]:p-1">
                    <a :href="`tel:${currentDeliveryItem.senderphone}`"
                        class="text-white bg-red-700 rounded-md flex justify-center items-center md:text-sm hover:opacity-75">
                        Contact Pickup
                    </a>
                    <a :href="`tel:${currentDeliveryItem.receiverphone}`"
                        class="text-red-700 border-2 border-red-700 rounded-md flex justify-center items-center md:text-sm hover:opacity-75">
                        Contact Drop-off
                    </a>
                </div>
                <p class="sm:text-xs">Note: Please ensure to verify all addresses before contacting.</p>
            </div>
        </div>
        <div class="flex justify-center">
            <RouterLink :to="`/rider/requests/${currentDeliveryItem.trackingNumber}/success`"
                class="w-11/12 p-2 m-auto border-2 text-center rounded-lg sm:text-sm text-[#AA0927] bg-slate-200 hover:opacity-75">
                Delivery Location Arrived
            </RouterLink>
        </div>
    </div>
</template>

<script setup>
import { RouterLink } from "vue-router";
import icons from "@/assets/icons";
import { onMounted, ref, watch } from "vue";
import { driverRetrieveData } from "@/services/driver.js";
import { db } from '@/services/firebaseConfig';
import { ref as rtdbRef, get as rtdbGet } from 'firebase/database';
import { useRouter, useRoute } from "vue-router";
import { mapboxgl, accessToken } from '@/services/mapbox';

const userId = ref('');
const router = useRouter();
const currentDeliveryItem = ref([]);
const map = ref(null);

async function getDirections() {
    try {
        if (currentDeliveryItem.value.sendercoordinatesLong && currentDeliveryItem.value.sendercoordinatesLat &&
            currentDeliveryItem.value.receivercoordinatesLong && currentDeliveryItem.value.receivercoordinatesLat) {

            const start = [currentDeliveryItem.value.sendercoordinatesLong, currentDeliveryItem.value.sendercoordinatesLat];
            const end = [currentDeliveryItem.value.receivercoordinatesLong, currentDeliveryItem.value.receivercoordinatesLat];

            const query = await fetch(
                `https://api.mapbox.com/directions/v5/mapbox/cycling/${start[0]},${start[1]};${end[0]},${end[1]}?steps=true&geometries=geojson&access_token=${accessToken}`,
                { method: 'GET' }
            );

            const json = await query.json();
            const data = json.routes[0];
            const route = data.geometry.coordinates;

            const geojson = {
                type: 'Feature',
                properties: {},
                geometry: {
                    type: 'LineString',
                    coordinates: route
                }
            };

            if (map.value.getSource('route')) {
                map.value.getSource('route').setData(geojson);
            } else {
                map.value.addSource('route', {
                    type: 'geojson',
                    data: geojson
                });

                map.value.addLayer({
                    id: 'route',
                    type: 'line',
                    source: 'route',
                    layout: {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    paint: {
                        'line-color': '#3887be',
                        'line-width': 5,
                        'line-opacity': 0.75
                    }
                });
            }
        }
    } catch (error) {
        console.error('Error fetching or displaying route:', error);
    }
}



watch(currentDeliveryItem, (newValue) => {
    if (map.value) {
        const receiverCoordinates = [newValue.receivercoordinatesLong, newValue.receivercoordinatesLat];
        const senderCoordinates = [newValue.sendercoordinatesLong, newValue.sendercoordinatesLat];
        console.log(receiverCoordinates, senderCoordinates);
        map.value.flyTo({ center: receiverCoordinates, essential: true });
        new mapboxgl.Marker({ color: 'red' }).setLngLat(receiverCoordinates).addTo(map.value);
        new mapboxgl.Marker({ color: 'blue' }).setLngLat(senderCoordinates).addTo(map.value);
    }
});

async function load() {
    try {
        const route = useRoute();
        const trackingNumber = route.params.id;
        const response = await driverRetrieveData();
        userId.value = response.result.driverID;
        const dbRef = rtdbRef(db, 'deliveries');
        const snapshot = await rtdbGet(dbRef);
        if (snapshot.exists()) {
            const deliveries = snapshot.val();
            let found = false;
            for (const deliveryKey in deliveries) {
                if (deliveries.hasOwnProperty(deliveryKey)) {
                    const deliveryData = deliveries[deliveryKey];
                    for (const pendingKey in deliveryData.accepted) {
                        if (deliveryData.accepted.hasOwnProperty(pendingKey)) {
                            const pendingDelivery = deliveryData.accepted[pendingKey];
                            if (pendingDelivery.trackingNumber == trackingNumber) {
                                currentDeliveryItem.value = pendingDelivery;
                                found = true;
                                break;
                            }
                        }
                    }
                }
                if (found) break;
            }
        }

        mapboxgl.accessToken = accessToken;
        if (!map.value) {
            map.value = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [currentDeliveryItem.value.receivercoordinatesLong, currentDeliveryItem.value.receivercoordinatesLat],
                zoom: 13
            });
        }

        // Ensure map is fully initialized before proceeding
        await new Promise(resolve => {
            map.value.on('load', resolve);
        });

        if (currentDeliveryItem.value) {
            const receiverCoordinates = [currentDeliveryItem.value.receivercoordinatesLong, currentDeliveryItem.value.receivercoordinatesLat];
            const senderCoordinates = [currentDeliveryItem.value.sendercoordinatesLong, currentDeliveryItem.value.sendercoordinatesLat];
            map.value.flyTo({ center: receiverCoordinates, essential: true });
            new mapboxgl.Marker({ color: 'red' }).setLngLat(receiverCoordinates).addTo(map.value);
            new mapboxgl.Marker({ color: 'blue' }).setLngLat(senderCoordinates).addTo(map.value);
        }
    } catch (error) {
        console.log(error);
    }
}


function goBack() {
    router.go(-2);
}

onMounted(load);
</script>

<style lang="scss" scoped>
* {
    //border: 1px solid red;
}
</style>
