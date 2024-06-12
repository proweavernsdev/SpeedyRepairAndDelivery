<template>
  <div>
    <SRModalSlots v-show="isOpen == true" @close="isOpen = false">
      <template #Modal-Header>
        <div class="flex justify-between px-5 md:px-3 py-5 md:py-3 bg-[#AA0927] text-white text-3xl font-semibold">
          <h2 v-show="ChangeDeliveryAddress == true" class="md:text-xl">Add Delivery Address</h2>
          <h2 v-show="ChangePickupAddress == true" class="md:text-xl">Add Pickup Address</h2>
          <h2 v-show="ConfirmBooking == true" class="md:text-xl">Checkout Details</h2>
          <h2 v-show="UpdateSize == true" class="md:text-xl">Size Category</h2>
          <h2 v-show="UpdateWeight == true" class="md:text-xl">Weight Category</h2>
          <span v-show="ChangeDeliveryAddress == true || ChangePickupAddress == true || ConfirmBooking == false">
            <button @click="closeModal()" class="w-6">
              <svg class="hover:scale-105" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <line x1="10" y1="10" x2="90" y2="90" stroke="currentColor" stroke-width="5" />
                <line x1="90" y1="10" x2="10" y2="90" stroke="currentColor" stroke-width="5" />
              </svg>
            </button>
          </span>
        </div>
      </template>
      <template #Modal-Body>
        <div class="mx-6 mb-6 md:mx-3 md:mb-2">
          <form v-show="ChangeDeliveryAddress == true" id="changeDeliveryAddress"
            @submit.prevent="changeDeliveryAddressForm"
            class="flex flex-col gap-5 pt-5 md:pt-3 text-3xl font-bold text-center w-max-[400px] w-full">
            <div class="relative flex items-center justify-center w-full">
              <div id="map" class="w-full h-[300px] rounded md:h-[200px]">
                <input type="text" v-model="searchQuery" @input="searchLocation"
                  class="absolute top-2 left-2 w-[80%] bg-white border rounded py-1 px-2 text-xs z-10"
                  placeholder="Search Location" />
                <ul v-if="searchResults.length"
                  class="absolute top-12 left-2 w-[80%] bg-white border rounded py-1 px-2 text-xs overflow-auto z-20 max-h-[150px]">
                  <li v-for="(result, index) in searchResults" :key="index" @click="selectLocation(result)"
                    class="py-1 cursor-pointer hover:bg-gray-200">
                    {{ result.place_name }}
                  </li>
                </ul>
              </div>
            </div>
            <div class="flex flex-col items-center justify-center w-full gap-2 text-base">
              <div class="flex w-full gap-3">
                <input type="text" name="fullname" placeholder="Full Name" id="fullname" v-model="receiverfullname"
                  class="w-full p-2 text-sm font-medium border rounded-md focus:outline-none focus:border-red-400"
                  required>
                <input type="tel" name="phonenumber" id="phonenumber" placeholder="Phone Number" v-model="receiverphone"
                  class="w-full p-2 text-sm font-medium border rounded-md focus:outline-none focus:border-red-400"
                  required>
              </div>
              <input type="text" name="fullAddress" placeholder="Select a Delivery Address" id="fullAddress"
                v-model="receiverfullAddress"
                class="w-full p-2 text-sm font-medium border rounded-md focus:outline-none focus:border-red-400"
                required readonly>
              <textarea name="addressinfo" id="addressinfo" cols="30"
                placeholder="Street Name, Building Name, House No." v-model="receiveraddressInfo"
                class="w-full p-2 text-sm font-medium border rounded-md focus:outline-none focus:border-red-400"
                required></textarea>
            </div>
          </form>
          <form v-show="ChangePickupAddress == true" id="changePickupAddress" @submit.prevent="changePickupAddressForm"
            class="flex flex-col gap-5 pt-5 md:pt-3 text-3xl font-bold text-center w-max-[400px] w-full">
            <div class="flex items-center justify-center w-full">
              <div id="map2" class="w-[400px] h-[300px] rounded md:h-[200px]">
                <input type="text" v-model="searchQuery" @input="searchLocation"
                  class="absolute top-2 left-2 w-[80%] bg-white border rounded py-1 px-2 text-xs z-10"
                  placeholder="Search Location" />
                <ul v-if="searchResults.length"
                  class="absolute top-12 left-2 w-[80%] bg-white border rounded py-1 px-2 text-xs overflow-auto z-20 max-h-[150px]">
                  <li v-for="(result, index) in searchResults" :key="index" @click="selectLocation2(result)"
                    class="py-1 cursor-pointer hover:bg-gray-200">
                    {{ result.place_name }}
                  </li>
                </ul>
              </div>
            </div>
            <div class="flex flex-col items-center justify-center w-full gap-2">
              <div class="flex w-full gap-3">
                <input type="text" name="fullname" placeholder="Full Name" id="fullname" v-model="senderfullname"
                  class="w-full p-2 text-xs font-medium border rounded-md focus:outline-none focus:border-red-400"
                  required>
                <input type="tel" name="phonenumber" id="phonenumber" placeholder="Phone Number" v-model="senderphone"
                  class="w-full p-2 text-xs font-medium border rounded-md focus:outline-none focus:border-red-400"
                  required>
              </div>
              <input disabled type="text" name="fullAddress" placeholder="Select a Pickup Address" id="fullAddress"
                v-model="senderfullAddress"
                class="w-full p-2 text-xs font-medium border rounded-md focus:outline-none focus:border-red-400">
              <textarea name="addressinfo" id="addressinfo" cols="30"
                placeholder="Street Name, Building Name, House No." v-model="senderaddressInfo"
                class="w-full p-2 text-xs font-medium border rounded-md focus:outline-none focus:border-red-400"
                required></textarea>
            </div>
          </form>
          <div v-show="ConfirmBooking == true">
            <div class="flex flex-col justify-center gap-3 p-3 md:p-1">
              <div class="flex justify-center">
                <i v-html="icons.BookingConfirm" class="text-center"></i>
              </div>
              <div class="flex items-center justify-between">
                <p class="w-1/2 font-bold">Receiver</p>
                <p class="w-1/2 text-right opacity-70">{{ receiverfullname }}</p>
              </div>
              <div class="flex items-center justify-between">
                <p class="w-1/2 font-bold">Delivery Address</p>
                <p class="w-1/2 text-right opacity-70">{{ receiveraddressInfo }}, {{ receiverfullAddress }}</p>
              </div>
              <hr class="w-[90%] mx-auto border-dashed border-slate-300 border-t">
              <div class="flex items-center justify-between">
                <p class="w-1/2 font-bold">Item Name</p>
                <p class="w-1/2 text-right md:truncate opacity-70">{{ itemName }}</p>
              </div>
              <div class="flex items-center justify-between">
                <p class="w-1/2 font-bold">Sender's Note/s</p>
                <p class="w-1/2 text-right opacity-70">{{ notes }}</p>
              </div>
              <hr class="w-[90%] mx-auto border-dashed border-slate-300 border-t">
              <div class="flex items-center justify-between">
                <p class="w-1/2 font-bold">Pickup Date</p>
                <p class="w-1/2 text-right opacity-70">{{ arrivalTime }} {{ arrivalDate }}</p>
              </div>
              <div class="flex items-center justify-between">
                <p class="w-1/2 font-bold">Total Cost</p>
                <p class="w-1/2 text-right opacity-70">$1,200.00</p>
              </div>
              <div class="flex items-center justify-between">
              </div>
            </div>
          </div>
          <form v-show="UpdateSize == true" id="updateSize" @submit.prevent="updateSizeForm"
            class="flex flex-col max-w-lg gap-6 mx-auto text-center">
            <div class="flex flex-col gap-4 p-6 bg-white rounded-lg shadow-md">
              <div class="flex flex-col gap-2 text-left">
                <label for="sizeDropdown" class="text-lg font-medium">Select Unit:</label>
                <select name="sizeDropdown" id="sizeDropdown" v-model="sizeDropdown"
                  class="p-3 text-lg bg-white border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                  <option disabled value="">Please select one</option>
                  <option>Feet</option>
                  <option>Inches</option>
                  <option>Meters</option>
                  <option>Centimeters</option>
                </select>
              </div>
              <div class="flex items-center gap-4">
                <label for="length" class="w-1/4 text-lg font-medium text-left">Length:</label>
                <input type="number" pattern="[0-9]*" min="1" max="999" name="length" id="length" v-model="length"
                  class="w-3/4 p-3 text-lg bg-white border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
              <div class="flex items-center gap-4">
                <label for="width" class="w-1/4 text-lg font-medium text-left">Width:</label>
                <input type="number" pattern="[0-9]*" min="1" max="999" name="width" id="width" v-model="width"
                  class="w-3/4 p-3 text-lg bg-white border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
              <div class="flex items-center gap-4">
                <label for="height" class="w-1/4 text-lg font-medium text-left">Height:</label>
                <input type="number" pattern="[0-9]*" min="1" max="999" name="height" id="height" v-model="height"
                  class="w-3/4 p-3 text-lg bg-white border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
              </div>
            </div>
          </form>
          <form v-show="UpdateWeight == true" id="updateWeight" @submit.prevent="updateWeightForm">
            <div class="flex flex-col w-full gap-5 p-3 md:p-px lg:flex-col lg:[&>*]:w-full">
              <div class="flex items-center justify-between w-full gap-3">
                <p class="w-1/3 text-xl font-medium text-center md:text-base">Weight:</p>
                <span class="flex w-full gap-2">
                  <input type="number" min="1" max="999" name="weight" id="weight" v-model="weight"
                    class="w-full p-2 border-b-2 rounded focus:border-red-400 focus:outline-none bg-[#fcfcfc] text-xl font-medium md:text-base ">
                  <select name="weightdropdown" id="weightdropdown" v-model="weightDropdown"
                    class="p-2 rounded bg-[#fbf8f8] text-xl font-medium md:w-1/2 md:text-base">
                    <option disabled value="">Please select one</option>
                    <option>Pounds</option>
                    <option>Kilograms</option>
                    <option>Ounces</option>
                    <option>Grams</option>
                    <option>Tonnes</option>
                  </select>
                </span>
              </div>
            </div>
          </form>
        </div>
      </template>
      <template #Modal-Footer>
        <div class="flex justify-end w-full px-6 py-5 md:py-2 md:px-3">
          <div v-show="ChangeDeliveryAddress == true">
            <button class="w-[139px] h-[40px] rounded-lg bg-[#550514] text-lg text-white font-bold hover:opacity-80"
              form="changeDeliveryAddress" @click="isOpen = validateAddress('changeDeliveryAddress')">Submit</button>
          </div>
          <div v-show="ChangePickupAddress == true">
            <button class="w-[139px] h-[40px] rounded-lg bg-[#550514] text-lg text-white font-bold hover:opacity-80"
              form="changePickupAddress" @click="isOpen = validateAddress('changePickupAddress')">Submit</button>
          </div>
          <div v-show="ConfirmBooking == true" class="space-x-2.5">
            <button @click="isOpen = false"
              class="w-[139px] h-[40px] rounded-lg bg-[#fbf8f8] text-lg font-bold border hover:opacity-80">Cancel</button>
            <button class="w-[139px] h-[40px] rounded-lg bg-[#550514] text-lg text-white font-bold hover:opacity-80"
              @click="bookingConfirm()">Confirm</button>
          </div>
          <div v-show="UpdateWeight == true">
            <button class="w-[139px] h-[40px] rounded-lg bg-[#550514] text-lg text-white font-bold hover:opacity-80"
              form="updateWeight" @click="isOpen = false">Submit</button>
          </div>
          <div v-show="UpdateSize == true">
            <button class="w-[139px] h-[40px] rounded-lg bg-[#550514] text-lg text-white font-bold hover:opacity-80"
              form="updateSize" @click="isOpen = false">Submit</button>
          </div>
        </div>
      </template>
    </SRModalSlots>
    <SRContents>
      <template #Content-Header>
        <h1 class="text-3xl font-bold md:text-2xl">Delivery Service</h1>
      </template>
      <template #Content-Body>
        <div class="flex flex-col gap-2">
          <div class="flex flex-col items-center justify-between p-3 bg-white border rounded-lg">
            <div class="flex flex-col justify-between w-full gap-2 p-3 md:p-px">
              <p class="text-lg text-red-600">Delivery Address</p>
              <div class="flex items-center justify-between gap-3">
                <div class="font-bold sm:hidden">
                  <p>{{ receiverfullname }}</p>
                  <p>{{ receiverphone }}</p>
                </div>
                <div class="flex items-center gap-3 sm:flex-col sm:[&>*]:w-full sm:w-full">
                  <p class="text-sm text-slate-500 ">{{ receiveraddressInfo }}. {{ receiverfullAddress }}</p>
                  <button
                    @click="ChangeDeliveryAddress = true, ChangePickupAddress = false, ConfirmBooking = false, UpdateSize = false, UpdateWeight = false, isOpen = true"
                    href="" class="text-base p-2 text-[#AA0927] rounded-lg hover:bg-[#fbf8f8] ">Change</button>
                </div>
              </div>
            </div>
            <hr class="w-[90%] mx-auto border-dashed border-slate-300 border-t">
            <div class="flex flex-col justify-between w-full gap-2 p-3 md:px-px">
              <p class="text-lg text-red-600">Pickup Address</p>
              <div class="flex items-center justify-between gap-3">
                <div class="font-bold sm:hidden">
                  <p>{{ senderfullname }}</p>
                  <p>{{ senderphone }}</p>
                </div>
                <div class="flex items-center gap-3 sm:w-full sm:flex-col sm:[&>*]:w-full">
                  <p class="text-sm text-slate-500">{{ senderaddressInfo }}. {{ senderfullAddress }}</p>
                  <button
                    @click="ChangePickupAddress = true, ChangeDeliveryAddress = false, ConfirmBooking = false, UpdateSize = false, UpdateWeight = false, isOpen = true"
                    href="" class="text-base p-2 text-[#AA0927] rounded-lg hover:bg-[#fbf8f8]">Change</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="flex flex-col gap-3 my-2">
          <p class="p-3 text-lg font-bold">General Information</p>
          <div class="flex flex-col gap-6 p-2 bg-white border rounded-lg md:gap-3">
            <div class="flex flex-col w-full gap-3 p-3">
              <p>Name of Item</p>
              <input type="text" v-model="itemName"
                class="w-full p-2 border bg-[#fcfcfc] rounded focus:border-red-400 focus:outline-none">
            </div>
            <hr class="w-[90%] mx-auto border-dashed border-slate-300 border-t">
            <div class="flex w-full gap-5 p-3 [&>*]:w-1/2 2xl:flex-col 2xl:[&>*]:w-full">
              <div class="flex items-center justify-between w-full gap-3">
                <p class="w-1/4 text-center">Size:</p>
                <span class="flex justify-center w-full gap-2 md:w-3/4 md:items-end md:flex-col ">
                  <span id="height"
                    class="flex items-center justify-center w-full gap-5 text-center rounded bg-red-50 md:gap-px md:p-px md:flex-col focus:border-red-400 focus:outline-none">
                    <p class="text-lg font-medium text-red-700">
                      {{ sizeCategory }} </p>
                    <p class="text-sm">{{ sizeMeasurements }}</p>
                  </span>
                  <button
                    @click="ChangePickupAddress = false, ChangeDeliveryAddress = false, ConfirmBooking = false, UpdateSize = true, UpdateWeight = false, isOpen = true"
                    href="" class="text-sm p-2 text-[#AA0927] w-1/3 rounded-lg hover:bg-[#fbf8f8] md:w-auto">Change
                    Size</button>
                </span>
              </div>
              <div class="flex items-center justify-between w-full gap-3">
                <p class="w-1/4 text-center">Weight:</p>
                <span class="flex justify-center w-full gap-2 md:w-3/4 md:items-end md:flex-col ">
                  <span name="weight" id="weight"
                    class="flex items-center justify-center w-full gap-5 text-center rounded bg-red-50 md:gap-px md:p-px md:flex-col focus:border-red-400 focus:outline-none">
                    <p class="text-lg font-medium text-red-700">
                      {{ weightCategory }}</p>
                    <p class="text-sm">{{ weightMeasurements }}</p>
                  </span>
                  <button
                    @click="ChangePickupAddress = false, ChangeDeliveryAddress = false, ConfirmBooking = false, UpdateSize = false, UpdateWeight = true, isOpen = true"
                    href="" class="text-sm p-2 text-[#AA0927] w-1/3 rounded-lg hover:bg-[#fbf8f8] md:w-auto">Change
                    Weight</button>
                </span>
              </div>
            </div>
            <hr class="w-[90%] mx-auto border-dashed border-slate-300 border-t">
            <dialog id="fragilityDescription" class="w-1/2 p-4 rounded-lg shadow-lg">
              <div class="flex justify-end">
                <button class="p-2 text-xl hover:bg-gray-200 hover:rounded-full"
                  @click="openDialog('fragilityDescription', 'close')">✖</button>
              </div>
              <hr class="w-3/4 m-auto border-gray-300">
              <div class="flex p-4">
                <p class="w-full text-center">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Atque in, ab
                  quis veritatis fugiat voluptatibus! Labore expedita sint magnam laudantium.</p>
              </div>
            </dialog>

            <dialog id="vehicleDescription" class="w-1/2 p-4 rounded-lg shadow-lg">
              <div class="flex justify-end">
                <button class="p-2 text-xl hover:bg-gray-200 hover:rounded-full"
                  @click="openDialog('vehicleDescription', 'close')">✖</button>
              </div>
              <hr class="w-3/4 m-auto border-gray-300">
              <div class="flex p-4">
                <p class="w-full text-center">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Beatae doloribus
                  itaque tempora facere minima rerum.</p>
              </div>
            </dialog>

            <div class="flex flex-col w-full gap-6 p-4">
              <div class="flex lg:flex-col lg:[&>*]:w-full w-full gap-6 items-center justify-between">
                <div class="flex items-center w-1/2 gap-4">
                  <label for="fragility" class="text-lg font-medium">Fragility:</label>
                  <div class="relative flex-grow">
                    <select id="fragility" v-model="fragility"
                      class="w-full p-3 pr-10 border border-gray-300 rounded bg-red-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                      <option>Fragile</option>
                      <option>Non-Fragile</option>
                    </select>
                    <button @click="openDialog('fragilityDescription', 'open')"
                      class="absolute inset-y-0 right-0 w-10 h-full text-lg text-white bg-[#AA0927] rounded-r focus:outline-none">
                      i
                    </button>
                  </div>
                </div>
                <div class="flex items-center w-1/2 gap-4">
                  <label for="vehicletype" class="text-lg font-medium">Vehicle Type:</label>
                  <div class="relative flex-grow">
                    <select id="vehicletype" v-model="vehicleType"
                      class="w-full p-3 pr-10 border border-gray-300 rounded bg-rose-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                      <option>Truck</option>
                      <option>Van</option>
                      <option>Motorcycle</option>
                    </select>
                    <button @click="openDialog('vehicleDescription', 'open')"
                      class="absolute inset-y-0 right-0 w-10 h-full text-lg text-white bg-[#AA0927] rounded-r focus:outline-none">
                      i
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <hr class="w-[90%] mx-auto border-dashed border-slate-300 border-t">
            <div class="flex flex-col w-full gap-3 p-3">
              <p>Special Handling/Notes:</p>
              <textarea id="textarea" name="textarea" v-model="notes" rows="4" cols="50"
                class="w-full p-2 border rounded bg-[#fcfcfc] focus:border-red-400 focus:outline-none">
      </textarea>
            </div>
          </div>
          <div class="flex justify-end w-full">
            <div class="flex flex-col w-1/2 sm:w-full">
              <div class="flex items-center justify-between p-3">
                <p>Total Cost:</p>
                <p>$0.00</p>
              </div>
              <div class="flex items-center justify-between p-3">
                <p>Estimated Time of Arrival:</p>
                <p class="text-right">{{ arrivalTime }} {{ arrivalDate }}</p>
              </div>
              <div class="flex items-center justify-between p-3">
                <p>Fee:</p>
                <p>$0.00</p>
              </div>
              <button class="w-full p-2 my-3 rounded bg-[#AA0927] text-white hover:opacity-80"
                :disabled="!isDeliveryInfoComplete"
                @click="ChangePickupAddress = false, ChangeDeliveryAddress = false, ConfirmBooking = true, UpdateSize = false, UpdateWeight = false, isOpen = true">Place
                Order</button>
            </div>
          </div>
        </div>
      </template>
    </SRContents>
  </div>
