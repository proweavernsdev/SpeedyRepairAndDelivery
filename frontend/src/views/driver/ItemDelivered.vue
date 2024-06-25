<template>
    <div class="flex flex-col w-full h-auto pt-5 overflow-y-auto md:flex-col md:justify-start ">
        <div class="flex items-center gap-3 py-3 sm:py-1">
            <button @click="goBack()" v-html="icons.LeftArrow"
                class="flex ml-[1px] p-2 sm:p-px w-min cursor-pointer rounded-md hover:text-[#AA0927] hover:scale-105 hover:bg-red-100">
            </button>
            <h1 class="text-3xl sm:text-lg font-bold text-[#AA0927]">Delivery Completion</h1>
        </div>
        <div class="flex justify-between h-full gap-6 py-5 xl:flex-col [&>*]:w-full">
            <div class="flex flex-col gap-3 sm:w-1/2">
                <div class="flex justify-start">
                    <p class="font-semibold sm:text-xs">Delivery Confirmation:</p>
                </div>
                <div id="map" style="width: 100%; height: 400px;"
                    class="border-2 border-red-400 rounded-lg bg-slate-100 h-96 md:h-48" disabled></div>
            </div>
            <div class="flex flex-col justify-center sm:w-1/2">
                <p class="font-semibold sm:text-xs">Item delivered successfully</p>
                <p class="text-sm sm:text-xs">Recipient: John Doe</p>
            </div>
        </div>
        <div class="flex flex-col justify-center gap-1 sm:w-1/2">
            <p class="font-semibold sm:text-xs">Upload Delivery Confirmation/Delivery Item Photos:</p>
            <input id="notes" type="file" @change="handleFileChange"
                class="w-full p-2 border-2 hover:border-red-200 focus:outline-none h-auto focus:border-[#AA0927]" />
        </div>
        <div class="flex justify-center my-5">
            <RouterLink :to="`/rider/requests/${currentDeliveryItem.trackingNumber}/success`"
                class="w-full p-2 m-auto border-2 rounded-lg sm:text-sm text-white text-center bg-[#AA0927] hover:opacity-75">
                Confirm Delivery
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

function goBack() {
    router.go(-1);
}

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
                    for (const pendingKey in deliveryData.pending) {
                        if (deliveryData.pending.hasOwnProperty(pendingKey)) {
                            const pendingDelivery = deliveryData.pending[pendingKey];
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
        map.value = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [currentDeliveryItem.value.receivercoordinatesLong, currentDeliveryItem.value.receivercoordinatesLat],
            zoom: 13,
            interactive: false
        });

        map.value.on('style.load', async () => {
            if (currentDeliveryItem.value.sendercoordinatesLong && currentDeliveryItem.value.sendercoordinatesLat &&
                currentDeliveryItem.value.receivercoordinatesLong && currentDeliveryItem.value.receivercoordinatesLat) {
                await getDirections();
            } else {
                console.log("Coordinates not found");
            }

            if (currentDeliveryItem.value) {
                const receiverCoordinates = [currentDeliveryItem.value.receivercoordinatesLong, currentDeliveryItem.value.receivercoordinatesLat];
                const senderCoordinates = [currentDeliveryItem.value.sendercoordinatesLong, currentDeliveryItem.value.sendercoordinatesLat];
                map.value.flyTo({ center: receiverCoordinates, essential: true });
                new mapboxgl.Marker({ color: 'red' }).setLngLat(receiverCoordinates).addTo(map.value);
                new mapboxgl.Marker({ color: 'blue' }).setLngLat(senderCoordinates).addTo(map.value);
            }
        });

        map.value.on('error', (e) => {
            console.error('Mapbox error:', e.error);
        });

    } catch (error) {
        console.log(error);
    }
}


async function getDirections() {
    try {
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
    } catch (error) {
        console.error('Error fetching or displaying route:', error);
    }
}

onMounted(load);
</script>

<style lang="scss" scoped>
* {
    //border: 1px solid red;
}
</style>