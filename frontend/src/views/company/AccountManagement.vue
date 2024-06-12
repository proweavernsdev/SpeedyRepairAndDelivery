<template>
    <SRModalSlots v-show="isOpen == true" @close="isOpen = false">
        <template #Modal-Header>
            <div class="flex justify-between px-5 py-5 bg-[#AA0927] text-white text-3xl font-semibold">
                <h2 v-show="DeleteProfile == true">Delete Company</h2>
                <span><button @click="isOpen = false" class="w-6">
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
                <div v-show="DeleteProfile == true" id="delete" class="pt-5 text-3xl font-bold text-center">
                    <h2>Are you sure you want to delete?</h2>
                </div>
            </div>
        </template>
        <template #Modal-Footer>
            <div class="flex justify-end w-full px-6 py-5">
                <div v-show="DeleteProfile == true">
                    <button
                        class="w-[223px] h-[64px] rounded-2xl bg-[#550514] text-2xl text-white font-bold hover:bg-rose-950">Delete</button>
                </div>
            </div>
        </template>
    </SRModalSlots>
    <SRContents>
        <template #Content-Header>
            <div class="flex flex-col gap-5">
                <h2 class="text-2xl">Account Management </h2>
                <div class="flex gap-x-2">
                    <h3 class="text-xl text-black">Profile</h3>
                </div>
            </div>
        </template>
        <template #Content-Body>
            <div class="flex flex-row justify-center h-full md:h-auto md:flex-col">
                <div class="w-1/3 m-2 rounded-md md:w-full">
                    <div id="viewAccount" class="flex flex-col w-full p-2 rounded-md shadow-sm" v-if="!isEditModeOn">
                        <div class="flex flex-col items-center my-2 text-center">
                            <SRProfile :image="pfp" :isEditModeOn="isEditModeOn" />
                        </div>
                        <p class="flex flex-col w-full">
                            <span class="m-2 text-base text-center">{{ companyInformation.comp_companyName }}</span>
                            <span class="m-2 text-base text-center">{{ companyInformation.comp_address }}</span>
                        </p>
                        <div class="p-5">
                            <div class="flex flex-row text-center">
                                <p class="flex flex-row w-full text-center">
                                    <span class="w-1/3 p-2 text-sm border">ID</span>
                                    <span class="flex items-center justify-center w-2/3 text-sm font-bold border">{{
                                        companyInformation.comp_zip
                                        }}</span>
                                </p>
                            </div>
                            <div class="flex flex-row text-center">
                                <p class="flex flex-row w-full text-center">
                                    <span class="w-1/3 p-2 text-sm border">STATE</span>
                                    <span class="flex items-center justify-center w-2/3 text-sm font-bold border">{{
                                        companyInformation.comp_state }}</span>
                                </p>
                            </div>
                            <div class="flex flex-row text-center">
                                <p class="flex flex-row w-full text-center">
                                    <span class="w-1/3 p-2 text-sm border">TOWN</span>
                                    <span class="flex items-center justify-center w-2/3 text-sm font-bold border ">{{
                                        companyInformation.comp_towity }}</span>
                                </p>
                            </div>
                            <div class="flex flex-row text-center">
                                <p class="flex flex-row w-full text-center">
                                    <span class="w-1/3 p-2 text-sm border">ZIP</span>
                                    <span class="flex items-center justify-center w-2/3 text-sm font-bold border ">{{
                                        companyInformation.comp_zip
                                        }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col items-center justify-center p-2">
                            <button class="w-2/3 p-2 text-sm bg-[#550514] text-white rounded-lg"
                                @click="editProfile">Update
                                Profile</button>
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
                                    <p class="flex items-center justify-center w-1/3 p-2 text-sm ">Company Name:</p>
                                    <input type="text" name="" id=""
                                        class="w-2/3 bg-[#E3D5D8] rounded-lg px-2 text-sm border  focus:ring focus:ring-[#C6ACB1] focus:border-gray-400 focus:outline-none"
                                        :placeholder="companyInformation.comp_companyName">
                                </div>
                                <div class="flex flex-row text-center">
                                    <p class="flex items-center justify-center w-1/3 p-2 text-sm">Company Address:</p>
                                    <input type="text" name="" id=""
                                        class="w-2/3 bg-[#E3D5D8] rounded-lg px-2 text-sm border  focus:ring focus:ring-[#C6ACB1] focus:border-gray-400 focus:outline-none"
                                        :placeholder="companyInformation.comp_address">
                                </div>
                            </div>
                            <div class="flex flex-col gap-2 px-2 py-2">
                                <div class="flex flex-row text-center">
                                    <p class="flex items-center justify-center w-1/3 p-2 text-sm">State: </p>
                                    <input type="text" name="" id=""
                                        class="w-2/3 bg-[#E3D5D8] rounded-lg px-2 text-sm border  focus:ring focus:ring-[#C6ACB1] focus:border-gray-400 focus:outline-none"
                                        :placeholder="companyInformation.comp_state">
                                </div>
                                <div class="flex flex-row text-center">
                                    <p class="flex items-center justify-center w-1/3 p-2 text-sm">Town / City:</p>
                                    <input type="text" name="" id=""
                                        class="w-2/3 bg-[#E3D5D8] rounded-lg px-2 text-sm border  focus:ring focus:ring-[#C6ACB1] focus:border-gray-400 focus:outline-none"
                                        :placeholder="companyInformation.comp_towity">
                                </div>
                                <div class="flex flex-row text-center">
                                    <p class="flex items-center justify-center w-1/3 p-2 text-sm">ZIP Code:</p>
                                    <input type="tel" name="" id=""
                                        class="w-2/3 bg-[#E3D5D8] rounded-lg px-2 text-sm border focus:ring focus:ring-[#C6ACB1] focus:border-gray-400 focus:outline-none"
                                        :placeholder="companyInformation.comp_zip">
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
                <div class="w-2/3 p-3 m-2 rounded-lg shadow-sm md:w-full">
                    <div class="m-3">
                        <h1 class="font-bold">LIST OF EMPLOYEES</h1>
                    </div>
                    <div>
                        <ul class="columns-2 md:columns-1" v-for="users in companySubUsersInformation" :key="users.id">
                            <li class="flex flex-row items-center justify-between gap-2 px-4 py-2 border">
                                <span class="flex items-center">
                                    <span v-if="users.subs_userPhoto === null || users.subs_userPhoto === ''"
                                        v-html="icons.UserProfile" alt=""
                                        class=" w-10 mx-4 border border-[#C6ACB1] rounded-full p-1.5"></span>
                                    <img v-else :src="users.subs_userPhoto" alt=""
                                        class=" w-10 mx-4 border border-[#C6ACB1] rounded-full">
                                    <p class="text-sm">{{ users.subs_firstName }} {{ users.subs_lastName }}</p>
                                </span>
                                <div class="flex items-center justify-end">
                                    <p v-html="icons.Active" v-show="users.status === 'active'" class="text-green-500">
                                    </p>
                                    <p v-html="icons.OnHold" v-show="users.status === 'on_hold'"
                                        class="text-yellow-500">
                                    </p>
                                </div>
                            </li>
                        </ul>
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
import { compRetrieveData, retrieveEmployee } from '@/services/ApiServices.js';

let isOpen = ref(Boolean);
let isEditModeOn = ref(false);
let DeleteProfile = ref(false);
let pfp = ref('');
let companyInformation = ref([]);
let companySubUsersInformation = ref([]);

function editProfile() {
    isEditModeOn.value = true;
}

function load() {
    try {
        const companyData = compRetrieveData();
        companyData.then((compData) => {
            pfp.value = compData.result.comp_businessPhoto;
            companyInformation.value = compData.result;
            console.log('Current User:', companyInformation.value);
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
</style>