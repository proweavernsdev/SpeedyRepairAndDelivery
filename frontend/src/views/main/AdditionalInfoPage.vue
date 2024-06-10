<template>
    <div id="error" class="flex items-center justify-center flex-col h-screen gap-5 bg-[#550514]">
        <SRSignUpModals v-show="isOpen == true">
            <template #Icon>
                <div class="w-full max-w-[1200px] 3xl:pl-5 hover:opacity-80">
                    <button href="http://" target="_blank" rel="noopener noreferrer"
                        class="flex flex-col justify-center items-center w-14 h-14 text-white rounded-full bg-[#1C0207]"
                        @click="isOpen = !isOpen; resetRefs()">←</button>
                </div>
            </template>
            <template #Description>
                <h3 class="text-2xl text-white h-11"><b>Additional Information</b></h3>
            </template>
            <template #Form>
                <form v-if="level === 2"
                    class=" flex flex-col justify-center items-center gap-5 w-full max-w-[800px] lg:px-4 sm:gap-3"
                    @submit.prevent="dashboardCompany(company, address, town, state, zip, docs)">
                    <div class="flex flex-col w-full gap-3">
                        <p class="text-center text-white">Basic Information (Company)</p>
                        <div class="flex flex-row h-11 sm:flex-col sm:h-auto">
                            <p
                                class="flex items-center justify-center w-1/3 p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                Company Name</p>
                            <input type="text" name="" id=""
                                class="w-2/3 px-2 rounded-md sm:h-11 sm:w-full focus:border-gray-400 focus:outline-none"
                                v-model="company">
                        </div>
                        <div class="flex flex-row h-11 sm:flex-col sm:h-auto">
                            <p
                                class="flex items-center justify-center w-1/3 p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                Address</p>
                            <input type="text" name="" id=""
                                class="w-2/3 px-2 rounded-md sm:h-11 sm:w-full focus:border-gray-400 focus:outline-none"
                                v-model="address">
                        </div>
                    </div>
                    <div class="flex flex-col w-full gap-2 pt-5 border-t">
                        <p class="text-center text-white">Location</p>
                        <div class="flex flex-row gap-2 ">
                            <div class="flex flex-col w-full">
                                <p
                                    class="flex items-center w-auto p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                    Town:</p>
                                <input type="text" name="" id=""
                                    class="px-2 rounded-md h-11 focus:border-gray-400 focus:outline-none"
                                    v-model="town">
                            </div>
                        </div>
                        <div class="flex flex-row gap-2 ">
                            <div class="flex flex-col w-3/4">
                                <p
                                    class="flex items-center w-auto p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                    State:</p>
                                <input type="text" name="" id=""
                                    class="px-2 rounded-md h-11 focus:border-gray-400 focus:outline-none"
                                    v-model="state">
                            </div>
                            <div class="flex flex-col w-1/4">
                                <p
                                    class="flex items-center w-auto p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                    ZIP:</p>
                                <input type="number" min="1" max="999" name="" id=""
                                    class="px-2 rounded-md h-11 focus:border-gray-400 focus:outline-none" v-model="zip">
                            </div>
                        </div>
                        <div class="flex flex-col w-full my-3">
                            <p
                                class="flex items-center w-auto p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                Documents:</p>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-[#630617] dark:border-none dark:placeholder-gray-400"
                                id="docs" type="file" @change="handleFileChange" multiple>
                        </div>
                    </div>
                    <button type="submit" class="w-full h-11 rounded-md text-white bg-[#630617] hover:bg-[#6b2529]">SIGN
                        UP</button>
                </form>

                <form v-if="level === 3"
                    class="flex flex-col justify-center items-center gap-5 w-full max-w-[800px] lg:px-4 sm:gap-3"
                    @submit.prevent="dashboardCustomer(firstname, lastname, address, town, state, zip)">
                    <div class="flex flex-col w-full gap-3 pb-5">
                        <p class="text-center text-white">Basic Information (Customer)</p>
                        <div class="flex flex-row h-11 sm:flex-col sm:h-auto">
                            <p
                                class="flex items-center justify-center w-1/3 p-2 text-white h-11 sm:h-auto sm:justify-normal sm:w-auto">
                                First
                                Name</p>
                            <input type="text" name="" id=""
                                class="w-2/3 px-2 rounded-md sm:h-11 sm:w-full focus:border-gray-400 focus:outline-none"
                                v-model="firstname">
                        </div>
                        <div class="flex flex-row h-11 sm:flex-col sm:h-auto">
                            <p
                                class="flex items-center justify-center w-1/3 p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                Last
                                Name</p>
                            <input type="text" name="" id=""
                                class="w-2/3 px-2 rounded-md sm:h-11 sm:w-full focus:border-gray-400 focus:outline-none"
                                v-model="lastname">
                        </div>
                        <div class="flex flex-row h-11 sm:flex-col sm:h-auto">
                            <p
                                class="flex items-center justify-center w-1/3 p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                Address</p>
                            <input type="text" name="" id=""
                                class="w-2/3 px-2 rounded-md sm:h-11 sm:w-full focus:border-gray-400 focus:outline-none"
                                v-model="address">
                        </div>
                    </div>
                    <div class="flex flex-col w-full gap-2 pt-5 border-t">
                        <p class="text-center text-white">Location</p>
                        <div class="flex flex-row gap-2 ">
                            <div class="flex flex-col w-full">
                                <p
                                    class="flex items-center w-auto p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                    Town</p>
                                <input type="text" name="" id=""
                                    class="px-2 rounded-md h-11 focus:border-gray-400 focus:outline-none"
                                    v-model="town">
                            </div>
                        </div>
                        <div class="flex flex-row gap-2 ">
                            <div class="flex flex-col w-3/4">
                                <p
                                    class="flex items-center w-auto p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                    State</p>
                                <input type="text" name="" id=""
                                    class="px-2 rounded-md h-11 focus:border-gray-400 focus:outline-none"
                                    v-model="state">
                            </div>
                            <div class="flex flex-col w-1/4">
                                <p
                                    class="flex items-center w-auto p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                    ZIP</p>
                                <input type="number" min="1" max="999" name="" id=""
                                    class="px-2 rounded-md h-11 focus:border-gray-400 focus:outline-none" v-model="zip">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full h-11 rounded-md text-white bg-[#630617] hover:bg-[#6b2529]">SIGN
                        UP</button>
                </form>
                <form v-if="level === 4"
                    class="flex flex-col justify-center items-center gap-5 w-full max-w-[800px] lg:px-4 sm:gap-3"
                    @submit.prevent="dashboardDriver(firstname, lastname, address, town, state, zip, licenseNumber, vehicle, docs)">
                    <div class="flex flex-col w-full gap-3 pb-5">
                        <p class="text-center text-white">Basic Information (Driver)</p>
                        <div class="flex flex-row h-11 sm:flex-col sm:h-auto">
                            <p
                                class="flex items-center justify-center w-1/3 p-2 text-white h-11 sm:h-auto sm:justify-normal sm:w-auto">
                                First
                                Name</p>
                            <input type="text" name="" id=""
                                class="w-2/3 px-2 rounded-md sm:h-11 sm:w-full focus:border-gray-400 focus:outline-none"
                                v-model="firstname">
                        </div>
                        <div class="flex flex-row h-11 sm:flex-col sm:h-auto">
                            <p
                                class="flex items-center justify-center w-1/3 p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                Last
                                Name</p>
                            <input type="text" name="" id=""
                                class="w-2/3 px-2 rounded-md sm:h-11 sm:w-full focus:border-gray-400 focus:outline-none"
                                v-model="lastname">
                        </div>
                        <div class="flex flex-row h-11 sm:flex-col sm:h-auto">
                            <p
                                class="flex items-center justify-center w-1/3 p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                Address</p>
                            <input type="text" name="" id=""
                                class="w-2/3 px-2 rounded-md sm:h-11 sm:w-full focus:border-gray-400 focus:outline-none"
                                v-model="address">
                        </div>
                    </div>
                    <div class="flex flex-col w-full gap-2 pt-5 border-t">
                        <p class="text-center text-white">Location</p>
                        <div class="flex flex-row gap-2 ">
                            <div class="flex flex-col w-full">
                                <p
                                    class="flex items-center w-auto p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                    Town</p>
                                <input type="text" name="" id=""
                                    class="px-2 rounded-md h-11 focus:border-gray-400 focus:outline-none"
                                    v-model="town">
                            </div>
                        </div>
                        <div class="flex flex-row gap-2 ">
                            <div class="flex flex-col w-3/4">
                                <p
                                    class="flex items-center w-auto p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                    State</p>
                                <input type="text" name="" id=""
                                    class="px-2 rounded-md h-11 focus:border-gray-400 focus:outline-none"
                                    v-model="state">
                            </div>
                            <div class="flex flex-col w-1/4">
                                <p
                                    class="flex items-center w-auto p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                    ZIP</p>
                                <input type="number" min="1" max="999" name="" id=""
                                    class="px-2 rounded-md h-11 focus:border-gray-400 focus:outline-none" v-model="zip">
                            </div>
                        </div>
                        <div class="flex flex-row gap-2 ">
                            <div class="flex flex-col w-1/2">
                                <p
                                    class="flex items-center w-auto p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                    Vehicle Type:</p>
                                <select v-model="vehicle"
                                    class="bg-gray-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:border-slate-600 dark:placeholder-slate-400 dark:text-[#550514] dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <!-- <option disabled value="">Choose your vehicle type</option> -->
                                    <option v-for="vehicle in vehicleTypes" :key="vehicle.vehicleTypeID"
                                        :value="vehicle.vehicleTypeID">{{ vehicle.vehic_type }}</option>
                                </select>
                            </div>
                            <div class="flex flex-col w-1/2">
                                <p
                                    class="flex items-center w-auto p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                    License Number</p>
                                <input type="number" min="1" max="999" name="" id=""
                                    class="px-2 rounded-md h-11 focus:border-gray-400 focus:outline-none"
                                    v-model="licenseNumber">
                            </div>
                        </div>
                        <div class="flex flex-col w-full my-3">
                            <p
                                class="flex items-center w-auto p-2 text-white h-11 sm:h-auto sm:w-full sm:justify-normal">
                                License Images</p>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-[#630617] dark:border-none dark:placeholder-gray-400"
                                id="docs" type="file" @change="handleFileChange" multiple>
                        </div>
                    </div>
                    <button type="submit" class="w-full h-11 rounded-md text-white bg-[#630617] hover:bg-[#6b2529]">SIGN
                        UP</button>
                </form>
            </template>
            <template #Footer>
                <div class="hidden">
                </div>
            </template>
        </SRSignUpModals>
        <!-- <div id="signup"
            class="flex items-center w-full mx-10 max-w-7xl md:flex-col md:p-5 md:h-full md:justify-center md:gap-7 8xl:px-5 md:mx-0"> -->
        <div id="error"
            class="flex mx-10 w-full max-w-7xl items-center justify-center flex-col h-screen gap-5 bg-[#550514]">
            <div class="flex flex-col justify-center gap-10 h-4/5">
                <div class="text-center">
                    <p class="text-white">{{ prompt }}</p>
                    <h1 class="text-white">{{ header }}</h1>
                </div>
                <div class="flex flex-row flex-wrap justify-center gap-10">
                    <button id="company"
                        class="flex flex-col w-[150px] p-10 justify-center rounded-md shadow-sm bg-white"
                        @click="changeStatus(2)">
                        <i v-html="icons.Building"></i>
                        Company
                    </button>
                    <button id="customer"
                        class="flex flex-col w-[150px] p-10 justify-center rounded-md shadow-sm bg-white"
                        @click="changeStatus(3)">
                        <i v-html="icons.Customer"></i>
                        Customer
                    </button>
                    <button id="driver"
                        class="flex flex-col w-[150px]  p-10 justify-center rounded-md shadow-sm bg-white"
                        @click="changeStatus(4)">
                        <i v-html="icons.Driver"></i>Driver
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
</template>

<script setup>
import icons from "@/assets/icons";
import SRSignUpModals from "@/components/SRSignUpModals.vue";
import { useRouter } from 'vue-router';
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { createCompany, createDriver, createCustomer, vehicleRetrieve } from '@/services/ApiServices.js';

var isOpen = ref(false);
const router = useRouter();
const route = useRoute();

//email vars
// company vars
const company = ref('');
const address = ref('');
const town = ref('');
const state = ref('');
const zip = ref('');
//driver vars
const firstname = ref('');
const lastname = ref('');
const licenseNumber = ref('');
const vehicle = ref('');
const vehicleTypes = ref('');

// reset function for variables
const resetRefs = () => {
    company.value = '';
    address.value = '';
    town.value = '';
    state.value = '';
    zip.value = '';
    firstname.value = '';
    lastname.value = '';
    licenseNumber.value = '';
    vehicle.value = '';
}

//datas for access levels
const header = ref('USER TYPE');
const prompt = ref('Please select your');
const userTypes = ref({
    'Company User': '/src/assets/company.png',
    'Customer': '/src/assets/customer.png',
    'Driver': '/src/assets/driver.png'
});

// for input of multiple files
const docs = ref(null);
const handleFileChange = (event) => {
    docs.value = event.target.files;
    console.log(docs.value)
}

let pwauth = localStorage.getItem('token');
let updateToken = () => {
    pwauth = localStorage.getItem('token')
    console.log(pwauth);
};

const level = ref('');

const myFunction = () => {
    const status = atob(route.query.level);
    console.log(status);
    if (status === 'null' || status === 'undefined') {
        const data = {
            UserID: atob(route.query.marker),
            Email: atob(route.query.email),
            UserAccess: atob(route.query.level),
            Company: atob(route.query.company)
        }
        console.log(data);
    } else {
        router.push('/admin/dashboard').catch(err => {
            console.error(err);
        });
    }
};

function dashboardCompany(company, address, town, state, zip, docs) {
    updateToken();
    createCompany(company, address, town, state, zip, docs).then(() => {
        router.push('/login?success=true');
    })
}

function dashboardDriver(firstname, lastname, address, town, state, zip, licenseNumber, vehicle, docs) {
    updateToken();
    createDriver(firstname, lastname, address, town, state, zip, licenseNumber, vehicle, docs).then(() => {
        router.push('/login?success=true');
    })

}

function dashboardCustomer(firstname, lastname, address, town, state, zip) {
    updateToken();
    const customerData = {
        FirstName: firstname,
        LastName: lastname,
        Address: address,
        TownCity: town,
        State: state,
        Zip: zip
    }

    createCustomer(customerData).then(() => {
        router.push('/login?success=true');
        console.log("Customer Created");
    }).catch(err => {
        console.log(err);
    })

    console.log(customerData);
    router.push('/customer/dashboard');
}

const changeStatus = (value) => {
    level.value = value;
    console.log(level.value);
    // if (level.value == 3) {
    //     router.push('admin/dashboard');
    // } else {
    //     isOpen.value = true;
    // }
    isOpen.value = true;
}

onMounted(myFunction);

</script>

<style lang="scss" scoped>
input[type=file]::file-selector-button {
    font-family: 'Inter';
    border: 1px solid #1C0207;
    padding: .4em .8em;
    background-color: #AA0927;
    transition: 1s;
    color: white;
}

.show {
    display: flex;
}

.hide {
    display: none;
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