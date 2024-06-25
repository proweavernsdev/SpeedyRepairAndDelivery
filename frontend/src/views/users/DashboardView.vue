<template>
  <SRContents>
    <template #Content-Header>
      <h2>Dashboard</h2>
    </template>
    <template #Content-Body>
      <div class="grid grid-cols-1 gap-4 px-4 mt-8 sm:grid-cols-2 lg:grid-cols-4 sm:px-8">

        <!--Pending Orders-->
        <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow sm:block md:block lg:flex">
          <div class="p-4 bg-gray-500">
            <!-- Replaced old icon with a 'clock' icon -->
            <svg id='Data_Pending_24' width='24' height='24' class="icon icon-tabler icon-tabler-truck text-white h-12 w-12"  viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
              <g transform="matrix(0.48 0 0 0.48 12 12)" >
              <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" translate(-25, -25)" d="M 9.8125 4 C 9.609375 4.035156 9.425781 4.136719 9.28125 4.28125 L 5.4375 8.15625 C 5.382813 8.191406 5.328125 8.234375 5.28125 8.28125 C 5.257813 8.300781 5.238281 8.320313 5.21875 8.34375 C 5.195313 8.375 5.175781 8.40625 5.15625 8.4375 C 5.117188 8.496094 5.085938 8.558594 5.0625 8.625 C 5.027344 8.714844 5.007813 8.808594 5 8.90625 C 4.992188 8.980469 4.992188 9.050781 5 9.125 C 5 9.15625 5 9.1875 5 9.21875 L 5 45 C 5 45.550781 5.449219 46 6 46 L 44 46 C 44.550781 46 45 45.550781 45 45 L 45 9.15625 C 45.003906 9.105469 45.003906 9.050781 45 9 C 45 8.988281 45 8.980469 45 8.96875 C 45 8.949219 45 8.925781 45 8.90625 C 45 8.886719 45 8.863281 45 8.84375 C 44.992188 8.800781 44.980469 8.757813 44.96875 8.71875 C 44.953125 8.664063 44.929688 8.613281 44.90625 8.5625 C 44.894531 8.550781 44.886719 8.542969 44.875 8.53125 C 44.839844 8.464844 44.796875 8.402344 44.75 8.34375 C 44.75 8.332031 44.75 8.324219 44.75 8.3125 C 44.738281 8.300781 44.730469 8.292969 44.71875 8.28125 L 44.6875 8.28125 C 44.667969 8.257813 44.648438 8.238281 44.625 8.21875 L 40.71875 4.28125 C 40.527344 4.09375 40.265625 3.992188 40 4 L 10 4 C 9.96875 4 9.9375 4 9.90625 4 C 9.875 4 9.84375 4 9.8125 4 Z M 10.4375 6 L 39.5625 6 L 41.5625 8 L 30 8 C 29.449219 8 29 8.449219 29 9 C 29 11.277344 27.277344 13 25 13 C 22.722656 13 21 11.277344 21 9 C 21 8.449219 20.550781 8 20 8 L 8.4375 8 Z M 7 10 L 19.1875 10 C 19.675781 12.828125 22.03125 15 25 15 C 27.96875 15 30.324219 12.828125 30.8125 10 L 43 10 L 43 44 L 7 44 Z M 25 19 C 19.488281 19 15 23.488281 15 29 C 15 34.511719 19.488281 39 25 39 C 30.511719 39 35 34.511719 35 29 C 35 23.488281 30.511719 19 25 19 Z M 25 21 C 29.429688 21 33 24.570313 33 29 C 33 33.429688 29.429688 37 25 37 C 20.570313 37 17 33.429688 17 29 C 17 24.570313 20.570313 21 25 21 Z M 24 23 L 24 28.5 L 20.40625 31.1875 L 21.59375 32.8125 L 25.59375 29.8125 L 26 29.5 L 26 23 Z" stroke-linecap="round" />
              </g>
            </svg>
          </div>
          <div class="px-4 text-gray-700">
            <h3 class="text-sm tracking-wider">Pending Orders</h3>
            <p v-if="spinner" class="text-left mt-2">
              <svg class="animate-spin h-5 w-5 text-blue-500 text-left" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V2.83a1 1 0 00-2 0V12H4zm0 0a1 1 0 102 0 1 1 0 00-2 0z"></path>
              </svg>
            </p>
            <p v-if="!spinner" class="text-xl">{{ pendingDeliveries.length }}</p>
          </div>
        </div>

        <!--Ongoing Orders-->
        <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow sm:block md:block lg:flex">
          <div class="p-4 bg-yellow-400">
            <!-- Replaced old icon with a 'moving delivery truck' icon -->
            <svg width='24' height='24' viewBox='0 0 24 24' class="icon icon-tabler icon-tabler-truck text-white h-12 w-12" xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' stroke="white" stroke-width="4"><rect width='24' height='24' stroke='white' opacity='0'/>
                <g transform="matrix(0.4 0 0 0.4 12 12)" >
                  <path style="stroke: none; stroke-width: 4; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" translate(-25, -26.5)" d="M 2.800781 8 C 1.265625 8 0 9.265625 0 10.800781 L 0 37 C 0 38.644531 1.355469 40 3 40 L 7.09375 40 C 7.570313 42.828125 10.039063 45 13 45 C 15.960938 45 18.429688 42.828125 18.90625 40 L 34.09375 40 C 34.570313 42.828125 37.039063 45 40 45 C 42.960938 45 45.429688 42.828125 45.90625 40 L 47 40 C 47.832031 40 48.550781 39.613281 49.082031 39.082031 C 49.613281 38.550781 50 37.832031 50 37 L 50 27.402344 C 50 26.277344 49.582031 25.253906 49.199219 24.46875 C 48.8125 23.6875 48.421875 23.125 48.421875 23.125 L 48.410156 23.113281 L 44.292969 17.589844 L 44.28125 17.578125 C 43.394531 16.46875 41.972656 15 40 15 L 32 15 C 31.640625 15 31.308594 15.082031 31 15.207031 L 31 10.902344 C 31 9.300781 29.699219 8 28.097656 8 Z M 2.800781 10 L 28.097656 10 C 28.5 10 29 10.5 29 10.902344 L 29 38 L 18.90625 38 C 18.429688 35.171875 15.960938 33 13 33 C 10.039063 33 7.570313 35.171875 7.09375 38 L 3 38 C 2.445313 38 2 37.554688 2 37 L 2 10.800781 C 2 10.335938 2.335938 10 2.800781 10 Z M 15 12 C 9.5 12 5 16.5 5 22 C 5 27.5 9.5 32 15 32 C 20.5 32 25 27.5 25 22 C 25 16.5 20.5 12 15 12 Z M 15 14 C 19.398438 14 23 17.601563 23 22 C 23 26.398438 19.398438 30 15 30 C 10.601563 30 7 26.398438 7 22 C 7 17.601563 10.601563 14 15 14 Z M 14 16 L 14 21.5 L 10.402344 24.199219 L 11.597656 25.800781 L 16 22.5 L 16 16 Z M 32 17 L 36 17 L 36 26 C 36 26.832031 36.386719 27.550781 36.917969 28.082031 C 37.449219 28.613281 38.167969 29 39 29 L 48 29 L 48 37 C 48 37.167969 47.886719 37.449219 47.667969 37.667969 C 47.449219 37.886719 47.167969 38 47 38 L 45.90625 38 C 45.429688 35.171875 42.960938 33 40 33 C 37.039063 33 34.570313 35.171875 34.09375 38 L 31 38 L 31 18 C 31 17.832031 31.113281 17.550781 31.332031 17.332031 C 31.550781 17.113281 31.832031 17 32 17 Z M 38 17 L 40 17 C 40.828125 17 42.003906 17.933594 42.71875 18.824219 L 46.78125 24.273438 C 46.78125 24.273438 47.085938 24.710938 47.402344 25.355469 C 47.65625 25.871094 47.800781 26.472656 47.882813 27 L 39 27 C 38.832031 27 38.550781 26.886719 38.332031 26.667969 C 38.113281 26.449219 38 26.167969 38 26 Z M 13 35 C 15.222656 35 17 36.777344 17 39 C 17 41.222656 15.222656 43 13 43 C 10.777344 43 9 41.222656 9 39 C 9 36.777344 10.777344 35 13 35 Z M 40 35 C 42.222656 35 44 36.777344 44 39 C 44 41.222656 42.222656 43 40 43 C 37.777344 43 36 41.222656 36 39 C 36 36.777344 37.777344 35 40 35 Z" stroke-linecap="round" />
                </g>
            </svg>
          </div>
          <div class="px-4 text-gray-700">
            <h3 class="text-sm tracking-wider">Ongoing Orders</h3>
            <p v-if="spinner" class="text-left mt-2">
              <svg class="animate-spin h-5 w-5 text-blue-500 text-left" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V2.83a1 1 0 00-2 0V12H4zm0 0a1 1 0 102 0 1 1 0 00-2 0z"></path>
              </svg>
            </p>
            <p v-if="!spinner" class="text-xl">{{ ongoingDeliveries.length }}</p>
          </div>
        </div>

        <!--Completed Orders-->
        <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow sm:block md:block lg:flex">
          <div class="p-4 bg-green-400">
            <!-- Replaced old icon with a 'wallet' icon -->
            <svg id='Task_Completed_24' width='24' height='24' viewBox='0 0 24 24' class="icon icon-tabler icon-tabler-truck text-white h-12 w-12" xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
              <g transform="matrix(0.43 0 0 0.43 12 12)" >
              <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" translate(-25, -25)" d="M 19 2 C 18.477778 2 17.94539 2.1913289 17.568359 2.5683594 C 17.191329 2.9453899 17 3.4777778 17 4 L 9 4 C 7.346 4 6 5.346 6 7 L 6 45 C 6 46.654 7.346 48 9 48 L 41 48 C 42.388 48 43.559391 47.053484 43.900391 45.771484 C 43.965391 45.525484 44 45.266 44 45 L 44 7 C 44 5.346 42.654 4 41 4 L 33 4 C 33 3.4777778 32.808671 2.9453899 32.431641 2.5683594 C 32.05461 2.1913289 31.522222 2 31 2 L 19 2 z M 19 4 L 31 4 L 31 10 L 19 10 L 19 4 z M 9 6 L 17 6 L 17 8 L 10 8 L 10 44 L 40 44 L 40 8 L 33 8 L 33 6 L 41 6 C 41.551 6 42 6.448 42 7 L 42 45 C 42 45.552 41.551 46 41 46 L 9 46 C 8.449 46 8 45.552 8 45 L 8 7 C 8 6.448 8.449 6 9 6 z M 12 10 L 17 10 C 17 10.522222 17.191329 11.05461 17.568359 11.431641 C 17.94539 11.808671 18.477778 12 19 12 L 31 12 C 31.522222 12 32.05461 11.808671 32.431641 11.431641 C 32.808671 11.05461 33 10.522222 33 10 L 38 10 L 38 42 L 12 42 L 12 10 z M 33.994141 16.988281 C 33.664649526065915 16.992833310125107 33.35854630639755 17.15940027705919 33.175781 17.433594 L 23.541016 31.482422 L 16.675781 25.179688 C 16.415345456836498 24.92247477678013 16.035198523141396 24.828089181210697 15.684699489283883 24.933615204574473 C 15.33420045542637 25.03914122793825 15.069353266434732 25.327717558104137 14.994216076401019 25.685962888870442 C 14.919078886367304 26.044208219636747 15.04565737477632 26.41488087592646 15.324219 26.652344 L 23.886719 34.515625 L 34.824219 18.566406 C 35.04182818830429 18.259231281855108 35.068514839913135 17.85588258436504 34.893272399239976 17.522715729337776 C 34.718029958566824 17.18954887431051 34.370548058092886 16.983009100939746 33.994141 16.988281 z" stroke-linecap="round" />
              </g>
            </svg>
          </div>
          <div class="px-4 text-gray-700">
            <h3 class="text-sm tracking-wider">Completed Orders</h3>
            <p v-if="spinner" class="text-left mt-2">
              <svg class="animate-spin h-5 w-5 text-blue-500 text-left" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V2.83a1 1 0 00-2 0V12H4zm0 0a1 1 0 102 0 1 1 0 00-2 0z"></path>
              </svg>
            </p>
            <p v-if="!spinner" class="text-xl">{{completedDeliveries.length}}</p>
          </div>
        </div>

        <!--Canceled Orders-->
        <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow sm:block md:block lg:flex">
          <div class="p-4 bg-red-400">
            <!-- Replaced old icon with a 'checklist' icon -->
            <svg id='Failed_To_Deliver_Location_24' width='24' height='24' class="icon icon-tabler icon-tabler-truck text-white h-12 w-12" viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
              <g transform="matrix(0.83 0 0 0.83 12 12)" >
              <g style="" >
              <g transform="matrix(1 0 0 1 4.75 5.01)" >
              <path style="stroke: rgb(0,0,0); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-16.75, -17.01)" d="M 16.7501 10.77 C 19.5501 10.77 21.7501 12.97 21.7501 15.77 C 21.7501 20.17 17.8501 22.67 16.9501 23.17 C 16.8501 23.27 16.6501 23.27 16.5501 23.17 C 15.6501 22.67 11.7501 20.17 11.7501 15.77 C 11.7501 12.97 13.9501 10.77 16.7501 10.77 Z" stroke-linecap="round" />
              </g>
              <g transform="matrix(1 0 0 1 4.7 4.32)" >
              <path style="stroke: rgb(0,0,0); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-16.7, -16.32)" d="M 15.0502 14.67 L 18.3502 17.97" stroke-linecap="round" />
              </g>
              <g transform="matrix(1 0 0 1 4.7 4.32)" >
              <path style="stroke: rgb(0,0,0); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-16.7, -16.32)" d="M 18.3502 14.67 L 15.0502 17.97" stroke-linecap="round" />
              </g>
              <g transform="matrix(1 0 0 1 -0.75 0)" >
              <path style="stroke: rgb(0,0,0); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-11.25, -12)" d="M 8.94988 18.75 L 3.74988 18.75 C 2.94988 18.75 2.24988 18.05 2.24988 17.25 L 2.24988 6.75 C 2.24988 5.95 2.94988 5.25 3.74988 5.25 L 18.7499 5.25 C 19.5499 5.25 20.2499 5.95 20.2499 6.75 L 20.2499 8.65" stroke-linecap="round" />
              </g>
              <g transform="matrix(1 0 0 1 -0.75 -8.8)" >
              <path style="stroke: rgb(0,0,0); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-11.25, -3.2)" d="M 19.7499 5.65001 L 16.9499 1.45 C 16.6499 1.05 16.2499 0.75 15.7499 0.75 L 6.84988 0.75 C 6.34988 0.75 5.84988 1.05 5.64988 1.45 L 2.74988 5.65001" stroke-linecap="round" />
              </g>
              <g transform="matrix(1 0 0 1 -0.75 -9)" >
              <path style="stroke: rgb(0,0,0); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-11.25, -3)" d="M 11.2499 0.75 L 11.2499 5.25" stroke-linecap="round" />
              </g>
              </g>
              </g>
            </svg>
          </div>
          <div class="px-4 text-gray-700">
            <h3 class="text-sm tracking-wider">Canceled Orders</h3>
            <p class="text-xl">{{ canceledDeliveries.length }} </p>
          </div>
        </div>

      </div>

    <!--Charts-->
    <div class="grid grid-cols-1 gap-4 mt-8 px-4 sm:grid-cols-2 sm:px-8">
      <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow sm:col-span-2 lg:col-span-1 lg:ml-4">
        <h3 class="text-lg sm:text-xl text-gray-600 mb-4">Completed Booking by Month</h3>
        <!--Line Chart-->
        <apexchart type="area" :height="300" :options="{
          chart: { id: 'areaChart' },
          colors: ['rgb(170, 9, 39)'], // Keep the color as is
          xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] },
          responsive: [
            {
            breakpoint: 640,
            options: {
              chart: {
                width: '100%'
              },
              legend: {
                position: 'bottom'
              }
            }
          }
        ]
        }" :series="[ { name: 'Bookings', data: getCompletedByMonth()} ]"></apexchart>
      </div>
    
      <!--Pie Chart-->
      <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow sm:col-span-2 lg:col-span-1 lg:ml-4">
        <h3 class="text-lg sm:text-xl text-gray-600 mb-4">Booking Status Distribution</h3>
        <apexchart type="pie" height="350" :options="{
          labels: ['Successful', 'Ongoing', 'Canceled'],
          colors: ['rgb(52, 211, 153)', 'rgb(234, 179, 8)', 'rgb(248, 113, 113)'],
          dataLabels: {
            enabled: true,
            style: {
              colors: ['#000']
            }
          },
          responsive: [{
            breakpoint: 480,
            options: {
              chart: {
                width: '100%'
              },
              legend: {
                position: 'bottom'
              }
            }
          }]
        }" :series="[(completedDeliveries.length/totalDeliveries)*100, (ongoingDeliveries.length/totalDeliveries)*100, (canceledDeliveries.length/totalDeliveries)*100]"></apexchart>
      </div>
      
    </div>
    </template>
  </SRContents>
