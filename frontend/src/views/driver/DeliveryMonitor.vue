<template>
    <div class=" w-full flex justify-end items-end">
        <div class="flex">
            <div class="flex items-end justify-end p-3 bg-green-100 rounded-lg gap-3 md:w-auto">
                <div class="flex items-center">
                    <div class="m-2 size-4 bg-green-500 rounded-full animate-ping"></div>
                    <p class="text-base font-light text-green-400 rounded-xl">
                        Ongoing Delivery
                    </p>
                </div>
                <RouterLink :to="`/rider/requests/${currentDelivery.trackingNumber}/track`">
                    <button
                        class="text-sm p-2 font-medium text-white bg-green-300 rounded-lg hover:opacity-80 ">Details</button>
                </RouterLink>
            </div>
        </div>
    </div>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import { driverRetrieveData } from "@/services/ApiServices.js";
import { db } from '@/services/firebaseConfig';
import { ref as firebaseRef, get } from 'firebase/database';
import { RouterLink, useRouter } from "vue-router";

const currentDelivery = ref('');
const userId = ref('');

onMounted(async () => {
    try {
        const response = await driverRetrieveData();
        userId.value = response.result.driverID;
        const dbRef = firebaseRef(db, 'deliveries');
        const snapshot = await get(dbRef);
        if (snapshot.exists()) {
            const deliveries = snapshot.val();
            for (const delivery in deliveries) {
                if (deliveries.hasOwnProperty(delivery)) {
                    const deliveryData = deliveries[delivery];
                    if (deliveryData.hasOwnProperty('accepted')) {
                        const pendingItems = deliveryData.accepted;
                        for (const trackingNumber in pendingItems) {
                            if (pendingItems.hasOwnProperty(trackingNumber)) {
                                const itemDetails = pendingItems[trackingNumber];
                                const pendingDelivery = {
                                    trackingNumber: trackingNumber,
                                    details: itemDetails
                                };
                                currentDelivery.value = pendingDelivery;
                                console.log("Delivery Monitor: ", currentDelivery.value.trackingNumber);
                                break; // Exit the inner loop
                            }
                        }
                        break; // Exit the outer loop
                    }
                }
            }
            console.log("Deliveries: ", currentDelivery.value);
        } else {
            console.log('No data available');
        }
    } catch (error) {
        console.error("Error retrieving data: ", error);
    }
});


</script>

<style scoped type="text/tailwindcss">
@tailwind base;
@tailwind components;
@tailwind utilities;

@layer utilities {
    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.1);
            opacity: 0.7;
        }
    }

    .pulse-animation {
        animation: pulse 2s infinite;
    }
}
</style>