</template>
<script setup>
import { auth, db } from '@/services/firebaseConfig';
import icons from "@/assets/icons";
import SRContents from "@/layouts/SRContents.vue";
import SRModalSlots from '@/components/SRModalSlots.vue';
import { useRouter } from 'vue-router';
import { ref, onMounted, onBeforeUnmount, computed, watch } from 'vue';
import mapboxgl from 'mapbox-gl';
import 'mapbox-gl/dist/mapbox-gl.css';
import axios from 'axios';
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
import { getDatabase, ref as refer, set } from "firebase/database";
import { useToast } from 'vue-toast-notification';
import { createBooking, customerRetrieveData } from '@/services/ApiServices';
import 'vue-toast-notification/dist/theme-sugar.css';
import { set as rtdbSet, ref as rtdbRef, get as rtdbGet } from 'firebase/database';

// Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyAda3Bw4Dr0pXmDBNHwcR4EDWlByL81M4I",
  authDomain: "speedyrepair-6f70d.firebaseapp.com",
  databaseURL: "https://speedyrepair-6f70d-default-rtdb.firebaseio.com",
  projectId: "speedyrepair-6f70d",
  storageBucket: "speedyrepair-6f70d.appspot.com",
  messagingSenderId: "93950013309",
  appId: "1:93950013309:web:c70a629b99583ae9eea614",
  measurementId: "G-T3BC6KBKTK"
};