</template>

<script setup>
import SRContents from "@/layouts/SRContents.vue";
import { useRouter, useRoute } from "vue-router";
import { customerRetrieveData } from "@/services/customer.js";
import { onMounted, ref, watch, computed } from 'vue';
import icons from "@/assets/icons";
import SRTable from "@/components/SRTable.vue";
import SRScroll from "@/components/SRScroll.vue";
import { db } from '@/services/firebaseConfig';
import { set as rtdbSet, ref as rtdbRef, get as rtdbGet } from 'firebase/database';

var userStatus = ref("");

const taskTable = ref('all');
const itemName = ref('');
const userId = ref('');
const pendingDeliveries = ref([]);
const ongoingDeliveries = ref([]);
const completedDeliveries = ref([]);
const canceledDeliveries = ref([]);
const totalDeliveries = computed(() => {
    return pendingDeliveries.value.length + ongoingDeliveries.value.length + completedDeliveries.value.length + canceledDeliveries.value.length;
})



function openDialog(dialogName, action) {
    const dialog = document.getElementById(dialogName);
    if (dialog && action === "open") {
        dialog.showModal();
    } else if (dialog && action === "close") {
        dialog.close();
    }
}

function getCompletedByMonth() {
    let bookingCount = new Array(12).fill(0); // Initialize with zeros
    completedDeliveries.value.forEach(item => {
        const date = new Date(item.dateCompleted);
        bookingCount[date.getMonth()] += 1; // Increment the count for the month
    });
    return bookingCount;
}

