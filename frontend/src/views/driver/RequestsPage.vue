<template>

    <SRContents>
        <template #Content-Header>
            <h1 class="text-3xl font-bold">Delivery Service</h1>
        </template>
        <template #Content-Body>
            <div class="flex flex-col gap-2">
                <dialog id="filterDialog" class=" w-1/3 xl:w-[90%] rounded-lg p-1 h-fit">
                    <div class="flex justify-between w-full p-3 md:p-1">
                        <div class="flex items-center p-2 text-xl font-medium">
                            Filter and
                            Sort
                            Requests
                        </div>
                        <p class="h-auto px-4 py-2 text-3xl cursor-pointer hover:scale-105" @click="filterDialog()">✖
                        </p>
                    </div>
                    <hr class="w-full border">
                    <div class="flex flex-col h-[85%]">
                        <div
                            class="flex justify-between  w-full [&>*]:w-1/2 transition-all [&>*]:p-3 [&>*]:text-center">
                            <button class="flex items-center justify-center gap-2 text-lg text-center" id="filterButton"
                                :class="{ 'text-red-500 border-b-2 border-red-500': !toggleFilterandSort, 'text-black': toggleFilterandSort }"
                                @click="toggleSection('filter')">
                                <i v-html="icons.Filter" v-show="isCardView"></i>
                                <span>Filter</span>
                            </button>
                            <button class="flex items-center justify-center gap-2 p-3 text-lg text-center"
                                id="sortButton"
                                :class="{ 'text-red-500 border-b-2 border-red-500': toggleFilterandSort, 'text-black': !toggleFilterandSort }"
                                @click="toggleSection('sort')">
                                <i v-html="icons.Sort" v-show="isCardView"></i>
                                <span>Sort</span>
                            </button>
                        </div>

                        <form method="dialog" class="flex flex-col">
                            <div id="filterSection"
                                class="[&>*]:flex [&>*]:justify-around [&>*]:w-full [&>*]:p-3 [&>*]:[&>*]:w-[48%] [&>*>label]:text-center [&>*>*]:p-2"
                                v-show="toggleFilterandSort === false">
                                <div
                                    class="flex justify-around w-full p-3 [&>*]:w-[48%] [&>label]:text-center [&>*]:p-2">
                                    <label for="filterDistance">Distance</label>
                                    <input type="number" min="1" max="999" id="filterDistance" name="filterDistance"
                                        placeholder="Max Distance (miles)"
                                        class="border rounded-lg focus:outline-none focus:border-gray-400 ">
                                </div>
                                <div>
                                    <label for="filterTime">Pending Time</label>
                                    <input type="number" min="1" max="999" id="filterTime" name="filterTime"
                                        placeholder="Max Pending Time (hours)"
                                        class="border rounded-lg focus:outline-none focus:border-gray-400">
                                </div>
                                <div>
                                    <label for="filterSize">Package Size</label>
                                    <select id="filterSize" name="filterSize"
                                        class="border rounded-lg focus:outline-none focus:border-gray-400">
                                        <option value="">Any</option>
                                        <option value="small">Small</option>
                                        <option value="medium">Medium</option>
                                        <option value="large">Large</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="filterVehicle">Vehicle Type</label>
                                    <select id="filterVehicle" name="filterVehicle"
                                        class="border rounded-lg focus:outline-none focus:border-gray-400">
                                        <option value="">Any</option>
                                        <option value="bike">Bike</option>
                                        <option value="car">Car</option>
                                        <option value="van">Van</option>
                                    </select>
                                </div>
                            </div>
                            <div id="sortSection"
                                class="[&>*]:flex [&>*]:justify-around [&>*]:w-full [&>*]:p-3 [&>*]:[&>*]:w-[48%] [&>*>label]:text-center [&>*>*]:p-2 my-24"
                                v-show="toggleFilterandSort === true">
                                <div class="flex justify-around w-full p-3">
                                    <label for="sortCriteria" class="text-center">Sort By</label>
                                    <select id="sortCriteria" name="sortCriteria"
                                        class="border rounded-lg focus:outline-none focus:border-gray-400">
                                        <option value="distance">Distance</option>
                                        <option value="pendingTime">Pending Time</option>
                                        <option value="priority">Priority</option>
                                        <option value="cancellationRisk">Cancellation Risk</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex justify-around w-full [&>*]:w-[48%] p-3">
                                <button type="submit"
                                    class="p-2 text-white bg-red-600 rounded-lg hover:opacity-80">Apply</button>
                                <button type="button" id="closeDialog"
                                    class="p-2 text-red-600 border-2 border-red-600 rounded-lg hover:opacity-80"
                                    @click=" filterDialog()">Cancel</button>
                            </div>
                        </form>
                    </div>
                </dialog>
                <div :class="isCardView ? 'cardView' : 'listView'" class="h-full">
                    <div class="flex justify-end w-full md:p-1">
                        <div class="flex justify-end w-full gap-3 p-3">
                            <button @click="isCardView = !isCardView">
                                <span
                                    class="flex [&>*]:size-10 [&>*]:flex [&>*]:justify-center [&>*]:items-center [&>*]:rounded-full [&>*]:bg-[#aa0927] [&>*]:text-white [&>*]:hover:bg-[#550514]">
                                    <i v-html="icons.List" v-show="isCardView === false"></i>
                                    <i v-html="icons.Card" v-show="isCardView === true"></i>
                                </span>
                            </button>
                            <button @click="filterDialog()">
                                <i v-html="icons.Filter"
                                    class="flex items-center justify-center rounded-full size-10 bg-[#aa0927] text-white hover:bg-[#550514]"></i>
                            </button>
                        </div>
                    </div>
                    <li :class="isCardView ? 'cardList' : 'listList'" class="hover:scale-[.98]"
                        v-for="(item, index) in currentPendingDeliveries" :key="index">
                        <div class=" size-full md:flex md:justify-center md:items-center md:p-3"
                            v-show="isCardView === true">
                            <div class="bg-red-400 size-full md:size-[90%]"></div>
                        </div>
                        <div class="w-full md:p-3">
                            <h1 class="text-lg font-semibold sm:text-xs truncate  ">{{
                                item.pending[Object.keys(item.pending)[0]].itemName }}</h1>
                            <p class="sm:text-xs truncate">{{
                                item.pending[Object.keys(item.pending)[0]].itemDescription }}</p>
                        </div>
                        <div class="flex justify-end w-full md:p-3">
                            <RouterLink to="/rider/requests/1">
                                <button
                                    class="p-2 text-white bg-red-700 rounded-md hover:opacity-80 md:p-1 md:text-xs">View
                                    Details</button>
                            </RouterLink>
                        </div>
                    </li>

                    <li :class="isCardView ? 'cardList' : 'listList'" class="hover:scale-[.98]">
                        <div class="size-full md:flex md:justify-center md:items-center md:p-3"
                            v-show="isCardView === true">
                            <div class="bg-red-400 size-full md:size-[90%]"></div>
                        </div>
                        <div class="w-full md:p-3">
                            <h1 class="text-lg font-semibold sm:text-xs">List Item Heading</h1>
                            <p class="sm:text-xs">List Item Description</p>
                        </div>
                        <div class="flex justify-end w-full md:p-3">
                            <button class="p-2 text-white bg-red-700 rounded-md hover:opacity-80 md:p-1 md:text-xs">View
                                Details</button>
                        </div>
                    </li>

                    <li :class="isCardView ? 'cardList' : 'listList'" class="hover:scale-[.98]">
                        <div class="size-full md:flex md:justify-center md:items-center md:p-3"
                            v-show="isCardView === true">
                            <div class="bg-red-400 size-full md:size-[90%]"></div>
                        </div>
                        <div class="w-full md:p-3">
                            <h1 class="text-lg font-semibold sm:text-xs">List Item Heading</h1>
                            <p class="sm:text-xs">List Item Description</p>
                        </div>
                        <div class="flex justify-end w-full md:p-3">
                            <button class="p-2 text-white bg-red-700 rounded-md hover:opacity-80 md:p-1 md:text-xs">View
                                Details</button>
                        </div>
                    </li>

                </div>
            </div>
        </template>
    </SRContents>