const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
const toast = useToast();
const router = useRouter();

// Mapbox access token
const accessToken = 'pk.eyJ1Ijoiam9obi0yMDAxIiwiYSI6ImNsdm1yaXRxNDA2NHgyanBlY2oxanFja3gifQ.W_pQHATCMu0KrjHWAHF-CA';
mapboxgl.accessToken = accessToken;

// Reactive variables
const receiverfullname = ref('');
const receiverphone = ref('');
const receiveraddressInfo = ref('');
const receivercoordinatesLong = ref('');
const receivercoordinatesLat = ref('')
const senderfullname = ref('');
const senderphone = ref('');
const senderaddressInfo = ref('');
const sendercoordinatesLong = ref('');
const sendercoordinatesLat = ref('');


const itemName = ref('');
const length = ref('');
const width = ref('');
const height = ref('');
const sizeDropdown = ref('');
const weight = ref('');
const weightDropdown = ref('');
const fragility = ref('');
const vehicleType = ref('');
const notes = ref('');
const arrivalTime = ref('');
const arrivalDate = ref('');


// Modal variables
const isOpen = ref(false);
const ChangeDeliveryAddress = ref(false);
const ChangePickupAddress = ref(false);
const ConfirmBooking = ref(false);
const UpdateSize = ref(false);
const UpdateWeight = ref(false);

