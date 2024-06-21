<template>
    <div class="flex flex-col w-full h-auto pt-5 overflow-y-auto sm:pt-2 md:flex-col md:justify-start ">
        <div class="flex items-center gap-3 py-3 sm:py-1">
            <button @click="goBack()" v-html="icons.LeftArrow"
                class="flex ml-[1px] p-2 sm:p-px w-min cursor-pointer rounded-md hover:text-[#AA0927] hover:scale-105 hover:bg-red-100">
            </button>
            <h1 class="text-3xl sm:text-lg font-bold text-[#AA0927]">Delivery Item Details</h1>
        </div>
        <div
            class="flex flex-row 2xl:flex-col [&>*]:w-1/2 2xl:[&>*]:w-full [&>*]:p-3 items-center justify-center h-full">
            <div class="flex items-center justify-center">
                <img src="../../assets/R.png" alt="image"
                    class="object-cover size-[600px] rounded-lg md:size-full 2xl:h-[400px]" />
            </div>
            <dialog class="p-5 border-2 rounded-lg" id="rejectDialog">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-medium sm:text-lg ">Reject Task</h3>
                    <button id="cancelDialog" class="text-[#AA0927] px-2 py-1 hover:scale-95"
                        @click="dialog('closeRejectModal')">✖</button>
                </div>
                <hr class="m-auto my-2 border ">
                <div class="flex flex-col justify-between gap-2">
                    <p class="p-12 text-center sm:text-sm">Are you sure you want to reject this task?</p>
                    <div class="flex justify-evenly [&>*]:w-[40%] [&>*]:p-2 [&>*]:rounded-lg">
                        <button id="confirmReject" class="text-white text-sm sm:text-xs bg-[#AA0927] hover:opacity-80"
                            @click="dialog('confirmReject')">Yes,
                            Reject</button>
                        <button id="closeDialog"
                            class="text-[#AA0927] border-2 border-[#AA0927] text-sm sm:text-xs hover:opacity-80"
                            @click="dialog('closeRejectModal')">No,
                            Keep Task</button>
                    </div>
                </div>
            </dialog>
            <div class="flex flex-col gap-5 border rounded-lg bg-slate-100 sm:bg-transparent sm:border-0">
                <div class="flex flex-col gap-1 p-5 [&>div>label]:uppercase sm:p-1">
                    <div>
                        <label for="packageId" class="text-xl font-medium sm:text-base text-slate-700">Package
                            name</label>
                        <div id="packageId">{{ currentDeliveryItem.itemName }}</div>
                    </div>
                    <div>
                        <label for="packageId" class="text-2xl sm:text-base font-extrabold text-[#AA0927]">$120</label>
                    </div>
                    <div
                        class="flex flex-wrap [&>*]:w-1/2 md:[&>*]:w-full justify-center mt-5 [&>div>label]:uppercase [&>div>div]:text-[#AA0927] sm:flex-col">
                        <div class="flex items-center gap-5">
                            <label for="packageSize" class="text-sm font-medium sm:text-xs text-slate-500">Size:</label>
                            <div id="packageSize" class="text-lg font-bold sm:text-base">{{ currentDeliveryItem.width }}
                                x {{ currentDeliveryItem.height }} x {{ currentDeliveryItem.length }} </div>
                        </div>
                        <div class="flex items-center gap-5">
                            <label for="packageSize"
                                class="text-sm font-medium sm:text-xs text-slate-500">Length:</label>
                            <div id="Unit" class="text-lg font-bold sm:text-base">{{ currentDeliveryItem.sizeDropdown
                                }}</div>
                        </div>
                        <div class="flex items-center gap-5">
                            <label for="packageSize"
                                class="text-sm font-medium sm:text-xs text-slate-500">Weight:</label>
                            <div id="packageSize" class="text-lg font-bold sm:text-base lowercase">{{
                                currentDeliveryItem.weight }}
                                {{ currentDeliveryItem.weightDropdown }}</div>
                        </div>
                    </div>
                    <hr class="w-[97.5%] m-auto my-5 border">
                    <div class="flex items-center justify-start p-2">
                        <label for="pickupLocation" class="text-sm font-medium md:text-xs text-slate-500 pr-2">Pickup
                            Location: &nbsp;</label>
                        <div id="pickupLocation" class="md:text-sm"> {{ currentDeliveryItem.senderaddressInfo }}</div>
                    </div>
                    <div class="flex items-center justify-start p-2">
                        <label for="deliveryLocation"
                            class="text-sm font-medium md:text-xs text-slate-500 pr-2">Delivery
                            Location:&nbsp;</label>
                        <div id="deliveryLocation" class="md:text-sm"> {{ currentDeliveryItem.receiveraddressInfo }}
                        </div>
                    </div>
                    <hr class="w-[97.5%] m-auto my-5 border">
                    <div class="flex flex-col p-2">
                        <label for="fragility" class="text-sm font-medium md:text-xs text-slate-500">Fragility:</label>
                        <div id="fragility" class="md:text-sm">{{ currentDeliveryItem.fragility }}</div>
                    </div>
                    <div class="flex flex-col p-2">
                        <label for="specialInstructions" class="text-sm font-medium md:text-xs text-slate-500">Special
                            Instructions:</label>
                        <div id="specialInstructions" class="md:text-sm">{{ currentDeliveryItem.notes }} </div>
                    </div>
                    <hr class="w-[97.5%] m-auto my-5 border">
                    <div class="flex items-center justify-evenly">
                        <label for="currentStatus" class="text-sm font-medium md:text-xs text-slate-500">Current
                            Status:</label>
                        <div id="currentStatus" class="flex items-center md:text-sm capitalize">
                            <p v-html="icons.OnHold
                                " class="px-3 text-yellow-500">
                            </p>{{ currentDeliveryItem.status }}
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-row gap-1 justify-center [&>*]:w-[48%] sm:[&>*]:w-full [&>*]:p-2 py-2 sm:flex-col">
                    <RouterLink :to="`/rider/requests/${currentDeliveryItem.trackingNumber}/track`"
                        class="accept bg-[#AA0927] text-white text-center items-center rounded-lg hover:opacity-80 hover:scale-[99%] text-sm">
                        Accept
                        Task
                    </RouterLink>
                    <button
                        class="reject text-[#AA0927] rounded-lg border-2 border-transparent hover:border-[#AA0927] text-sm"
                        @click="dialog('openRejectModal')">Reject
                        Task</button>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import { RouterLink } from "vue-router";