</template>

<script setup>
import { RouterLink } from "vue-router";
import icons from "@/assets/icons";
import SRContents from "@/layouts/SRContents.vue";
import { onMounted, computed, ref, watch } from "vue";
import { driverRetrieveData } from "@/services/ApiServices.js";
import { db } from '@/services/firebaseConfig';
import { getDatabase } from "firebase/database";
import { set as rtdbSet, ref as rtdbRef, get as rtdbGet, child } from 'firebase/database';

const isCardView = ref(true);
const isFilterandSortOpen = ref(false);
const toggleFilterandSort = ref(false);
const userId = ref('');

function filterDialog() {
    isFilterandSortOpen.value = !isFilterandSortOpen.value;
    if (isFilterandSortOpen.value === true) {
        document.getElementById("filterDialog").close();
        document.getElementById('filterSection').classList.remove('active');
        document.getElementById('sortSection').classList.remove('active');
        document.getElementById('filterButton').classList.remove('bg-red-500');
        document.getElementById('sortButton').classList.remove('bg-red-500');
    } else {
        document.getElementById("filterDialog").showModal();
    }
}

function toggleSection(section) {
    const filterButton = document.getElementById('filterButton');
    const sortButton = document.getElementById('sortButton');
    const filterSection = document.getElementById('filterSection');
    const sortSection = document.getElementById('sortSection');

    if (section === 'filter') {
        toggleFilterandSort.value = !toggleFilterandSort.value;
        filterButton.classList.add('text-red-500 border-t-2 border-red-500');
        sortButton.classList.remove('text-red-500 border-t-2 border-red-500');
        filterSection.classList.add('active');
        sortSection.classList.remove('active');
    } else if (section === 'sort') {
        toggleFilterandSort.value = !toggleFilterandSort.value;
        sortButton.classList.add('text-red-500 border-t-2 border-red-500');
        filterButton.classList.remove('text-red-500 border-t-2 border-red-500');
        sortSection.classList.add('active');
        filterSection.classList.remove('active');
    }
}