// Map and marker references
const map = ref(null);
const marker = ref(null);
const map2 = ref(null);
const marker2 = ref(null);

const receiverfullAddress = ref("");
const senderfullAddress = ref("");

const selectedLocation = ref({ lng: -74.5, lat: 40, place_name: '' });
const selectedLocation2 = ref({ lng: -74.5, lat: 40, place_name: '' });

const searchQuery = ref('');
const searchResults = ref([]);

// Computed property to check if delivery info is complete
const isDeliveryInfoComplete = computed(() => {
  const result = receiverfullname.value &&
    receiverphone.value &&
    receivercoordinatesLong.value &&
    receivercoordinatesLat.value &&
    receiveraddressInfo.value &&
    senderfullname.value &&
    senderphone.value &&
    sendercoordinatesLong.value &&
    sendercoordinatesLat.value &&
    senderaddressInfo.value &&
    length.value &&
    sizeDropdown.value &&
    width.value &&
    height.value &&
    weight.value &&
    weightDropdown.value &&
    itemName.value &&
    fragility.value &&
    vehicleType.value &&
    notes.value;
  console.log("isDeliveryInfoComplete: " + (result ? true : false));
  return result ? true : false;
});


// Map initialization
const initializeMap = (mapRef, markerRef, containerId, updateMarkerFn) => {
  mapRef.value = new mapboxgl.Map({
    container: containerId,
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [selectedLocation.value.lng, selectedLocation.value.lat],
    zoom: 13
  });
  markerRef.value = new mapboxgl.Marker().setLngLat([selectedLocation.value.lng, selectedLocation.value.lat]).addTo(mapRef.value);
  mapRef.value.on('move', updateMarkerFn);
  mapRef.value.on('zoom', updateMarkerFn);
  mapRef.value.dragRotate.disable();
}

