<template>
  <SRModalSlots v-show="isOpen == true" @close="isOpen = false">
    <template #Modal-Header>
      <div class="flex justify-between px-5 py-5 bg-[#AA0927] text-white text-3xl font-semibold">
        <h2 v-show="StatusCreate == true">Create Employee</h2>
        <h2 v-show="StatusView == true">View Employee</h2>
        <h2 v-show="StatusUpdate == true">Edit Employee</h2>
        <h2 v-show="StatusDelete == true">Delete Employee</h2>
        <h2 v-show="StatusSearch == true">Search Employee</h2>
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
        <div v-show="StatusCreate == true" id="create">
          <form id="createEmployee"
            class="grid grid-cols-2 mt-16 gap-y-3 [&>label]:col-start-1 [&>input]:col-start-2 text-xl font-normal [&>input[type=text]]:border-2"
            @submit.prevent="createEmployee(fname, lname, email, password)">
            <label for="fname" class="flex items-center">First Name: </label><input type="text"
              class="p-2 text-lg rounded focus:border-gray-400 focus:outline-none" id="fname" v-model="fname" /><br />
            <label for="lname" class="flex items-center">Last Name: </label><input type="text"
              class="p-2 text-lg rounded focus:border-gray-400 focus:outline-none" id="lname" v-model="lname" /><br />
            <label for="email" class="flex items-center">Email: </label><input type="text"
              class="p-2 text-lg rounded focus:border-gray-400 focus:outline-none" id="email" v-model="email" /><br />
            <label for="password" class="flex items-center">Password:</label><input type="password"
              class="p-2 text-lg border-2 rounded focus:border-gray-400 focus:outline-none" id="password"
              v-model="password" /><br />
          </form>
        </div>
        <div v-show="StatusView == true" id="view">
          <div id="modal-body-header" class="flex justify-center pt-6">
            <SRProfile :image="pfp" />
          </div>
          <div id="modal-body-conent"
            class="grid grid-cols-2 mt-8 gap-y-3 [&>label]:col-start-1 [&>h2]:col-start-2 text-xl font-normal [&>h2]:text-[#550514]">
            <label for="">First Name: </label>
            <h2>{{ employee.subs_firstName }}</h2>
            <br />
            <label for="">Last Name: </label>
            <h2>{{ employee.subs_lastName }}</h2>
            <br />
            <label for="">Status:</label>
            <h2>{{ employee.status }}</h2>
            <br />
          </div>
        </div>
        <div v-show="StatusUpdate == true">
          <div id="modal-body-header" class="flex justify-center pt-6">
            <SRProfile :image="pfp" />
          </div>
          <div
            class="grid grid-cols-2 mt-8 gap-y-3 [&>label]:col-start-1 [&>input]:col-start-2 text-xl font-normal [&>input[type=text]]:border-2">
            <label for="" class="flex items-center justify-center">Employee Name: </label><input type="text"
              class="p-2 rounded focus:border-gray-400 focus:outline-none" /><br />
            <label for="" class="flex items-center justify-center">Email: </label><input type="text"
              class="p-2 rounded focus:border-gray-400 focus:outline-none" /><br />
            <label for="" class="flex items-center justify-center">Password:</label><input type="text"
              class="p-2 rounded focus:border-gray-400 focus:outline-none" /><br />
            <label for="" class="flex items-center justify-center">Address:</label><input type="text"
              class="p-2 rounded focus:border-gray-400 focus:outline-none" /><br />
            <label for="" class="flex items-center justify-center">Upload Documents:</label><input type="file" name=""
              id=""
              class="file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 focus:border-gray-400 focus:outline-none" />
          </div>
        </div>
        <div v-show="StatusDelete == true" id="delete" class="pt-5 text-3xl font-bold text-center">
          <h2>Are you sure you want to delete?</h2>
        </div>
        <div v-show="StatusSearch == true" id="search" class="pt-5 text-3xl font-bold text-center">
          <input type="text"
            class="border-2 border-rose-500 p-2.5 rounded  focus:border-gray-400 focus:outline-none" /><br />
        </div>
      </div>
    </template>
    <template #Modal-Footer>
      <div class="flex justify-end w-full px-6 py-5">
        <div v-show="StatusCreate == true">
          <button id="createEmp" type="submit"
            class="w-[223px] h-[64px] rounded-2xl bg-[#09aa3c] text-2xl text-white font-bold hover:bg-green-600"
            form="createEmployee" @click="sendCreateEmployee">
            Create
          </button>
        </div>
        <div v-show="StatusView == true">
          <button class="w-[223px] h-[64px] rounded-2xl bg-[#aa0927] text-2xl text-white font-bold hover:bg-rose-950">
            Close
          </button>
        </div>
        <div v-show="StatusUpdate == true">
          <button class="w-[223px] h-[64px] rounded-2xl bg-[#09aa3c] text-2xl text-white font-bold hover:bg-green-600">
            Update
          </button>
        </div>
        <div v-show="StatusDelete == true">
          <button class="w-[223px] h-[64px] rounded-2xl bg-[#aa0927] text-2xl text-white font-bold hover:bg-rose-950">
            Delete
          </button>
        </div>
        <div v-show="StatusSearch == true">
          <button class="w-[223px] h-[64px] rounded-2xl bg-[#09aa3c] text-2xl text-white font-bold hover:bg-green-600">
            Search
          </button>
        </div>
      </div>
    </template>
  </SRModalSlots>
  <SRContents>
    <template #Content-Header>
      <div class="flex justify-between">
        <h2>Employees Management</h2>
        <div class="flex gap-x-2">
          <button @click="
            isOpen = true;
          StatusView = false;
          StatusCreate = true;
          StatusUpdate = false;
          StatusDelete = false;
          StatusSearch = false;
          " class="w-12 md:w-8 hover:scale-105" v-html="icons.AddBtn"></button>
          <button @click="
            isOpen = true;
          StatusView = false;
          StatusCreate = false;
          StatusUpdate = false;
          StatusDelete = false;
          StatusSearch = true;
          " class="w-10 md:w-8 hover:scale-105" v-html="icons.Search"></button>
        </div>
      </div>
    </template>
    <template #Content-Body>
      <SRScroll>
        <SRTable>
          <template #Table-Header>
            <th class="w-[25%]">First Name</th>
            <th class="w-[25%]">Last Name</th>
            <th class="w-[20%]">Status</th>
            <th class="w-[12%] 3xl:w-[18%]">Action</th>
          </template>
          <template #Table-Body>
            <tr v-for="items in data" :key="items.id" class="[&>*]:p-5">
              <td>{{ items.subs_firstName }}</td>
              <td>{{ items.subs_lastName }}</td>
              <td>{{ items.status }}</td>
              <td>
                <div
                  class="flex justify-center gap-x-1 [&>button]:p-1 [&>button]:w-9 [&>button]:bg-[#AA0927] [&>button]:text-white [&>button]:rounded-lg">
                  <button class="hover:bg-rose-600" @click="
                    isOpen = true;
                  StatusView = true;
                  StatusCreate = false;
                  StatusUpdate = false;
                  StatusDelete = false;
                  viewEmployee(items.sub_userID);
                  " v-html="icons.ViewBtn"></button>
                  <button class="hover:bg-rose-600" @click="
                    isOpen = true;
                  StatusView = false;
                  StatusCreate = false;
                  StatusUpdate = true;
                  StatusDelete = false;
                  " v-html="icons.EdtBtn"></button>
                  <button class="hover:bg-rose-600" @click="
                    isOpen = true;
                  StatusView = false;
                  StatusCreate = false;
                  StatusUpdate = false;
                  StatusDelete = true;
                  " v-html="icons.DelBtn"></button>
                </div>
              </td>
            </tr>
          </template>
        </SRTable>
      </SRScroll>
    </template>
  </SRContents>
