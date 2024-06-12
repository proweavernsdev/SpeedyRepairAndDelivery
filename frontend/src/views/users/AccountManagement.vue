<template>
    <SRModalSlots v-show="isOpen" @close="isOpen = false">
        <template #Modal-Header>
            <div class="flex justify-between px-5 py-5 bg-[#AA0927] text-white text-3xl font-semibold">
                <h2 v-if="DeleteProfile">Delete driver</h2>
                <span>
                    <button @click="isOpen = false" class="w-6">
                        <svg class="hover:scale-105" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <line x1="10" y1="10" x2="90" y2="90" stroke="currentColor" stroke-width="5" />
                            <line x1="90" y1="10" x2="10" y2="90" stroke="currentColor" stroke-width="5" />
                        </svg>
                    </button>
                </span>
            </div>
        </template>
        <template #Modal-Body>
            <div class="mx-6 mb-6">
                <div v-if="DeleteProfile" id="delete" class="pt-5 text-3xl font-bold text-center">
                    <h2>Are you sure you want to delete?</h2>
                </div>
            </div>
        </template>
        <template #Modal-Footer>
            <div class="flex justify-end w-full px-6 py-5">
                <div v-if="DeleteProfile">
                    <button
                        class="w-[223px] h-[64px] rounded-2xl bg-[#550514] text-2xl text-white font-bold hover:bg-rose-950">
                        Delete
                    </button>
                </div>
            </div>
        </template>
    </SRModalSlots>
    <SRContents>
        <template #Content-Header>
            <div class="flex flex-col gap-5">
                <h2>Account Management</h2>
                <div class="flex gap-x-2">
                    <h3>Profile</h3>
                </div>
            </div>
        </template>
        <template #Content-Body>
            <div class="flex flex-row justify-center h-full">
                <div class="w-full m-2 rounded-md">
                    <div id="viewAccount" class="flex flex-col w-full p-2 rounded-md shadow-sm" v-if="!isEditModeOn">
                        <div class="flex flex-col items-center my-2 text-center">
                            <SRProfile :image="pfp" :isEditModeOn="isEditModeOn" />
                        </div>
                        <p class="flex flex-col w-full">
                            <span class="m-2 text-base text-center">{{ customerInformation.cust_firstName }}
                                {{ customerInformation.cust_lastName }}</span>
                            <span class="m-2 text-base text-center">{{ customerInformation.cust_address }}</span>
                        </p>
                        <div class="p-5">
                            <div class="flex flex-row text-center">
                                <p class="flex flex-row w-full text-center">
                                    <span class="w-1/3 p-2 text-sm border"><strong>ID</strong></span>
                                    <span class="flex items-center justify-center w-2/3 text-sm font-bold border">{{
                                        customerInformation.customerID }}</span>
                                </p>
                            </div>
                            <div class="flex flex-row text-center">
                                <p class="flex flex-row w-full text-center">
                                    <span class="w-1/3 p-2 text-sm border"><strong>STATE</strong></span>
                                    <span class="flex items-center justify-center w-2/3 text-sm font-bold border">{{
                                        customerInformation.cust_state }}</span>
                                </p>
                            </div>
                            <div class="flex flex-row text-center">
                                <p class="flex flex-row w-full text-center">
                                    <span class="w-1/3 p-2 text-sm border"><strong>TOWN</strong></span>
                                    <span class="flex items-center justify-center w-2/3 text-sm font-bold border">{{
                                        customerInformation.cust_towity }}</span>
                                </p>
                            </div>
                            <div class="flex flex-row text-center">
                                <p class="flex flex-row w-full text-center">
                                    <span class="w-1/3 p-2 text-sm border"><strong>ZIP</strong></span>
                                    <span class="flex items-center justify-center w-2/3 text-sm font-bold border">{{
                                        customerInformation.cust_zip }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col items-center justify-center p-2">
                            <button class="w-2/3 p-2 text-sm bg-[#550514] text-white rounded-lg" @click="editProfile">
                                Update Profile
                            </button>
                        </div>
                    </div>
                    <div id="editAccount" class="flex flex-col w-full p-2 rounded-md shadow-sm" v-else>
                        <div class="flex flex-row items-start justify-between">
                            <div class="flex flex-row items-center justify-center w-full my-2">
                                <div class="flex justify-center w-1/3 mx-5">
                                    <SRProfile :image="pfp" :isEditModeOn="isEditModeOn" />
                                </div>
                            </div>
                            <div class="flex m-2 hover:scale-105">
                                <span>
                                    <button @click="isEditModeOn = false" class="w-6">
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
                        <form class="flex flex-col w-full" @submit.prevent="updateProfile">
                            <div class="flex flex-col gap-2 px-2 py-2">
                                <div class="flex flex-row text-center">
                                    <p class="flex items-center justify-center w-1/3 p-2 text-sm">First Name:
                                    </p>
                                    <input type="text" v-model="cust_firstName"
                                        class="w-2/3 bg-[#E3D5D8] rounded-lg px-2 text-sm border focus:ring focus:ring-[#C6ACB1] focus:border-gray-400 focus:outline-none"
                                        :placeholder="customerInformation.cust_firstName">
                                </div>
                                <div class="flex flex-row text-center">
                                    <p class="flex items-center justify-center w-1/3 p-2 text-sm">Last Name:
                                    </p>
                                    <input type="text" v-model="cust_lastName"
                                        class="w-2/3 bg-[#E3D5D8] rounded-lg px-2 text-sm border focus:ring focus:ring-[#C6ACB1] focus:border-gray-400 focus:outline-none"
                                        :placeholder="customerInformation.cust_lastName">
                                </div>
                                <div class="flex flex-row text-center">
                                    <p class="flex items-center justify-center w-1/3 p-2 text-sm">Address:</p>
                                    <input type="text" v-model="cust_address"
                                        class="w-2/3 bg-[#E3D5D8] rounded-lg px-2 text-sm border focus:ring focus:ring-[#C6ACB1] focus:border-gray-400 focus:outline-none"
                                        :placeholder="customerInformation.cust_address">
                                </div>
                            </div>
                            <div class="flex flex-col gap-2 px-2 py-2">
                                <div class="flex flex-row text-center">
                                    <p class="flex items-center justify-center w-1/3 p-2 text-sm">State:</p>
                                    <input type="text" v-model="cust_state"
                                        class="w-2/3 bg-[#E3D5D8] rounded-lg px-2 text-sm border focus:ring focus:ring-[#C6ACB1] focus:border-gray-400 focus:outline-none"
                                        :placeholder="customerInformation.cust_state">
                                </div>
                                <div class="flex flex-row text-center">
                                    <p class="flex items-center justify-center w-1/3 p-2 text-sm">Town / City:</p>
                                    <input type="text" v-model="cust_towity"
                                        class="w-2/3 bg-[#E3D5D8] rounded-lg px-2 text-sm border focus:ring focus:ring-[#C6ACB1] focus:border-gray-400 focus:outline-none"
                                        :placeholder="customerInformation.cust_towity">
                                </div>
                                <div class="flex flex-row text-center">
                                    <p class="flex items-center justify-center w-1/3 p-2 text-sm">ZIP Code:</p>
                                    <input type="number" max="99999" min="0" v-model="cust_zip"
                                        class="w-2/3 bg-[#E3D5D8] rounded-lg px-2 text-sm border focus:ring focus:ring-[#C6ACB1] focus:border-gray-400 focus:outline-none"
                                        :placeholder="customerInformation.cust_zip">
                                </div>
                            </div>
                            <div class="flex justify-end text-center p-7">
                                <button type="submit"
                                    class="flex flex-col justify-center items-center w-1/2 p-2 text-sm bg-[#550514] text-white rounded-lg">
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </SRContents>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import SRContents from "@/layouts/SRContents.vue";
import SRProfile from '@/components/SRProfile.vue';
import SRModalSlots from '@/components/SRModalSlots.vue';
import { customerRetrieveData, updateCustomer } from '@/services/ApiServices.js';
import { update } from 'firebase/database';

let isOpen = ref(false);
let isEditModeOn = ref(false);
let DeleteProfile = ref(false);
let pfp = ref('');
let customerInformation = ref({});
let cust_firstName = ref('');
let cust_lastName = ref('');
let cust_address = ref('');
let cust_state = ref('');
let cust_towity = ref('');
let cust_zip = ref('');


function editProfile() {
    isEditModeOn.value = true;
}

function updateProfile() {
    try {
        const customerData = {
            cust_firstName: cust_firstName.value,
            cust_lastName: cust_lastName.value,
            cust_address: cust_address.value,
            cust_state: cust_state.value,
            cust_towity: cust_towity.value,
            cust_zip: cust_zip.value
        }

        const response = updateCustomer(customerData);
        response.then((data) => {
            console.log(data);
        }).catch((error) => {
            console.log(error);
        })
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

async function load() {
    try {
        const customerData = await customerRetrieveData();
        pfp.value = customerData.data.cust_userPhoto;
        customerInformation.value = customerData.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}



onMounted(load);
</script>

<style scoped>
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
</style>