onMounted(() => {
  navigator.geolocation.getCurrentPosition(position => {
    selectedLocation.value = { lng: position.coords.longitude, lat: position.coords.latitude };
    initializeMap(map, marker, 'map', updateMarkerAndStoreCoordinates);
    initializeMap(map2, marker2, 'map2', updateMarkerAndStoreCoordinates2);
  });
});

const fetchGeocodingData = (lng, lat, locationRef) => {
  return fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${accessToken}`)
    .then(response => response.json())
    .then(data => {
      const place = data.features[0];
      if (place) {
        locationRef.value = place.place_name;
      } else {
        console.log('No address found');
      }
    })
    .catch(error => console.error('Error with geocoding API: ', error));
};

const updateMarkerAndStoreCoordinates = () => {
  const center = map.value.getCenter();
  marker.value.setLngLat(center);
  receivercoordinatesLong.value = center.lng;
  receivercoordinatesLat.value = center.lat;
  console.info("receivercoordinatesLong:" + receivercoordinatesLong.value, "receivercoordinatesLat: " + receivercoordinatesLat.value);
  fetchGeocodingData(center.lng, center.lat, receiverfullAddress);
};

const updateMarkerAndStoreCoordinates2 = () => {
  const center = map2.value.getCenter();
  marker2.value.setLngLat(center);
  sendercoordinatesLong.value = center.lng;
  sendercoordinatesLat.value = center.lat;
  console.info("sendercoordinatesLong:" + sendercoordinatesLong.value, "sendercoordinatesLat: " + sendercoordinatesLat.value);
  fetchGeocodingData(center.lng, center.lat, senderfullAddress);
};

const validateAddress = (form) => {
  if (form == "changeDeliveryAddress") {
    if (!receiverfullAddress.value) {
      toast.error("Please select a pickup location");
      return true;
    }
    const nameRegex = /^[a-zA-Z\s]+$/;
    const phoneRegex = /^[\d-]+$/;

    if (!receiverfullname.value || !receiverphone.value || !receiveraddressInfo.value) {
      toast.error("Please fill in all the fields");
      return true;
    }

    if (!nameRegex.test(receiverfullname.value)) {
      toast.error("Invalid name format");
      return true;
    }

    if (!phoneRegex.test(receiverphone.value)) {
      toast.error("Invalid phone number format");
      return true;
    }
    return false;
  }
  if (form == "changePickupAddress") {
    if (!senderfullAddress.value) {
      toast.error("Please select a pickup location");
      return true;
    }
    const nameRegex = /^[a-zA-Z\s]+$/;
    const phoneRegex = /^[\d-]+$/;

    if (!senderfullname.value || !senderphone.value || !senderaddressInfo.value) {
      toast.error("Please fill in all the fields");
      return true;
    }

    if (!nameRegex.test(senderfullname.value)) {
      toast.error("Invalid name format");
      return true;
    }
    if (!phoneRegex.test(senderphone.value)) {
      toast.error("Invalid phone number format");
      return true;
    }
    return false;
  }
}
async function searchLocation() {
  if (!searchQuery.value) {
    searchResults.value = [];
    return;
  }
  const searchUrl = `https://api.mapbox.com/geocoding/v5/mapbox.places/${searchQuery.value}.json?access_token=${mapboxgl.accessToken}&autocomplete=true`;
  try {
    const response = await axios.get(searchUrl);
    searchResults.value = response.data.features;
  } catch (error) {
    console.error('Error searching location:', error);
  }
}

