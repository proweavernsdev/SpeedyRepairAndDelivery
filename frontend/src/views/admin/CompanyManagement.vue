<template>
  <SRModalSlots v-show="isOpen == true" @close="
    isOpen = !isOpen;
  StatusView = !StatusView;
  ">
    <template #Modal-Header>
      <div v-show="StatusView == true">
        <div class="relative flex flex-wrap justify-center w-full px-6 pt-6">
          <SRProfile :data="pfp" />
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
            <h2 class="pt-6 pb-3 text-3xl font-extrabold">
              {{ company.comp_companyName }}
            </h2>
            <div id="botton"
              class="flex justify-center pt-2 pb-6 gap-x-1 text-white [&>button]:w-9 [&>button]:p-1 [&>button]:rounded-xl [&>button]:bg-[#AA0927]">
              <button class="hover:bg-rose-600" @click="update(company.companyID, 'approved')">
                <i v-html="icons.ThumbsUp"></i>
              </button>
              <button class="hover:bg-rose-600" @click="update(company.companyID, 'denied')">
                <i v-html="icons.ThumbsDown"></i>
              </button>
              <button class="hover:bg-rose-600" @click="update(company.companyID, 'blocked')">
                <i v-html="icons.Forbidden"></i>
              </button>
              <button class="hover:bg-rose-600" @click="update(company.companyID, 'on_hold')">
                <i v-html="icons.TimeClock"></i>
              </button>
              <button class="hover:bg-rose-600">
                <i v-html="icons.UserX"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </template>
    <template #Modal-Body>
      <div v-show="StatusView == true" class="px-6">
        <div
          class="grid grid-cols-2 py-3 gap-y-1 [&>label]:col-start-1 [&>h2]:col-start-2 [&>h2]:text-[#AA0927] text-lg">
          <p>
            <span class="text-lg font-bold text-red-600">Address: </span>{{ company.comp_address }} <br />
            <span class="text-lg font-bold text-red-600">Town / City: </span>{{ company.comp_towity }} <br />
            <span class="text-lg font-bold text-red-600">State: </span>{{ company.comp_state }} <br />
            <span class="text-lg font-bold text-red-600">ZIP: </span>{{ company.comp_zip }}
          </p>
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
          <div class="pt-3 pb-10"></div>
        </div>
      </div>
    </template>
  </SRModalSlots>
  <SRContents>
    <template #Content-Header>
      <h2>Company</h2>
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
              <th>Status</th>
              <th>Action</th>
            </template>
            <template #Table-Body>
              <tr v-for="items in data" :key="items.id" class="[&>*]:p-5">
                <td class="text-lg">{{ items.companyID }}</td>
                <td>{{ items.comp_companyName }}</td>
                <td>{{ items.comp_address }}</td>
                <td class="capitalize">{{ items.status }}</td>
                <td>
                  <div
                    class="flex justify-center gap-x-1 [&>button]:rounded-md [&>button]:p-1 [&>button]:w-9 [&>button]:bg-[#AA0927] [&>button]:text-white">
                    <button class="hover:bg-rose-600" @click="
                      isOpen = true;
                    StatusView = true;
                    showItem(items.companyID);
                    ">
                      <i v-html="icons.ViewBtn"></i>
                    </button>
                    <button class="hover:bg-rose-600" id="approvedButton"
                      :class="{ 'bg-black': items.status === 'approved' }" @click="
                        update(items.companyID, 'approved', 'approvedButton')
                        ">
                      <i v-html="icons.ThumbsUp"></i>
                    </button>
                    <button class="hover:bg-rose-600" id="deniedButton" :value="items.status"
                      @click="update(items.companyID, 'denied', 'deniedButton')">
                      <i v-html="icons.ThumbsDown"></i>
                    </button>
                    <button class="hover:bg-rose-600" id="blockedButton" :value="items.status" @click="
                      update(items.companyID, 'blocked', 'blockedButton')
                      ">
                      <i v-html="icons.Forbidden"></i>
                    </button>
                    <button class="hover:bg-rose-600" id="on_holdButton" :value="items.status" @click="
                      update(items.companyID, 'on_hold', 'on_holdButton')
                      ">
                      <i v-html="icons.TimeClock"></i>
                    </button>
                    <button class="hover:bg-rose-600">
                      <i v-html="icons.UserX"></i>
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
import SRContents from "@/layouts/SRContents.vue";
import { compRetrieveData } from "@/services/api/company.js";
import { setCompStatus } from "@/services/api/company.js";
import { onMounted, ref } from "vue";

const isOpen = ref(false);
const StatusView = ref(false);
const data = ref([]);
const id = ref(0);
const company = ref([]);
const pfp = ref("");
const userStatus = ref("");
const button = ref("");

function update(companyID, status, buttons) {
  setCompStatus(companyID, status)
    .then(() => {
      getData();
      // console.log(userStatus.value);
      console.log(buttons);
      userStatus.value = status;
      button.value = buttons;
      const element = document.getElementById(`${button.value}`);
      const element2 = document.getElementById(`${button.value}`);
      // if (userStatus.value === "approved") {
      //     element.classList.add("black");
      // } else if (userStatus.value === "denied") {
      //     element.classList.add("black");
      // } else if (userStatus.value === "on_hold") {
      //     element.classList.add("black");
      // } else {
      //     element.classList.add("red");
      // }
    })
    .catch((error) => {
      console.log("Error updating status: ", error);
    });
}

function showItem(comID) {
  company.value = JSON.parse(
    JSON.stringify(data.value.find((item) => item.companyID === comID))
  );
  id.value = comID;
  pfp.value = company.value.comp_businessPhoto;
}

function getData() {
  compRetrieveData()
    .then((info) => {
      data.value = info.result;
      console.log("Retrieved data: ", data.value);
    })
    .catch((error) => {
      console.error("Error fetching data: ", error);
    });
}

onMounted(getData);
</script>


<style lang="scss" scoped>
.red {
  background-color: rgb(220 38 38);
  border-color: rgb(220 38 38);
}

.black {
  background-color: rgb(0 0 0);
  border-color: rgb(0 0 0);
}
</style>