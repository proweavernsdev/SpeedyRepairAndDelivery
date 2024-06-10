<template>
  <SRModalSlots v-show="isOpen == true" @close="
    isOpen = !isOpen;
  StatusView = !StatusView;
  ">
    <template #Modal-Header>
      <div v-show="StatusView == true">
        <div class="flex justify-between px-5 py-5 bg-[#AA0927] text-white text-3xl font-semibold">
          <h2>Delivery</h2>
          <span><button @click="isOpen = false" class="w-6 hover:scale-105">
              <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <line x1="10" y1="10" x2="90" y2="90" stroke="currentColor" stroke-width="5" />
                <line x1="90" y1="10" x2="10" y2="90" stroke="currentColor" stroke-width="5" />
              </svg>
            </button>
          </span>
        </div>
      </div>
    </template>
    <template #Modal-Body>
      <div v-show="StatusView == true" class="px-6">
        <div
          class="grid grid-cols-2 py-3 pr-10 gap-y-1 [&>label]:col-start-1 [&>h2]:col-start-2 [&>h2]:text-[#AA0927] text-lg border-b-2">
          <label for="">Pick-up Location:</label>
          <h2>Dummy Address 1</h2>
          <label for="">Pick-up Location:</label>
          <h2>Dummy Address 2</h2>
        </div>
        <div class="flex items-start [&>h2]:text-[#AA0927] text-lg">
          <div id="left" class="grid grid-cols-2 py-3 gap-y-1 gap-x-6">
            <label for="">Transaction ID:</label>
            <h2>10001</h2>
            <label for="">Customer ID:</label>
            <h2>10001</h2>
            <label for="">Employee ID:</label>
            <h2>10001</h2>
            <label for="">Total Distance:</label>
            <h2>2.3km</h2>
            <label for="">Created:</label>
            <h2>Jan 1, 2024</h2>
            <label for="">Time:</label>
            <h2>6:38AM</h2>
            <label for="">Status:</label>
            <h2>Completed</h2>
          </div>
          <div id="right" class="grid grid-cols-2 py-3 gap-y-1 gap-x-6">
            <label for="">Distance Charge:</label>
            <h2>$2.9</h2>
            <label for="">App Charge:</label>
            <h2>$1.20</h2>
            <label for="">V.A.T:</label>
            <h2>$0.9</h2>
            <label for="">Total:</label>
            <h2>$15.01</h2>
          </div>
        </div>
      </div>
    </template>
    <template #Modal-Footer>
      <div class="w-full px-6 py-16"></div>
    </template>
  </SRModalSlots>
  <SRContents>
    <template #Content-Header>
      <h2>Request Report</h2>
    </template>
    <template #Content-Body>
      <div id="Content-Body-Header"
        class="flex justify-between items-center [&>select]:bg-white [&>select]:border [&>select]:rounded-md [&>select]:px-2 [&>select]:py-1">
        <SRSearchDisplay :AddStatus="true" />
      </div>
      <SRScroll>
        <div id="Content-Body-Main">
          <SRTable>
            <template #Table-Header>
              <th>ID</th>
              <th>Name</th>
              <th>Type</th>
              <th>Date Completed</th>
              <th>Total</th>
              <th>Status</th>
              <th>Action</th>
            </template>
            <template #Table-Body>
              <tr>
                <td>00001</td>
                <td>Alexander Bennet</td>
                <td>Delivery</td>
                <td>Jan 11, 2024</td>
                <td>$15.01</td>
                <td>Completed</td>
                <td>
                  <div
                    class="flex justify-center gap-x-1 [&>button]:rounded-xl [&>button]:p-1 [&>button]:w-9 [&>button]:bg-[#AA0927] [&>button]:text-white">
                    <button class="hover:bg-rose-600" @click="
                      isOpen = true;
                    StatusView = true;
                    ">
                      <i v-html="icons.ViewBtn"></i>
                    </button>
                  </div>
                </td>
              </tr>
              <tr>
                <td>00002</td>
                <td>Jordan Mitchel</td>
                <td>Delivery</td>
                <td>Jan 11, 2024</td>
                <td>$16.99</td>
                <td>Completed</td>
                <td>
                  <div
                    class="flex justify-center gap-x-1 [&>button]:rounded-xl [&>button]:p-1 [&>button]:w-9 [&>button]:bg-[#AA0927] [&>button]:text-white">
                    <button class="hover:bg-rose-600" @click="
                      isOpen = true;
                    StatusView = true;
                    ">
                      <i v-html="icons.ViewBtn"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </template>
          </SRTable>
        </div>
      </SRScroll>
    </template>
  </SRContents>
</template>

<script setup>
import icons from "@/assets/icons.js";

import SRModalSlots from "@/components/SRModalSlots.vue";
import SRProfile from "@/components/SRProfile.vue";
import SRSearchDisplay from "@/components/SRSearchDisplay.vue";
import SRScroll from "@/components/SRScroll.vue";
import SRTable from "@/components/SRTable.vue";

import SRHeader from "@/layouts/SRHeader.vue";
import SRNavbar from "@/layouts/SRNavbar.vue";
import SRContents from "@/layouts/SRContents.vue";
import SRFooter from "@/layouts/SRFooter.vue";

import { ref } from "vue";

let isOpen = ref(false);

let StatusView = ref(false);
</script>

<style lang="scss" scoped></style>