<template>
  <SRModalSlots v-show="isOpen == true" @close="
    isOpen = !isOpen;
  StatusView = !StatusView;
  ">
    <template #Modal-Header>
      <div v-show="StatusView == true">
        <div class="relative flex flex-wrap justify-center w-full px-6 pt-6">
          <SRProfile />
          <div id="close-btn" class="absolute right-6 hover:scale-105">
            <span>
              <button @click="isOpen = false" class="w-6">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                  <line x1="10" y1="10" x2="90" y2="90" stroke="currentColor" stroke-width="5" />
                  <line x1="90" y1="10" x2="10" y2="90" stroke="currentColor" stroke-width="5" />
                </svg>
              </button>
            </span>
          </div>
        </div>
        <div class="flex justify-center">
          <div class="block text-center gap">
            <h2 class="pt-6 pb-3 text-3xl font-extrabold">Alexander Bennett</h2>
            <div id="botton"
              class="flex justify-center pt-2 pb-6 gap-x-1 text-white [&>button]:w-9 [&>button]:p-1 [&>button]:rounded-xl [&>button]:bg-[#AA0927]">
              <button v-html="icons.ThumbsUp"></button>
              <button v-html="icons.ThumbsDown"></button>
              <button v-html="icons.Forbidden"></button>
              <button v-html="icons.TimeClock"></button>
              <button v-html="icons.UserX"></button>
            </div>
          </div>
        </div>
      </div>
    </template>
    <template #Modal-Body>
      <div v-show="StatusView == true" class="px-6">
        <div
          class="grid grid-cols-2 py-3 gap-y-1 [&>label]:col-start-1 [&>h2]:col-start-2 [&>h2]:text-[#AA0927] text-lg">
          <label for="">ID:</label>
          <h2>00001</h2>
          <label for="">Email:</label>
          <h2>dummy@email.com</h2>
          <label for="">Date Registered:</label>
          <h2>January 11, 2024</h2>
          <label for="">Address:</label>
          <h2>123 StreetAnytown, CA 90210</h2>
        </div>
      </div>
    </template>
    <template #Modal-Footer>
      <div v-show="StatusView == true" class="w-full px-6">
        <div class="block w-full py-7">
          <div class="flex w-full justify-between [&>h2]:text-lg [&>h2]:font-extrabold items-center">
            <h2>Ratings & Feedback</h2>
            <div class="flex gap-2 [&>button]:w-5 [&>button]:gap-y-1 [&>button]:text-[#ffc800] items-center">
              <div class="flex items-center">
                <button v-html="icons.Star"></button>
                <button v-html="icons.Star"></button>
                <button v-html="icons.Star"></button>
                <button v-html="icons.Star"></button>
                <button v-html="icons.Star"></button>
              </div>
              <h2 class="flex gap-1 [&>p]:text-3xl [&>p]:text-[#AA0927]">
                <p>5.00</p>
                <span class="flex before:content-['('] after:content-[')'] gap-0.5 items-center font-normal">
                  {{ 1 }} <i v-html="icons.User" class="w-[20px] pt-1"></i></span>
              </h2>
            </div>
          </div>
          <div class="pt-3 pb-10">
            <div class="flex py-4 px-5 [&>h2]:text-lg [&>h2]:font-bold gap-5 border-2">
              <h2>Ryan Thompson</h2>
              <div class="flex items-center [&>button]:w-5 [&>button]:gap-y-1 [&>button]:text-[#ffc800]">
                <button v-html="icons.Star"></button>
                <button v-html="icons.Star"></button>
                <button v-html="icons.Star"></button>
                <button v-html="icons.Star"></button>
                <button v-html="icons.Star"></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </SRModalSlots>
  <SRContents>
    <template #Content-Header>
      <h2>Reports</h2>
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
              <th>Address</th>
              <th>Date Hired</th>
              <th>Action</th>
            </template>
            <template #Table-Body>
              <tr>
                <td>00001</td>
                <td>Alexander Benet</td>
                <td>123 StreetAnytown</td>
                <td>1/11/2024</td>
                <td>
                  <div
                    class="flex justify-center gap-x-1 [&>button]:rounded-xl [&>button]:p-1 [&>button]:w-9 [&>button]:bg-[#AA0927] [&>button]:text-white">
                    <button @click="
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
                <td>Mitchel Jordan</td>
                <td>123 StreetAnytown</td>
                <td>1/11/2024</td>
                <td>
                  <div
                    class="flex justify-center gap-x-1 [&>button]:rounded-xl [&>button]:p-1 [&>button]:w-9 [&>button]:bg-[#AA0927] [&>button]:text-white">
                    <button @click="
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