function selectLocation(location) {
  selectedLocation.value = {
    lng: location.center[0],
    lat: location.center[1],
    place_name: location.place_name,
  };
  searchQuery.value = location.place_name;
  searchResults.value = [];
  map.value.flyTo({ center: [location.center[0], location.center[1]], essential: true });
  marker.value.setLngLat([location.center[0], location.center[1]]);
}

function selectLocation2(location) {
  selectedLocation2.value = {
    lng: location.center[0],
    lat: location.center[1],
    place_name: location.place_name,
  };
  searchQuery.value = location.place_name;
  searchResults.value = [];
  map2.value.flyTo({ center: [location.center[0], location.center[1]], essential: true });
  marker2.value.setLngLat([location.center[0], location.center[1]]);
}

onBeforeUnmount(() => {
  if (map.value) map.value.remove();
  if (map2.value) map2.value.remove();
});

// Modal functions
const closeModal = () => {
  isOpen.value = !isOpen.value;
  receiverfullAddress.value = '';
  senderfullAddress.value = '';
  console.log("IsOpen value: " + isOpen.value);
};

const confirmBooking = () => {
  router.push('delivery/confirmation');
};

watch(
  [sendercoordinatesLong, sendercoordinatesLat, receivercoordinatesLong, receivercoordinatesLat],
  () => {
    if (sendercoordinatesLong.value && sendercoordinatesLat.value && receivercoordinatesLong.value && receivercoordinatesLat.value) {
      calculateDistanceAndDirections();
    }
  }
);

