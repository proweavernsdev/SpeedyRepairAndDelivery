<template>
  <SRModalSlots v-show="isOpen == true" @close="isOpen = false">
    <template #Modal-Header>
      <div class="flex justify-between px-5 py-5 bg-[#AA0927] text-white text-3xl font-semibold">
        <h2 v-show="RequestPriorityCreate == true">Create Request Priority</h2>
        <h2 v-show="StatusView == true">View Request Priority</h2>
        <h2 v-show="RequestPriorityUpdate == true">Edit Request Priority</h2>
        <h2 v-show="RequestPriorityDelete == true">Delete Request Priority</h2>
        <span><button @click="isOpen = false" class="w-6">
            <svg class="hover:scale-105" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
              <line x1="10" y1="10" x2="90" y2="90" stroke="currentColor" stroke-width="5" />
              <line x1="90" y1="10" x2="10" y2="90" stroke="currentColor" stroke-width="5" />
            </svg>
          </button>
        </span>
      </div>
    </template>
    <template #Modal-Body>
      <div class="mx-6 mb-6">
        <div v-show="RequestPriorityCreate == true" id="create">
          <div
            class="grid grid-cols-2 mt-16 gap-y-3 [&>label]:col-start-1 [&>input]:col-start-2 text-xl font-normal [&>input[type=text]]:border-2">
            <label for="">Request Priority Name: </label><input type="text"
              class="p-2 rounded focus:border-gray-400 focus:outline-none" /><br />
            <label for="">Email: </label><input type="text"
              class="p-2 rounded focus:border-gray-400 focus:outline-none" /><br />
            <label for="">Password:</label><input type="text"
              class="p-2 rounded focus:border-gray-400 focus:outline-none" /><br />
            <label for="">Address:</label><input type="text"
              class="p-2 rounded focus:border-gray-400 focus:outline-none" /><br />
            <label for="">Upload Documents:</label><input type="file" name="" id=""
              class="file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 focus:border-gray-400 focus:outline-none" />
          </div>
        </div>
        <div v-show="StatusView == true" id="view">
          <div id="modal-body-header" class="flex justify-center pt-6">
            <SRProfile />
          </div>
          <div id="modal-body-conent"
            class="grid grid-cols-2 mt-8 gap-y-3 [&>label]:col-start-1 [&>h2]:col-start-2 text-xl font-normal [&>h2]:text-[#AA0927]">
            <label for="">Request Priority Name: </label>
            <h2>TechNova Sollutions</h2>
            <br />
            <label for="">Email: </label>
            <h2>dummy@email.com</h2>
            <br />
            <label for="">Password:</label>
            <h2>password123</h2>
            <br />
            <label for="">Address:</label>
            <h2>123 StreetAnytown, CA 90210</h2>
          </div>
        </div>
        <div v-show="RequestPriorityUpdate == true">
          <div id="modal-body-header" class="flex justify-center pt-6">
            <SRProfile />
          </div>
          <div
            class="grid grid-cols-2 mt-8 gap-y-3 [&>label]:col-start-1 [&>input]:col-start-2 text-xl font-normal [&>input[type=text]]:border-2">
            <label for="">Request Priority Name: </label><input type="text"
              class="p-2 rounded focus:outline-none focus:border-gray-400" /><br />
            <label for="">Email: </label><input type="text"
              class="p-2 rounded focus:border-gray-400 focus:outline-none" /><br />
            <label for="">Password:</label><input type="text"
              class="p-2 rounded focus:border-gray-400 focus:outline-none" /><br />
            <label for="">Address:</label><input type="text"
              class="p-2 rounded focus:border-gray-400 focus:outline-none" /><br />
            <label for="">Upload Documents:</label><input type="file" name="" id=""
              class="file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 focus:border-gray-400 focus:outline-none" />
          </div>
        </div>
        <div v-show="RequestPriorityDelete == true" id="delete" class="pt-5 text-3xl font-bold text-center">
          <h2>Are you sure you want to delete?</h2>
        </div>
      </div>
    </template>
    <template #Modal-Footer>
      <div class="flex justify-end w-full px-6 py-5">
        <div v-show="RequestPriorityCreate == true">
          <button class="w-[223px] h-[64px] rounded-2xl bg-[#09aa3c] text-2xl text-white font-bold hover:bg-green-600">
            Create
          </button>
        </div>
        <div v-show="StatusView == true">
          <button class="w-[223px] h-[64px] rounded-2xl bg-[#aa0927] text-2xl text-white font-bold hover:bg-rose-950">
            Close
          </button>
        </div>
        <div v-show="RequestPriorityUpdate == true">
          <button class="w-[223px] h-[64px] rounded-2xl bg-[#09aa3c] text-2xl text-white font-bold hover:bg-green-600">
            Update
          </button>
        </div>
        <div v-show="RequestPriorityDelete == true">
          <button class="w-[223px] h-[64px] rounded-2xl bg-[#aa0927] text-2xl text-white font-bold hover:bg-rose-950">
            Delete
          </button>
        </div>
      </div>
    </template>
  </SRModalSlots>
  <SRContents>
    <template #Content-Header>
      <div class="flex justify-between">
        <h2>Request Priority</h2>
      </div>
    </template>
    <template #Content-Body>
      <div class="flex flex-col flex-wrap justify-center m-3 rounded-lg sm:p-2 sm:m-0 h-min">
        <div class="flex flex-row items-center justify-between">
          <p class="text-2xl font-bold">Criteria</p>
          <div class="flex gap-x-2">
            <button @click="isOpen = true;
            RequestPriorityCreate = true;
            RequestPriorityUpdate = false;
            RequestPriorityDelete = false;" class="w-12 md:w-8 hover:scale-105" v-html="icons.AddBtn"></button>
          </div>
        </div>
        <div
          class="flex flex-row flex-wrap justify-left h-min [&>div]:max-w-96 [&>div]:w-full [&>div]:min-h-[250px] [&>div]:h-min lg:[&>div]:w-[45%] md:flex-col md:[&>div]:w-auto sm:m-0 sm:p-1">
          <div class="p-6 m-3 bg-white border-2 rounded-xl sm:m-2">
            <div class="flex items-center justify-between">
              <p class="flex text-lg font-bold justify-left">Distance from Pickup</p>
              <div
                class="flex gap-x-1 [&>button]:p-1.5 [&>button]:w-8 [&>button]:bg-[#AA0927] [&>button]:text-white [&>button]:rounded-full">
                <button class="hover:bg-rose-600" @click="isOpen = true;
                RequestPriorityCreate = false;
                RequestPriorityUpdate = true;
                RequestPriorityDelete = false;" v-html="icons.EdtBtn"></button>
                <button class="hover:bg-rose-600" @click="
                  isOpen = true;
                RequestPriorityCreate = false;
                RequestPriorityUpdate = false;
                RequestPriorityDelete = true;
                " v-html="icons.DelBtn"></button>
              </div>
            </div>
            <div class="flex justify-between gap-1 py-8 m-2">
              <input type="range" min="0" max="4"
                class="accent-[#AA0927] w-[88%] focus:border-gray-400 focus:outline-none" @input="updateOutput" />
              <button class="text-[#AA0927] hover:scale-105" v-html="icons.QuestionMarkCircle"
                @click="openDescription('distance')"></button>
            </div>
            <p class="flex flex-col" id="distance" v-show="distancePrioritization == true">
              <span class="text-sm">Description:</span>
              <span class="text-xs">Prioritize requests based on distance from pick-up
                location.</span>
            </p>
          </div>
          <div class="p-6 m-3 bg-white border-2 rounded-xl sm:m-2">
            <div class="flex items-center justify-between">
              <p class="flex text-lg font-bold justify-left">Request Pending Time </p>
              <div
                class="flex gap-x-1 [&>button]:p-1.5 [&>button]:w-8 [&>button]:bg-[#AA0927] [&>button]:text-white [&>button]:rounded-full">
                <button class="hover:bg-rose-600" @click="isOpen = true;
                RequestPriorityCreate = false;
                RequestPriorityUpdate = true;
                RequestPriorityDelete = false;" v-html="icons.EdtBtn"></button>
                <button class="hover:bg-rose-600" @click="
                  isOpen = true;
                RequestPriorityCreate = false;
                RequestPriorityUpdate = false;
                RequestPriorityDelete = true;
                " v-html="icons.DelBtn"></button>
              </div>
            </div>
            <div class="flex justify-between gap-1 py-8 m-2">
              <select id="pending-time-dropdown"
                class="bg-red-900 border border-red-900 text-red-900 text-sm rounded-lg focus:ring-red-900 focus:border-red-900 block p-2.5 dark:bg-red-900 dark:border-red-900 dark:placeholder-red-900 dark:text-white dark:focus:ring-red-900 dark:focus:border-red-900 w-[88%]"
                v-model="selectedPriority">
                <option value="urgent">Urgent</option>
                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
              </select>
              <button class="text-[#AA0927] hover:scale-105" v-html="icons.QuestionMarkCircle"
                @click="openDescription('time')"></button>
            </div>
            <div class="" id="time" v-show="timePrioritization == true">
              <p class="text-sm">Description:</p>
              <p class="text-xs">
                Select the priority level for pending requests based on their
                time duration. Requests with longer pending times will be
                prioritized according to the selected level.
              </p>
              <p class="text-xs">For example:</p>
              <ul class="w-auto text-xs list-disc list-inside">
                <li>Urgent: Requests pending for less than 1 hour</li>
                <li>High: Requests pending for 1-4 hours</li>
                <li>Medium: Requests pending for 4-12 hours</li>
                <li>Low: Requests pending for more than 12 hours</li>
              </ul>
            </div>
          </div>
          <div class="p-6 m-3 bg-white border-2 rounded-xl sm:m-2">
            <div class="flex items-center justify-between">
              <p class="flex text-lg font-bold justify-left">Requests Canceled by Riders</p>
              <div
                class="flex gap-x-1 [&>button]:p-1.5 [&>button]:w-8 [&>button]:bg-[#AA0927] [&>button]:text-white [&>button]:rounded-full">
                <button class="hover:bg-rose-600" @click="isOpen = true;
                RequestPriorityCreate = false;
                RequestPriorityUpdate = true;
                RequestPriorityDelete = false;" v-html="icons.EdtBtn"></button>
                <button class="hover:bg-rose-600" @click="
                  isOpen = true;
                RequestPriorityCreate = false;
                RequestPriorityUpdate = false;
                RequestPriorityDelete = true;
                " v-html="icons.DelBtn"></button>
              </div>
            </div>
            <div class="flex flex-col items-center justify-center gap-1 py-8 m-2">
              <input type="checkbox" id="cancel-toggle"
                class="w-8 h-8 accent-[#AA0927] form-checkbox focus:border-gray-400 focus:outline-none"
                v-model="prioritizeCanceledRequests" />
              <div class="flex flex-row justify-between gap-1">
                <div>
                  <span v-if="prioritizeCanceledRequests">Prioritize canceled requests</span>
                  <span v-else>Do not prioritize canceled requests</span>
                </div>
                <button class="text-[#AA0927] hover:scale-105" v-html="icons.QuestionMarkCircle"
                  @click="openDescription('canceled')"></button>
              </div>
            </div>
            <p class="flex flex-col" id="canceled" v-show="cancelledPrioritization == true">
              <span class="text-sm">Description:</span>
              <span class="text-xs">
                <p>
                  Use the toggle switch to enable or disable the prioritization
                  of requests canceled by riders. When enabled, canceled
                  requests will be prioritized according to the configured
                  criteria. When disabled, canceled requests will not be
                  prioritized and will be treated similarly to other requests.
                </p>
              </span>
            </p>
          </div>
        </div>
      </div>
    </template>
  </SRContents>
