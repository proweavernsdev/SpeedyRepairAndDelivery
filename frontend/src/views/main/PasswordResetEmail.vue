<template>
    <div id="error" class="flex items-center justify-center bg-[#550514]">
        <div class="flex flex-col items-center justify-center w-full h-screen gap-5 px-2">
            <i v-html="icons.PassEmail"></i>
            <h1 class="text-3xl font-bold text-white md:text-center">Reset your password</h1>
            <p class="text-base text-white md:text-center">Enter your email and we’ll send you instructions on how to
                reset your
                password.
            </p>
            <form class="flex flex-col items-center justify-center gap-7 w-96 md:w-full"
                @submit.prevent="loginAuth(email)">
                <input type="email" id="name" v-model="email"
                    class="w-full h-12 pl-3 text-center border-black rounded-md shadow-sm shadow-black outline-1 focus:outline-none focus:border-gray-400 "
                    placeholder="Email Address" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Invalid email address">
                <button type="submit"
                    class="w-full h-10 bg-white rounded hover:bg-[#D9D9D9] focus:border-gray-400 focus:outline-none">Reset
                    Password</button>
            </form>
            <p class="text-white">Back to the
                <router-link to="/login">
                    <a href="http://" target="_blank" rel="noopener noreferrer" class="underline">Login Page</a>
                </router-link>
            </p>
        </div>
    </div>
</template>
<script setup>
import icons from '@/assets/icons.js';
import axios from "axios";
import { ref } from 'vue';
import { useRouter } from 'vue-router';



const base = "https://speedyrepairanddelivery.com/api-delivery/Users";
const email = ref('');
const router = useRouter();

async function loginAuth(email) {
    try {
        const res = await axios.put(base, {
            update_access: false,
            update_passwordAccMgt: false,
            forgot_password: true,
            email: email,
            newPassword: "",
            confPassword: "",
            forget_password_token: "",
        });
        console.log("Email sent.");
        setTimeout(() => {
            console.log("Redirecting to login page...");
            router.push("/login");
        }, 10000);
    } catch (e) {
        console.error("Error:", e);
    }
}


</script>
<style lang="scss" scoped></style>