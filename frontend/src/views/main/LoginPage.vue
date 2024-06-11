<template>
    <div
        class="flex w-screen justify-center h-screen items-center bg-gradient-to-r from-[#550514] to-[#AA0927] md:from-[#550514] md:to-[#550514]">
        <div class="flex max-w-[500px] w-full md:justify-center md:gap-7 rounded-lg">
            <div
                class="flex flex-col justify-center text-center w-full gap-5 bg-white p-10 rounded-lg md:p-0 md:m-5 md:w-full  md:rounded-xl md:bg-[#550514]">
                <h1 class="py-5 text-3xl leading-snug text-[#1C0207] md:text-white">
                    <b>
                        Speedy
                        Repair
                        and
                        Delivery This is Test for CI/CD Integration</b>
                </h1>
                <form class="flex flex-col justify-center w-full gap-5 md:w-full md:mt-0"
                    @submit.prevent="login(email, pass)">
                    <input type="email" id="name" v-model="email"
                        class="relative z-0 w-full h-12 pl-3 rounded-md shadow-sm pr-11 md:h-9 focus:border-gray-400 focus:outline-none"
                        placeholder="Email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Invalid email address" required>
                    <div class="flex flex-row items-center justify-end">
                        <input type="password" id="pass" v-model="pass"
                            class="relative z-0 w-full h-12 pl-3 rounded-md shadow-sm pr-11 md:h-9 focus:border-gray-400 focus:outline-none"
                            placeholder="Password" required>
                        <i id="open" class="absolute z-[1] w-7 h-7 mx-2 float-right" v-html="icons.Eye"
                            @click="togglePasswordVisibility"></i>
                        <i id="close" class="hidden absolute z-[1] w-7 h-7 mx-2 float-right" v-html="icons.EyeClosed"
                            @click="togglePasswordVisibility"></i>
                    </div>
                    <div class="flex items-center gap-1 justify-normal ">
                        <input type="checkbox" v-model="rememberMe" id="remember"
                            class="accent-[#550514] text-white focus:border-gray-400 focus:outline-none"
                            @click="remember">
                        <label for="rememberMe" class="md:text-white md:text-sm">Remember me</label><br>
                    </div>
                    <button type="submit"
                        class="w-full h-10 text-white bg-[#39030D] rounded-md shadow-black max-2xl:w-20 lg:h-10 md:bg-[#AA0927] hover:opacity-75">Sign
                        In</button>
                </form>
                <div class="flex flex-col">
                    <router-link to="/reset" class="p-2 text-sm text-left w-fit">
                        <button
                            class="text-left text-[#39030D] active:underline hover:underline md:underline md:text-white">
                            Forgot Password?
                        </button>
                    </router-link>

                    <p class="p-2 text-sm text-left md:text-white">Need an account? <router-link to="/signup">
                            <span class="text-[#39030D] active:underline hover:underline md:underline md:text-white">
                                Register
                            </span>
                        </router-link></p>
                </div>

            </div>
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