const currentPendingDeliveries = ref([]);
async function load() {
    try {
        const getData = driverRetrieveData();
        getData.then(async (response) => {
            userId.value = response.result.driverID;
            const dbRef = rtdbRef(db, 'deliveries');
            const snapshot = await rtdbGet(dbRef);

            if (snapshot.exists()) {
                const deliveries = snapshot.val();
                for (const delivery in deliveries) {
                    if (deliveries.hasOwnProperty(delivery)) {
                        const deliveryData = deliveries[delivery];
                        console.log(deliveryData.pending);
                        if (deliveryData.pending) {
                            currentPendingDeliveries.value.push(deliveryData);
                            console.log(currentPendingDeliveries.value);
                        }
                    }
                }
            }
            else {
                console.log('No data available');
            }
        });
    } catch (error) {
        console.log(error);
    }
}

const flatPendingDeliveries = computed(() => {
    const items = ref([]);
    currentPendingDeliveries.value.forEach((delivery) => {
        items.value.push(delivery);
    });
    console.log("items: ", items.value);
    return items.value;
})

// const flatPendingDeliveries = computed(() => {
//     return currentPendingDeliveries.value;
// });

onMounted(load)
</script>

<style lang="scss" scoped>
* {
    //border: 1px solid red;
}


.cardView {
    @apply flex flex-wrap items-center gap-2 p-3 bg-white border rounded-lg h-full md:bg-transparent md:border-0;
}

.listView {
    @apply flex w-full flex-col items-start justify-stretch gap-2 p-3 bg-white rounded-lg size-60 h-full md:bg-transparent md:border-0 md:p-0;
}

.cardList {
    @apply flex flex-col items-center justify-center gap-5 p-5 rounded-lg w-60 h-96 bg-slate-50 border transition-all md:w-[48%] md:p-0;
}

.listList {
    @apply flex items-center justify-center w-full gap-2 p-5 rounded-lg bg-slate-50 border transition-all md:p-0;
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
}
</style>