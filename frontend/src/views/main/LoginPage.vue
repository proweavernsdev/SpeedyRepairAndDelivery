<template>
    <div class="flex justify-center items-center w-screen h-screen bg-gradient-to-r from-[#550514] to-[#AA0927] md:bg-[#550514]">
        <div class="flex w-full max-w-[500px] justify-center gap-7 rounded-lg">
            <div class="flex flex-col items-center w-full gap-5 p-10 text-center bg-white rounded-lg md:m-5 md:p-0 md:rounded-xl md:bg-[#550514]">
                <h1 class="py-5 text-3xl text-[#1C0207] md:text-white font-bold leading-snug">
                    Speedy Repair and Delivery
                </h1>
                <form class="flex flex-col w-full gap-5" @submit.prevent="login(email, pass)">
                    <input type="email" id="name" v-model="email" class="w-full h-12 pl-3 pr-11 rounded-md shadow-sm focus:border-gray-400 focus:outline-none md:h-9" placeholder="Email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Invalid email address" required>
                    <div class="flex items-center justify-end">
                        <input type="password" id="pass" v-model="pass" class="w-full h-12 pl-3 pr-11 rounded-md shadow-sm focus:border-gray-400 focus:outline-none md:h-9" placeholder="Password" required>
                        <i id="open" class="absolute w-7 h-7 mx-2 float-right cursor-pointer" v-html="icons.Eye" @click="togglePasswordVisibility"></i>
                        <i id="close" class="hidden absolute w-7 h-7 mx-2 float-right cursor-pointer" v-html="icons.EyeClosed" @click="togglePasswordVisibility"></i>
                    </div>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" v-model="rememberMe" id="remember" class="accent-[#550514] focus:border-gray-400 focus:outline-none" @click="remember">
                        <label for="rememberMe" class="text-sm md:text-white">Remember me</label><br>
                    </div>
                    <button type="submit" class="w-full h-10 bg-[#39030D] text-white rounded-md shadow-black hover:opacity-75 md:bg-[#AA0927]">
                        Sign In
                    </button>
                </form>
                <div class="flex flex-col items-center">
                    <router-link to="/reset" class="p-2 text-sm text-left w-fit">
                        <button class="text-[#39030D] md:text-white hover:underline active:underline">
                            Forgot Password?
                        </button>
                    </router-link>
                    <p class="p-2 text-sm text-left md:text-white">Need an account? <router-link to="/signup">
                            <span class="text-[#39030D] md:text-white hover:underline active:underline">
                                Register
                            </span>
                        </router-link></p>
                </div>
            </div>
        </div>
        <div v-if="isLoading" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75">
            <img src="/src/assets/loading.gif" alt="Loading" />
        </div>
    </div>
</template>

<script setup>
// Import necessary modules
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { loginAuth } from '@/services/ApiServices.js';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import icons from '@/assets/icons';

// Define constants
const email = ref('');
const pass = ref('');
const rememberMe = ref(false);
const info = ref('');
const router = useRouter();
const route = useRoute();
const getToken = ref(localStorage.getItem('token'));
const isLoading = ref(false);

// Function to update token value
function updateToken() {
    getToken.value = localStorage.getItem('token');
}

// Function to check if remember me is enabled
function checkRememberMe() {
    if (localStorage.getItem('rememberMe') === 'true' && getToken.value) {
        router.push('/load');
    }
}

// Function to toggle password visibility
function togglePasswordVisibility() {
    const passwordField = document.getElementById('pass');
    const openEyeIcon = document.getElementById('open');
    const closedEyeIcon = document.getElementById('close');
    if (passwordField.type === 'password') {
        openEyeIcon.style.display = 'none';
        closedEyeIcon.style.display = 'block';
        passwordField.type = 'text';
    } else {
        openEyeIcon.style.display = 'block';
        closedEyeIcon.style.display = 'none';
        passwordField.type = 'password';
    }
}

// Function to handle login
async function login(email, pass) {
    const field = document.getElementById('name');
    const password = document.getElementById('pass');
    const rememberMeCheckbox = document.getElementById('remember');
    try {
        isLoading.value = true;
        const data = await loginAuth(email, pass);
        if (data && data.result) {
            field.classList.remove("show");
            password.classList.remove("show");
            info.value = data.result;
            localStorage.setItem("token", JSON.parse(data.result));
            if (rememberMeCheckbox && rememberMeCheckbox.checked) {
                localStorage.setItem("rememberMe", "true");
            } else {
                localStorage.removeItem("rememberMe");
            }
            router.push('/load');
        } else {
            throw new Error('Invalid login data');
        }
    } catch (error) {
        console.error('Login error:', error);
        const $toast = useToast();
        $toast.warning('Invalid login data');
    }
    finally {
        isLoading.value = false;
    }
}

// Call onMounted hook
onMounted(() => {
    // ⚠ ⚠ ⚠ TO ADD: TOKEN CHECKER ⚠ ⚠ ⚠ 
    // setInterval(updateToken, 500);

    const status = route.query.success;
    checkRememberMe();
    if (status === 'true') {
        const $toast = useToast();
        $toast.success('Login Again');
    }
});
</script>




<style lang="scss" scoped>
.show {
    border: 1px solid red;
}
</style>