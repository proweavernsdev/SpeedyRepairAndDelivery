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
                <div class="border-2 rounded-md bg-slate-100 h-96 md:h-48"></div>
            </div>
            <div class="flex flex-col justify-center sm:w-1/2">
                <p class="font-semibold sm:text-xs">Item delivered successfully</p>
                <p class="text-sm sm:text-xs">Recipient: John Doe</p>
            </div>
        </div>
        <div class="flex flex-col justify-center gap-1 sm:w-1/2">
            <p class="font-semibold sm:text-xs">Add Notes or Upload Confirmation:</p>
            <input type="text" name="notes" id="notes"
                class="w-full p-2 border-2 focus:outline-none h-auto focus:border-[#AA0927]">
        </div>
        <div class="flex justify-center my-5">
            <RouterLink to="/rider/requests/1/success"
                class="w-full p-2 m-auto border-2 rounded-lg sm:text-sm text-white text-center bg-[#AA0927] hover:opacity-75">
                Confirm Delivery
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