const calculateDistanceAndDirections = async () => {
  const origin = [sendercoordinatesLong.value, sendercoordinatesLat.value];
  const destination = [receivercoordinatesLong.value, receivercoordinatesLat.value];
  // const database = getDatabase();
  // set(refer(database, 'coordinates/first'), {
  //   originLong: origin[0],
  //   originLat: origin[1],
  //   destinationLong: destination[0],
  //   destinationLat: destination[1]
  // });
  // console.log("Coordinates saved successfully");

  const directionsUrl = `https://api.mapbox.com/directions/v5/mapbox/driving/${origin.join(',')};${destination.join(',')}?geometries=geojson&access_token=${accessToken}`;

  try {
    const response = await axios.get(directionsUrl);
    const data = response.data;
    const travelTimeSeconds = data.routes[0].duration;
    const arrivalDateTime = new Date(Date.now() + travelTimeSeconds * 1000);
    arrivalTime.value = arrivalDateTime.toLocaleTimeString();
    arrivalDate.value = arrivalDateTime.toLocaleDateString();
  } catch (error) {
    console.error('Error calculating travel time and date:', error);
  }
};

// Size and weight conversion functions
const sizeCategory = ref("");
const sizeMeasurements = ref("");
const updateSizeForm = () => {
  const volumeCubicFeet = convertToCubicFeet(length, sizeDropdown) *
    convertToCubicFeet(width, sizeDropdown) *
    convertToCubicFeet(height, sizeDropdown);
  sizeMeasurements.value = `(${length.value} ${sizeDropdown.value.toLowerCase()} ✖ ` +
    `${width.value} ${sizeDropdown.value.toLowerCase()} ✖ ` +
    `${height.value} ${sizeDropdown.value.toLowerCase()})`;

  sizeCategory.value = volumeCubicFeet <= 1 ? "Small" : volumeCubicFeet <= 5 ? "Medium" : "Large";
};

