<template>
    <div id="error" class="flex items-center justify-center flex-col h-screen gap-5 bg-[#550514]">
        <div class="flex flex-col gap-10 justify-center h-4/5">
            <div class="text-center">
                <p class="text-white">{{ prompt }}</p>
                <h1 class="text-white">{{ header }}</h1>
            </div>
            <div class="flex gap-10 flex-wrap items-center justify-center">
                <button id="company" class="flex flex-col w-full p-10 justify-center rounded-md shadow-sm bg-white">
                    Company
                </button>
                <button id="customer" class="flex flex-col w-full p-10 justify-center rounded-md shadow-sm bg-white">
                    Customer
                </button>
                <button id="driver" class="flex flex-col w-full p-10 justify-center rounded-md shadow-sm bg-white">
                    Driver
                </button>
            </div>
        </div>
        <div class="flex w-full justify-between ">
            <button @click="goBack" class="rounded-full shadow-sm bg-white w-12 h-12 mx-5">←</button>
            <button @click="proceed" class="rounded-full shadow-sm bg-white w-12 h-12 mx-5">→</button>
        </div>
    </div>
</template>
<script setup>
import axios from "axios";
import { ref, reactive, } from 'vue'; // Use reactive for userTypes
import { useRoute } from 'vue-router';

const base = "https://speedyrepairanddelivery.com/api-delivery/Users";
const email = ref('');
const header = ref('USER TYPE');
const prompt = ref('Please select your');
const userTypes = ref({
    'Company User': '/src/assets/company.png',
    'Customer': '/src/assets/customer.png',
    'Driver': '/src/assets/driver.png'
});


const route = useRoute();
console.log("Hi!");
const myFunction = () => {
    console.log("Hi!");
    const urlData = route.query.data
    if (urlData) {
        const params = new URLSearchParams(url);
        const dataValue = params.get("data");
        console.log(`The value of the 'data' parameter is: ${dataValue}`);
        console.log("Received data from query parameter:", route.params.data);
    }
};
onMounted(() => { myFunction });
</script>
<style scoped>
* {}
</style>