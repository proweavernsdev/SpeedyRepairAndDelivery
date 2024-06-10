<template>
    <div class="flex justify-center h-screen items-center  bg-[#550514]">
        <div class="flex w-full max-w-[1200px]">
            <div id="otp-page" class="flex items-center justify-center flex-col h-screen gap-5 bg-[#550514] w-full">
                <i v-html="icons.OTP"></i>
                <p class="text-base text-white">Check your email for the one-time password (OTP). Enter the OTP below to
                    complete your signup.
                </p>
                <form class="flex flex-col items-center justify-center w-1/3 gap-7" @submit.prevent="loginAuth(otp)">
                    <input type="email" id="name" v-model="otp"
                        class="w-full h-12 pl-3 text-center border-black rounded-md shadow-sm shadow-black outline-1 focus:outline-none focus:border-gray-400 "
                        placeholder="OTP">
                    <button type="submit" class="w-full h-10 bg-white rounded hover:bg-[#D9D9D9]">Confirm Email</button>
                </form>
                <p class="text-white">Back to the
                    <router-link to="/signup">
                        <a href="http://" target="_blank" rel="noopener noreferrer" class="underline">Signup Page</a>
                    </router-link>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import icons from '@/assets/icons.js'
import { useRouter } from 'vue-router';
import axios from 'axios';
import { ref } from 'vue';

const router = useRouter();
const email = ref('');
const password = ref('');
const otp = ref('');

async function sendLogin(lemail, lpassword, lotp) {
    try {
        if (lotp) {
            const response = await axios.post('https://speedyrepairanddelivery.com/api-delivery/Users', {
                email: lemail,
                password: lpassword,
                otp: lotp
            });
            console.log('LOGGED IN.');
            router.push('/dashboard');
        } else {
            const response = await axios.post('https://speedyrepairanddelivery.com/api-delivery/Users', {
                email: lemail,
                password: lpassword
            });
            console.log('LOGGED IN.');
            router.push('/dashboard');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}


</script>



<style lang="scss" scoped>
</style>