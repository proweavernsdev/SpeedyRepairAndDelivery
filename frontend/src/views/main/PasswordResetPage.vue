<template>
    <div id="reset" class="flex items-center justify-center flex-col h-screen gap-5 bg-[#550514]">
        <div id="card" class="flex flex-col gap-5 w-[449px] h-[581px] justify-center text-center bg-white px-20">
            <h1 class="text-2xl font-bold">Speedy Repair and Delivery</h1>
            <h3 class="text-xl">Change your Password</h3>
            <p class="text-xs">Enter a new password below to change your password.</p>
            <form @submit.prevent="getInfo(password, confirmPassword)" class="flex flex-col gap-5">
                <input type="password" name="password" id="password" placeholder="Password" v-model="password"
                    class="h-12 px-2 focus:outline-[#AA0927] focus:border-gray-400 focus:outline-none" required>
                <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password"
                    v-model="confirmPassword"
                    class="h-12 px-2 focus:outline-[#AA0927] focus:border-gray-400 focus:outline-none" required>
                <button type="submit" class="px-4 py-2 font-bold text-white bg-red-800 rounded hover:bg-red-900">Reset
                    Password</button>
            </form>
            <router-link to="/login">
                <button class="w-full h-10 hover:bg-[#D9D9D9]">
                    Cancel
                </button>
            </router-link>
        </div>
    </div>

</template>
<script setup>

import axios from "axios";
import { ref } from 'vue';
import { useRoute } from 'vue-router'

const base = "https://speedyrepairanddelivery.com/api-delivery/Users";
const password = ref('');
const confirmpassword = ref('');
const urlParams = new URLSearchParams(window.location.search);
const token = urlParams.get('marker');
const decodedToken = decodeURIComponent(token);

const router = useRoute();
async function getInfo(password, confirmpassword) {
    try {
        const res = await axios.put(base, {
            update_access: false,
            update_passwordAccMgt: false,
            forgot_password: true,
            newPassword: password,
            confPassword: confirmpassword,
            forget_password_token: decodedToken,
        });
        console.log(token)
        console.log("New Password Set.");
        router.push('/login');
    } catch (e) {
        console.log(token);
        console.error("Error:", e);
    }
}

</script>
<style lang="scss" scoped>
* {
    color: black;
}

div#reset *,
div#card * {
    border-radius: 5px;
}

#code::placeholder {
    text-align: center;
}

input,
button {
    border: 1px solid #D9D9D9;
}
</style>