</template>

<script setup>
import icons from "@/assets/icons";

import SRModalSlots from "@/components/SRModalSlots.vue";
import SRProfile from "@/components/SRProfile.vue";
import SRContents from "@/layouts/SRContents.vue";
import { ref } from "vue";

//
let isOpen = ref(Boolean);
let StatusView = ref(false);
let RequestPriorityCreate = ref(false);
let RequestPriorityUpdate = ref(false);
let RequestPriorityDelete = ref(false);
const PriorityLevelName = ref("Medium Priority");
let selectedPriority = ref("urgent");
let prioritizeCanceledRequests = ref(false);
let distancePrioritization = ref(false);
let timePrioritization = ref(false);
let cancelledPrioritization = ref(false);

function updateOutput(event) {
  const PriorityLevel = event.target.value;
  if (PriorityLevel === "0") {
    PriorityLevelName.value = "Low Priority";
  } else if (PriorityLevel === "2") {
    PriorityLevelName.value = "Medium-Low Priority";
  } else if (PriorityLevel === "3") {
    PriorityLevelName.value = "Medium Priority";
  } else if (PriorityLevel === "4") {
    PriorityLevelName.value = "High Priority";
  } else if (PriorityLevel === "5") {
    PriorityLevelName.value = "Very High Priority";
  }
}

function openDescription(i) {
  console.log(i);
  if (i === "distance") {
    distancePrioritization.value = !distancePrioritization.value;
    console.log("distancePrioritization: " + distancePrioritization.value);
  } else if (i === "time") {
    timePrioritization.value = !timePrioritization.value;
    console.log("timePrioritization: " + timePrioritization.value);
  } else if (i === "canceled") {
    cancelledPrioritization.value = !cancelledPrioritization.value;
    console.log("cancelledPrioritization: " + cancelledPrioritization.value);
    console.log(cancelledPrioritization.value == true);
  } else {
    console.log(i);
  }
}
</script>
<style lang="scss" scoped></style>
