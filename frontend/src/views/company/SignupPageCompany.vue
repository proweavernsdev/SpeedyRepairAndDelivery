<template>
    <div
        class="flex justify-center h-screen items-center  bg-gradient-to-r from-[#550514] to-[#AA0927] md:from-[#550514] md:to-[#550514]">
        <div class="flex w-4/5 h-4/5">
            <div class="flex flex-col justify-center w-1/2 gap-5 bg-[#1C0207] px-20 rounded-l-xl">
                <h1 class="w-3/6 text-5xl leading-normal text-white">Speedy Repair and Delivery</h1>
                <p class="text-lg text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate
                    voluptatibus repellat, eos quod in provident blanditiis deserunt maiores, ea voluptatem sequi earum
                    neque repudiandae ducimus aliquam unde esse eaque fugit asperiores sit! Quod sint inventore, modi
                    ducimus ex quis sunt. Praesentium harum neque nostrum, debitis ipsum veniam vitae? Rem, libero.</p>
            </div>
            <div class="flex flex-col items-center justify-center w-1/2 gap-5 bg-white rounded-r-xl">
                <p class="py-10 text-2xl text-black"><b> SIGN UP</b></p>
                <form class="flex flex-col items-center justify-center w-1/2 gap-4"
                    @submit.prevent="sendLogin(formData.CompanyName, formData.Address, formData.Email, formData.Town_City, formData.State, formData.ZIP)">
                    <p class="text-lg font-bold ">Basic Information</p>
                    <div class="flex items-center w-full">
                        <label for="CompanyName" class="w-1/2 text-center text-md">Company Name:
                        </label>
                        <input type="text" id="CompanyName" name="CompanyName" v-model="formData.CompanyName"
                            class="w-1/2 h-10 p-1 pl-3 rounded-md shadow-sm focus:border-gray-400 focus:outline-none"
                            required>
                    </div>
                    <div class="flex items-center w-full">
                        <label for="Address" class="w-1/2 text-center text-md">Address: </label>
                        <input type="text" id="Address" name="Address" v-model="formData.Address"
                            class="w-1/2 h-10 p-1 pl-3 rounded-md shadow-sm focus:border-gray-400 focus:outline-none"
                            required>
                    </div>
                    <div class="flex items-center w-full">
                        <label for="Email" class="w-1/2 text-center text-md">Email: </label>
                        <input type="email" id="Email" name="Email" v-model="formData.Email"
                            class="w-1/2 h-10 p-1 pl-3 rounded-md shadow-sm focus:border-gray-400 focus:outline-none"
                            required>
                    </div>
                    <hr class="w-full h-px bg-gray-200 border-0 dark:bg-gray-700">
                    <p class="text-lg font-bold">Location</p>
                    <div class="flex w-full gap-4">
                        <div class="w-full">
                            <label for="Town_City" class="flex p-2 text-md">Town/City: </label>
                            <input type="text" id="Town_City" name="Town_City" v-model="formData.Town_City"
                                class="w-full h-10 p-1 pl-3 rounded-md shadow-sm focus:border-gray-400 focus:outline-none">
                        </div>
                    </div>
                    <div class="flex w-full gap-4">
                        <div class="w-3/4">
                            <label for="State" class="flex p-2 text-md">State: </label>
                            <input type="text" id="State" name="State" v-model="formData.State"
                                class="w-full h-10 p-1 pl-3 rounded-md shadow-sm focus:border-gray-400 focus:outline-none">
                        </div>
                        <div class="w-1/4">
                            <label for="ZIP" class="flex p-2 text-md">ZIP: </label>
                            <input type="number" min="1" max="999" id="ZIP" name="ZIP" v-model="formData.ZIP"
                                class="w-full h-10 p-1 pl-3 rounded-md shadow-sm focus:border-gray-400 focus:outline-none">
                        </div>
                    </div>
                    <button type="submit" class="w-full h-10 text-white bg-[#39030D] rounded-xl ">Sign In</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from "vue-router";
import axios from 'axios';

const formData = ref({
    CompanyName: '',
    Address: '',
    Email: '',
    Town_City: '',
    State: '',
    ZIP: '',
})

const router = useRouter();

async function sendLogin(CompanyName, Address, Email, Town_City, State, ZIP) {
    await axios.post('https://speedyrepairanddelivery.com/api-delivery/Users', toFormData({
        CompanyName: CompanyName,
        Address: Address,
        Email: Email,
        Town_City: Town_City,
        State: State,
        ZIP: ZIP
    })).then(response => {
        console.log("Registered.");
        console.log('Response:', response.data);
    })
        .catch(error => {
            console.log(CompanyName);
            console.log(Address);
            console.log(Email);
            console.log(Town_City);
            console.log(State);
            console.log(ZIP);
            console.error('Error:', error);
        });
}

function toFormData(obj) {
    const formData = new FormData();
    for (let o in obj) {
        formData.append(o, obj[o])
    }
    return formData
}
</script>


<style lang="scss" scoped>
form {
    width: 600px;
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