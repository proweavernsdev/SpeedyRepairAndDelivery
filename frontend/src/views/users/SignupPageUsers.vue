<template>
    <div
        class="flex justify-center h-screen items-center  bg-gradient-to-r from-[#550514] to-[#AA0927] md:from-[#550514] md:to-[#550514]">
        <SRSignUpModals v-show="isOpen == true">
            <template #Icon>
                <i class="w-[125px] h-[125px]" v-html="icons.OTP"></i>
            </template>
            <template #Description>
                <p class="text-base text-white">Check your email for the one-time password (OTP). Enter the OTP below to
                    complete your signup.
                </p>
            </template>
            <template #Form>
                <form class="flex flex-col items-center justify-center w-1/3 gap-7"
                    @submit.prevent="sendLogin(email, password, otp)">
                    <input type="text" id="name" v-model="otp"
                        class="w-full h-12 pl-3 text-center border-black rounded-md shadow-sm shadow-black outline-1 focus:border-gray-400 focus:outline-none"
                        placeholder="OTP">
                    <button type="submit" class="w-full h-10 bg-white rounded hover:bg-[#D9D9D9]">Confirm Email</button>
                </form>
            </template>
            <template #Footer>
                <div class="text-center">
                    <p class="text-sm text-white" id="getOTP">Didnt received an OTP? <a
                            @click="sendLogin(email, password)" class="underline">Click HERE</a>
                    </p>
                    <p class="hidden text-sm text-white" id="countdown" v-show="isOpen == true"></p>
                    <p class="text-sm text-white">Back to the
                        <router-link to="/signup">
                            <a href="http://" target="_blank" rel="noopener noreferrer" class="underline">Signup
                                Page</a>
                        </router-link>
                    </p>
                </div>
            </template>
        </SRSignUpModals>
        <div id="signup" class="flex max-w-[500px] w-full md:justify-center md:gap-7 rounded-lg">
            <div
                class="flex flex-col justify-center text-center w-full gap-5 bg-white p-10 rounded-lg md:p-0 md:m-5 md:w-full  md:rounded-xl md:bg-[#550514]">
                <h1 class="py-5 text-3xl leading-snug text-[#1C0207] md:text-white">
                    <b>
                        Speedy
                        Repair
                        and
                        Delivery</b>
                </h1>
                <p class="text-xl text-black md:py-0 md:text-white md:text-xl"><b>Create an account</b></p>
                <form class="flex flex-col items-center justify-center w-full gap-3 max-w-1/3 md:gap-4"
                    @submit.prevent="sendLogin(email, password, otp)">
                    <p class="text-lg font-bold ">
                        <span id="otp-desc" class="hidden text-center">Check your email for the one-time
                            password
                            (OTP). Enter the
                            OTP below to
                            complete your signup.</span>
                        <span id="otp-desc2" class="md:hidden"></span>
                    </p>
                    <p id="otp-desc" class="hidden text-base text-white">
                    </p>
                    <div class="flex flex-col items-center w-full max-w-full" id="email">
                        <label for="email" class="w-full max-w-full px-2 py-1 text-left text-md md:text-white">Email:
                        </label>
                        <input type="email" v-model="email"
                            class="w-full h-10 p-1 pl-3 rounded-md shadow-sm max-w-1/3 focus:border-gray-400 focus:outline-none"
                            pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Invalid email address" required>
                    </div>
                    <div class="flex flex-col items-center w-full max-w-full " id="pass">
                        <label for="password"
                            class="w-full max-w-full px-2 py-1 text-left text-md md:text-white">Password:
                        </label>
                        <input type="password" v-model="password"
                            class="w-full h-10 max-w-full p-1 pl-3 rounded-md shadow-sm focus:outline-none focus:border-gray-400 "
                            required>
                    </div>
                    <div class="flex items-center justify-center w-full max-w-full">
                        <input v-model="otp" id="otp" type="text" placeholder="OTP"
                            class="hidden w-full h-10 text-center rounded-md shadow-sm focus:outline-none">
                    </div>
                    <button type="submit" class="w-full h-10 text-white bg-[#39030D] rounded-xl md:bg-[#AA0927]">
                        <span v-if="otp" value="">Confirm signup</span>
                        <span v-else>Sign Up</span>
                    </button>
                </form>
                <div class="flex w-full">
                    <p class="p-2 text-sm text-left md:text-white">Already have an account? <router-link to="/login">
                            <span class="text-[#39030D] active:underline hover:underline md:text-[#AA0927]">
                                Login
                            </span>
                        </router-link></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import SRSignUpModals from "@/components/SRSignUpModals.vue";
import { useRouter } from 'vue-router';
import axios from 'axios';
import { ref } from 'vue';
import icons from '@/assets/icons';
import firebaseApp from "../../services/firebase";
import { getAuth, createUserWithEmailAndPassword, sendEmailVerification } from "firebase/auth";
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import { register } from '@/services/ApiServices';
const isOpen = ref(false);
const email = ref('');
const password = ref('');
const otp = ref('');
const $toast = useToast();
const router = useRouter();

// Function to handle signup
async function sendLogin(lemail, lpassword) {
    try {
        const data = await register(lemail, lpassword);
        console.log("User created:", data);
        $toast.info('Please check your email for verification');
        setTimeout(() => { router.push('/login') }, 5000);
    } catch (error) {
        console.error("Error creating user:", error.message);
        $toast.warning('Email already exists');
    }
}


// Function to close modal
function close() {
    isOpen.value = false;
}

// Function to open modal
function open() {
    isOpen.value = true;
}
</script>

<style lang="scss" scoped>
* {
    //border: 1px solid red;
}

.show {
    border: 1px solid red;
}
</style>
