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
          <button class="w-[223px] h-[64px] rounded-2xl bg-[#aa0927] text-2xl text-white font-bold hover:bg-rose-950">
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
        <div class="flex text-2xl text-black gap-x-2">
          <h3>Profile</h3>
        </div>
      </div>
    </template>
    <template #Content-Body>
      <div class="flex flex-col items-center justify-center">
        <div id="account" class="flex flex-col w-4/5 pb-8 rounded-md md:w-full">
          <div class="flex justify-end">
            <button class="p-2 m-2 text-white bg-[#aa0927] rounded-lg" @click="editProfile"
              v-if="!isEditModeOn == true">Update
              Profile</button>
            <button class="p-2 m-2 text-[#DB073D] border-2 border-[#DB073D] rounded-lg" @click="editProfile"
              v-else>Cancel</button>
          </div>
          <div class="flex flex-col w-full">
            <div class="flex flex-col items-center justify-center gap-5 px-5 py-2 [&>*]:md:items-start md:gap-1">
              <div class="flex flex-row items-center justify-center w-[90%] text-center md:flex-col md:justify-start">
                <div class="flex justify-center w-2/3 md:w-full">
                  <SRProfile :image="pfp" :isEditModeOn="isEditModeOn" />
                </div>
              </div>
              <div class="flex flex-row items-center justify-center w-[90%] text-center md:flex-col md:justify-start">
                <p class="w-1/3 p-2 text-lg md:text-left md:w-full">First Name:</p>
                <div class="w-2/3 md:w-full">
                  <p v-if="!isEditModeOn == true" class="p-2 text-left border-b-2">Hi</p>
                  <input type="text" name="" id=""
                    class="w-full p-2 text-left border-b-2 focus:border-gray-400 focus:bg-gray-100 focus:outline-none"
                    v-else />
                </div>
              </div>
              <div class="flex flex-row items-center justify-center w-[90%] text-center md:flex-col md:justify-start">
                <p class="w-1/3 p-2 text-lg md:text-left md:w-full">Last Name:</p>
                <div class="w-2/3 md:w-full">
                  <p v-if="!isEditModeOn == true" class="p-2 text-left border-b-2">Hi</p>
                  <input type="text" name="" id=""
                    class="w-full p-2 text-left border-b-2 focus:border-gray-400 focus:bg-gray-100 focus:outline-none"
                    v-else />
                </div>
              </div>
              <div class=" flex flex-row items-center justify-center w-[90%] text-center md:flex-col md:justify-start">
                <p class="w-1/3 p-2 text-lg md:text-left md:w-full">Address:</p>
                <div class="w-2/3 md:w-full">
                  <p v-if="!isEditModeOn == true" class="p-2 text-left border-b-2">Hi</p>
                  <input type="text" name="" id=""
                    class="w-full p-2 text-left border-b-2 focus:border-gray-400 focus:bg-gray-100 focus:outline-none"
                    v-else />
                </div>
              </div>
              <div class=" flex flex-row items-center justify-center w-[90%] text-center md:flex-col md:justify-start">
                <p class="w-1/3 p-2 text-lg md:text-left md:w-full">State:</p>
                <div class="w-2/3 md:w-full">
                  <p v-if="!isEditModeOn == true" class="p-2 text-left border-b-2">Hi</p>
                  <input type="text" name="" id=""
                    class="w-full p-2 text-left border-b-2 focus:border-gray-400 focus:bg-gray-100 focus:outline-none"
                    v-else />
                </div>
              </div>
              <div class=" flex flex-row items-center justify-center w-[90%] text-center md:flex-col md:justify-start">
                <p class="w-1/3 p-2 text-lg md:text-left md:w-full">Town:</p>
                <div class="w-2/3 md:w-full">
                  <p v-if="!isEditModeOn == true" class="p-2 text-left border-b-2">Hi</p>
                  <input type="text" name="" id=""
                    class="w-full p-2 text-left border-b-2 focus:border-gray-400 focus:bg-gray-100 focus:outline-none"
                    v-else />
                </div>
              </div>
              <div class=" flex flex-row items-center justify-center w-[90%] text-center md:flex-col md:justify-start">
                <p class="w-1/3 p-2 text-lg md:text-left md:w-full">ZIP:</p>
                <div class="w-2/3 md:w-full">
                  <p v-if="!isEditModeOn == true" class="p-2 text-left border-b-2">Hi</p>
                  <input type="text" name="" id=""
                    class="w-full p-2 text-left border-b-2 focus:border-gray-400 focus:bg-gray-100 focus:outline-none"
                    v-else />
                </div>
              </div>
            </div>
            <div
              class=" flex justify-end gap-5 p-5 text-center [&>*]:flex [&>*]:flex-col [&>*]:items-center
                          [&>*]:justify-center [&>*]:w-1/5 [&>*]:p-2 [&>*]:text-sm [&>*]:rounded-lg md:justify-center md:flex-col [&>*]:md:w-full "
              v-if="isEditModeOn == true">
              <button class=" text-white bg-[#AA0927] border-2 hover:scale-105">
                Update Profile
              </button>
              <button class=" bg-white border-2 border-[#AA0927]  text-[#AA0927] hover:scale-105">
                Delete Account
              </button>
            </div>
          </div>
        </div>
      </div>
    </template>
  </SRContents>
</template>

<script setup>
import SRProfile from '@/components/SRProfile.vue';
import SRContents from "@/layouts/SRContents.vue";
import SRModalSlots from "@/components/SRModalSlots.vue";
import { retrieveData } from "@/services/ApiServices.js";
import { onMounted, ref } from "vue";

let isOpen = ref(false);
let DeleteProfile = ref(false);
let isEditModeOn = ref(false);
let pfp = ref('');
let adminInformation = ref([]);

function editProfile() {
  isEditModeOn.value = !isEditModeOn.value;
}

function load() {
  try {
    const currentAdminData = retrieveData();
    currentAdminData.then((adminData) => {
      pfp.value = adminData.result;
      adminInformation.value = adminData.result;
      console.log('Users from company:', adminInformation.value);
    }).catch((error) => {
      console.error('Error fetching data:', error);
    });
  } catch (error) {
    console.error('An error occurred:', error);
  }
}

onMounted(load);
</script>

<style lang="scss" scoped>
* {
  //border: 1px solid red;
}
</style>