import icons from "@/assets/icons";
import { onMounted, ref } from "vue";
import { driverRetrieveData } from "@/services/ApiServices.js";
import { db } from '@/services/firebaseConfig';
import { ref as rtdbRef, get as rtdbGet } from 'firebase/database';
import { useRouter, useRoute } from "vue-router";

const userId = ref('');
const router = useRouter();
const currentDeliveryItem = ref([]);
async function load() {
    try {
        const route = useRoute();
        const trackingNumber = route.params.id;
        console.log("REQUEST ID:", trackingNumber);
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
                                console.log(currentDeliveryItem.value);
                                found = true;
                                break;
                            }
                        }
                    }
                }
                if (found) break;
            }
            if (!found) {
                console.log('No matching delivery found.');
            }
        } else {
            console.log('No data available');
        }
    } catch (error) {
        console.log(error);
    }
}

function dialog(type) {
    const rejectModal = document.getElementById("rejectDialog");
    if (type == "closeRejectModal") {
        rejectModal.close();
    } else if (type == "openRejectModal") {
        rejectModal.showModal();
    } else if (type == "confirmReject") {
        console.log("reject");
    }
}

function goBack() {
    router.go(-1);
}

onMounted(load);

</script>

<style lang="scss" scoped>
* {
    //border: 1px solid red;
}
</style>