</template>

<script setup>
import icons from "@/assets/icons";
import SRModalSlots from "@/components/SRModalSlots.vue";
import SRProfile from "@/components/SRProfile.vue";
import SRTable from "@/components/SRTable.vue";
import SRScroll from "@/components/SRScroll.vue";
import SRContents from "@/layouts/SRContents.vue";
import {
  retrieveEmployee,
  employeeRegistration,
} from "@/services/ApiServices.js";
import { onMounted, ref } from "vue";

const fname = ref("");
const lname = ref("");
const email = ref("");
const password = ref("");
const employee = ref("");
const isOpen = ref(false);
const data = ref([]);
const button = ref("");
const pfp = ref("");

function sendCreateEmployee() {
  document.getElementById("createEmp").addEventListener("click", () => {
    document.getElementById("createEmployee").submit();
  });
}

function viewEmployee(employeeid) {
  employee.value = JSON.parse(
    JSON.stringify(data.value.find((item) => item.sub_userID === employeeid))
  );
  pfp.value = employee.value.subs_userPhoto;
}

function getData() {
  retrieveEmployee()
    .then((info) => {
      data.value = JSON.parse(JSON.stringify(info.results));
      console.log(info.results);
    })
    .catch((error) => {
      console.error(error);
    });
}

function createEmployee(fname, lname, email, password) {
  employeeRegistration(email, password, fname, lname)
    .then((info) => {
      data.value = info.results;
      console.log(data.value);
    })
    .catch((error) => {
      console.error(error);
    });
}

onMounted(getData);
</script>


<style lang="scss" scoped></style>