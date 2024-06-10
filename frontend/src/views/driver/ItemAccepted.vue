<template>
    <div class="flex flex-col w-full h-auto pt-5 overflow-y-auto md:flex-col md:justify-start ">
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
                        <button class="p-1 border-2 rounded-sm sm:text-xs bg-slate-50 hover:opacity-75">Get
                            Directions</button>
                    </div>
                    <div class="border-2 rounded-md bg-slate-100 h-96 md:h-48"></div>
                </div>

            </div>
            <div class="flex flex-col items-center justify-center gap-5 sm:w-1/2">
                <div class="flex justify-evenly w-full [&>*]:w-[40%] [&>*]:p-1">
                    <button class="text-white bg-red-700 rounded-md md:text-sm hover:opacity-75">Contact
                        Pickup</button>
                    <button class="text-red-700 border-2 border-red-700 rounded-md md:text-sm hover:opacity-75">Contact
                        Drop-off</button>
                </div>
                <p class="sm:text-xs">Note: Please ensure to verify all addresses before contacting.</p>
            </div>
        </div>
        <div class="flex justify-center">
            <RouterLink to="/rider/requests/1/success"
                class="w-11/12 p-2 m-auto border-2 text-center rounded-lg sm:text-sm text-[#AA0927] bg-slate-200 hover:opacity-75">
                Delivery Location Arrived
            </RouterLink>
        </div>
    </div>
</template>

<script setup>
import icons from '@/assets/icons.js';
import { useRouter } from 'vue-router';

const router = useRouter();

function goBack() {
    router.go(-1);
}
</script>

<style lang="scss" scoped>
* {
    //border: 1px solid red;
}
</style>