let itemData = ref([]);
function openBooking(dialogName, table, state, trackingNumber) {
    itemName.value = table;
    const dialog = document.getElementById(dialogName);
    if (dialog && state === "open") {
        dialog.showModal();
        itemData.value = pendingDeliveries.value.find(item => item.trackingNumber === trackingNumber);
        console.log('Item Data:', itemData.value);
    } else {
        dialog.close();
    }
}

function viewTableContents(table) {
    taskTable.value = table;
}


async function getData() {
    try {
        const data = await customerRetrieveData();
        userId.value = data.data.cust_userOwner;
        const pendingRef = rtdbRef(db, `deliveries/${userId.value}/pending`);
        if (pendingRef) {
            const snapshot = await rtdbGet(pendingRef);
            if (snapshot.exists()) {
                const pendingData = snapshot.val();
                pendingDeliveries.value = Object.values(pendingData);
            } else {
                console.log('No pending deliveries found');
            }
        }
        const ongoingRef = rtdbRef(db, `deliveries/${userId.value}/accepted`);
        if (ongoingRef) {
            const snapshot = await rtdbGet(ongoingRef);
            if (snapshot.exists()) {
                const ongoingData = snapshot.val();
                ongoingDeliveries.value = Object.values(ongoingData);
            } else {
                console.log('No ongoing deliveries found');
            }
        }
        const completedRef = rtdbRef(db, `deliveries/${userId.value}/completed`);
        if (completedRef) {
            const snapshot = await rtdbGet(completedRef);
            if (snapshot.exists()) {
                const completedData = snapshot.val();
                completedDeliveries.value = Object.values(completedData);
            } else {
                console.log('No completed deliveries found');
            }
        }
      const canceledRef = rtdbRef(db, `deliveries/${userId.value}/canceled`);
      if (canceledRef) {
        const snapshot = await rtdbGet(canceledRef);
        if (snapshot.exists()) {
          const canceledData = snapshot.val();
          canceledDeliveries.value = Object.values(canceledData);
        } else {
          console.log('No canceled deliveries found');
        }
      }
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

const router = useRouter();
const route = useRoute();
onMounted(async () => {
  await getData();
  const promise = customerRetrieveData();
  promise
    .then((data) => {
      if (data.data === null) {
        data.data = "null";
      }
      const isDataContained = data.data;
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
    });
});
</script>

<style scoped></style>
