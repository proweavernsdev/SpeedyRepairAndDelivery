<template>
    <SRContents>
        <template #Content-Header>
            <div class="flex flex-col gap-5">
                <h2>Account Management </h2>
                <div class="flex gap-x-2">
                    <h3>Profile</h3>
                </div>
            </div>
        </template>
        <template #Content-Body>
            <div class="flex flex-row justify-center h-full">
                <div class="w-2/3 m-2 rounded-md bg-slate-300 sm:w-full">
                    <div id="viewAccount" class="flex flex-col w-full p-2 rounded-md shadow-sm" v-if="!isEditModeOn">
                        <div class="flex flex-col items-center my-2 text-center">
                            <SRProfile :image="pfp" :isEditModeOn="isEditModeOn" />
                        </div>
                        <p class="flex flex-col w-full">
                            <span class="m-2 text-base text-center font-bold">{{ driverInformation.driver_firstName }}
                                {{
                                    driverInformation.driver_lastName }}</span>
                            <span class="m-2 text-base text-center">{{ driverInformation.driver_address }}</span>
                        </p>
                        <div class="p-5">
                            <div class="flex flex-row text-center">
                                <p class="flex flex-row w-full text-center">
                                    <span class="w-1/3 p-2 text-sm border">ID</span>
                                    <span class="flex items-center justify-center w-2/3 text-sm font-bold border">{{
                                        driverInformation.driverID
                                    }}</span>
                                </p>
                            </div>
                            <div class="flex flex-row text-center">
                                <p class="flex flex-row w-full text-center">
                                    <span class="w-1/3 p-2 text-sm border">STATE</span>
                                    <span class="flex items-center justify-center w-2/3 text-sm font-bold border">{{
                                        driverInformation.driver_state }}</span>
                                </p>
                            </div>
                            <div class="flex flex-row text-center">
                                <p class="flex flex-row w-full text-center">
                                    <span class="w-1/3 p-2 text-sm border">TOWN</span>
                                    <span class="flex items-center justify-center w-2/3 text-sm font-bold border ">{{
                                        driverInformation.driver_towity }}</span>
                                </p>
                            </div>
                            <div class="flex flex-row text-center">
                                <p class="flex flex-row w-full text-center">
                                    <span class="w-1/3 p-2 text-sm border">ZIP</span>
                                    <span class="flex items-center justify-center w-2/3 text-sm font-bold border ">{{
                                        driverInformation.driver_zip
                                    }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col items-center justify-center p-2">
                            <button class="w-2/3 p-2 text-sm bg-[#550514] text-white rounded-lg"
                                @click="editProfile">Update
                                Profile</button>
                        </div>
                        <div class="flex justify-around items-center my-10 text-left">
                            <h2 class="text-2xl font-bold">Ratings and Reviews</h2>
                            <div class="text-center">
                                <h1 class="text-xl flex items-center">
                                    <span class="font-bold">{{ averageRating }} </span>
                                    <span class="text-base">({{ totalReviews }}) </span>
                                </h1>
                                <p>out of 5</p>
                            </div>
                        </div>
                    </div>
                    <div id="editAccount" class="flex flex-col w-full p-2 rounded-md shadow-sm " v-else>
                        <div class="flex flex-row items-start justify-between">
                            <div class="flex flex-row items-center justify-center w-full my-2">
                                <div class="flex justify-center w-1/3 mx-5">
                                    <SRProfile :image="pfp" :isEditModeOn="isEditModeOn" />
                                </div>
                            </div>
                            <div class="flex m-2 hover:scale-105">
                                <span>
                                    <button @click="isEditModeOn = false" class="w-6 ">
                                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                            <line x1="10" y1="10" x2="90" y2="90" stroke="currentColor"
                                                stroke-width="5" />
                                            <line x1="90" y1="10" x2="10" y2="90" stroke="currentColor"
                                                stroke-width="5" />
                                        </svg>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col w-full">
                            <div class="flex flex-col gap-2 px-2 py-2">
                                <div class="flex flex-row text-center">
                                    <p class="flex items-center justify-center w-1/3 p-2 text-sm ">Driver First Name:
                                    </p>
                                    <input type="text" name="" id=""
                                        class="w-2/3 bg-[#E3D5D8] rounded-lg px-2 text-sm border  focus:ring focus:ring-[#C6ACB1] focus:border-gray-400 focus:outline-none"
                                        :placeholder="driverInformation.driver_firstName">
                                </div>
                                <div class="flex flex-row text-center">
                                    <p class="flex items-center justify-center w-1/3 p-2 text-sm ">Driver Last Name:</p>
                                    <input type="text" name="" id=""
                                        class="w-2/3 bg-[#E3D5D8] rounded-lg px-2 text-sm border  focus:ring focus:ring-[#C6ACB1] focus:border-gray-400 focus:outline-none"
                                        :placeholder="driverInformation.driver_lastName">
                                </div>
                                <div class="flex flex-row text-center">
                                    <p class="flex items-center justify-center w-1/3 p-2 text-sm">Driver Address:</p>
                                    <input type="text" name="" id=""
                                        class="w-2/3 bg-[#E3D5D8] rounded-lg px-2 text-sm border  focus:ring focus:ring-[#C6ACB1] focus:border-gray-400 focus:outline-none"
                                        :placeholder="driverInformation.driver_address">
                                </div>
                            </div>
                            <div class="flex flex-col gap-2 px-2 py-2">
                                <div class="flex flex-row text-center">
                                    <p class="flex items-center justify-center w-1/3 p-2 text-sm">State: </p>
                                    <input type="text" name="" id=""
                                        class="w-2/3 bg-[#E3D5D8] rounded-lg px-2 text-sm border  focus:ring focus:ring-[#C6ACB1] focus:border-gray-400 focus:outline-none"
                                        :placeholder="driverInformation.driver_state">
                                </div>
                                <div class="flex flex-row text-center">
                                    <p class="flex items-center justify-center w-1/3 p-2 text-sm">Town / City:</p>
                                    <input type="text" name="" id=""
                                        class="w-2/3 bg-[#E3D5D8] rounded-lg px-2 text-sm border  focus:ring focus:ring-[#C6ACB1] focus:border-gray-400 focus:outline-none"
                                        :placeholder="driverInformation.driver_towity">
                                </div>
                                <div class="flex flex-row text-center">
                                    <p class="flex items-center justify-center w-1/3 p-2 text-sm">ZIP Code:</p>
                                    <input type="number" min="1" max="999" name="" id=""
                                        class="w-2/3 bg-[#E3D5D8] rounded-lg px-2 text-sm border focus:ring focus:ring-[#C6ACB1] focus:border-gray-400 focus:outline-none"
                                        :placeholder="driverInformation.driver_zip">
                                </div>
                            </div>
                            <div class="flex justify-end text-center p-7">
                                <button
                                    class="flex flex-col justify-center items-center w-1/2 p-2 text-sm bg-[#550514] text-white rounded-lg">Update
                                    Profile</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </SRContents>
</template>

<script setup>
import icons from '@/assets/icons.js';
import SRContents from "@/layouts/SRContents.vue";
import SRProfile from '@/components/SRProfile.vue';
import SRModalSlots from '@/components/SRModalSlots.vue'
import { onMounted, ref } from 'vue';
import { driverRetrieveData, getReviews } from '@/services/ApiServices.js';

let isOpen = ref(Boolean);
let isEditModeOn = ref(false);
let DeleteProfile = ref(false);
let pfp = ref('');
let driverInformation = ref([]);

function editProfile() {
    isEditModeOn.value = true;
}

const reviews = ref([]);
const averageRating = ref(0);
const totalReviews = ref(0);

function reviewsInfo() {
    const reviewData = getReviews();
    reviewData.then((reviewsInfo) => {
        const filteredReviews = reviewsInfo.result.filter(review => review.driver_id === driverInformation.value.driverID);
        totalReviews.value = filteredReviews.length;
        const sumOfRatings = filteredReviews.reduce((sum, review) => sum + parseInt(review.rating, 10), 0);
        averageRating.value = totalReviews.value > 0 ? (sumOfRatings / totalReviews.value).toFixed(2) : 0;

        console.log("Reviewses:", filteredReviews);
        console.log("Total Reviews:", totalReviews.value);
        console.log("Average Rating:", averageRating.value);
    }).catch((error) => {
        console.error('Error fetching data:', error);
    });
}

function load() {
    try {
        const driverData = driverRetrieveData();
        driverData.then((compData) => {
            console.log(compData);
            pfp.value = compData.result.driver_userPhoto;
            driverInformation.value = compData.result;
            console.log('Current User:', driverInformation.value);
            reviewsInfo();
        }).catch((error) => {
            console.error('Error fetching data:', error);
        });
    } catch (error) {
        console.error('An error occurred:', error);
    }
}

onMounted(load)
</script>

<style lang="scss" scoped>
.show {
    display: block;
}

.hide {
    display: none;
}

label.label input[type="file"] {
    position: absolute;
    top: -1000px;
}

.label {
    cursor: pointer;
    border: 1px solid #cccccc;
    border-radius: 5px;
    padding: 5px 15px;
    margin: 5px;
    background: #dddddd;
    display: inline-block;
}

.label:hover {
    background: #550514;
    color: #ffffff;
}

.label:active {
    background: #550514;
}

.label:invalid+span {
    color: #000000;
}

.label:valid+span {
    color: #ffffff;
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