const convertToCubicFeet = (value, unit) => {
  const num = parseFloat(value.value);
  switch (unit.value) {
    case "Feet": return num;
    case "Inches": return num / 12;
    case "Meters": return num * 35.3147;
    case "Centimeters": return num / 30.48;
    default: return 0;
  }
};

const weightCategory = ref("");
const weightMeasurements = ref("");

const updateWeightForm = () => {
  const weightKg = convertToKilograms(weight, weightDropdown);
  weightMeasurements.value = `(${weight.value} ${weightDropdown.value.toLowerCase()})`;
  weightCategory.value = weightKg <= 1 ? "Light" : weightKg <= 5 ? "Moderate" : "Heavy";
};

const convertToKilograms = (value, unit) => {
  const num = parseFloat(value.value);
  switch (unit.value) {
    case "Kg": return num;
    case "Grams": return num / 1000;
    case "Pounds": return num / 2.20462;
    case "Ounces": return num / 35.274;
    default: return 0;
  }
};

watch(
  [sizeCategory, weightCategory],
  () => {
    if (sizeCategory && weightCategory) {
      suggestVehicle();
    }
  });

const suggestVehicle = () => {
  const size = sizeCategory.value;
  const weight = weightCategory.value;

  if (size === "Small" && weight === "Light") {
    vehicleType.value = "Motorcycle";
  } else if (size === "Medium" && (weight === "Light" || weight === "Moderate")) {
    vehicleType.value = "Van";
  } else if (size === "Large" || weight === "Heavy") {
    vehicleType.value = "Truck";
  } else if (size === "Medium" && weight === "Heavy") {
    vehicleType.value = "Truck";
  } else {
    vehicleType.value = "Van";
  }
};

const dialogItem = ref(false);

function openDialog(dialogName, state) {
  const dialog = document.querySelector(`#${dialogName}`);
  if (state === "open") {
    dialog.showModal();
    dialogItem.value = !dialogItem.value;
  } else {
    dialog.close();
    dialogItem.value = !dialogItem.value;
  }
}

const user = ref(null);
const bookingConfirm = async () => {
  const promise = customerRetrieveData();
  promise
    .then((data) => {
      user.value = data;
      console.log("data:", user.value);
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
    });
  if (!user.value) {
    console.error('User not logged in.');
    return;
  }
  const deliveryData = {
    receiverfullname: receiverfullname.value,
    receiverphone: receiverphone.value,
    receivercoordinatesLong: receivercoordinatesLong.value,
    receivercoordinatesLat: receivercoordinatesLat.value,
    receiveraddressInfo: receiveraddressInfo.value,
    senderfullname: senderfullname.value,
    senderphone: senderphone.value,
    sendercoordinatesLong: sendercoordinatesLong.value,
    sendercoordinatesLat: sendercoordinatesLat.value,
    senderaddressInfo: senderaddressInfo.value,
    length: length.value,
    sizeDropdown: sizeDropdown.value,
    width: width.value,
    height: height.value,
    weight: weight.value,
    weightDropdown: weightDropdown.value,
    itemName: itemName.value,
    fragility: fragility.value,
    vehicleType: vehicleType.value,
    notes: notes.value,
  };
  try {
    const deliveryRef = rtdbRef(db, `deliveries/${Date.now()}`);
    await rtdbSet(deliveryRef, deliveryData);
    console.log('Booking confirmed and data saved successfully.');
  } catch (error) {
    console.error('Error confirming booking: ', error);
  }
};


</script>

<style lang="scss" scoped>
* {
  //border: 1px solid red;
}

.map-disabled {
  pointer-events: none;
  opacity: 0.5;
}



div#map>input,
div#map2>input {
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
