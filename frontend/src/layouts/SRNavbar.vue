<template>
  <nav
    class="fixed pt-16 max-w-[310px] h-screen w-full bg-[#0E0E0E] overflow-hidden lg:absolute lg:max-w-full lg:pt-16 lg:h-auto"
    :class="{
      'lg:w-2/4 md:w-full lg:h-screen lg:transition-all lg:z-30 float-left': navBar,
      'lg:w-0 lg:h-screen lg:transition-all': !navBar,
    }">
    <div id="admin" v-if="userStatus == 0" class="flex flex-col justify-between h-full pb-2">
      <div>
        <p class="mx-6 my-6 text-sm font-bold uppercase text-slate-500">
          Management
        </p>
        <ul
          class="flex flex-col w-full gap-1 text-base font-bold text-white lg:flex-wrap lg:justify-center lg md:block md:overflow-hidden">
          <RouterLink :to="`/admin/dashboard`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Home" class="text-slate-500 hover:text-[#AA0927]"></i>
              </span>
              <span>Dashboard</span>
            </li>
          </RouterLink>
          <RouterLink :to="`/admin/account`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Gear" class="text-slate-500"></i>
              </span>
              <span>Account Management</span>
            </li>
          </RouterLink>
          <div>
            <button @click="dropDown('user')"
              class="flex items-center w-[88%] p-3 transition-all rounded mx-5 hover:bg-white hover:text-[#AA0927] active:text-[#AA0927] lg:w-[95%]">
              <li class="flex justify-between w-full">
                <span class="flex items-center">
                  <span class="flex justify-center mr-2">
                    <i v-html="icons.User" class="text-slate-500 hover:text-[#AA0927]"></i>
                  </span>
                  <span>Users Management </span>
                </span>
                <span class="flex justify-center fill-cyan-500 hover:fill-cyan-700">
                  <i v-if="isDropdownOpenUser === false" v-html="icons.DownTriangle"></i>
                  <i v-else v-html="icons.UpTriangle"></i>
                </span>
              </li>
            </button>
            <ul id="user" class="hidden transition-all">
              <RouterLink class-active="active" :to="`/admin/manage/company`">
                <li class="transition-all text-slate-500 hover:text-[#AA0927]">
                  Companies
                </li>
              </RouterLink>
              <RouterLink class-active="active" :to="`/admin/manage/customer`">
                <li class="transition-all text-slate-500 hover:text-[#AA0927]">
                  Customers
                </li>
              </RouterLink>
              <RouterLink class-active="active" :to="`/admin/manage/riders`">
                <li class="transition-all text-slate-500 hover:text-[#AA0927]">
                  Delivery Riders
                </li>
              </RouterLink>
            </ul>
          </div>
          <div class="">
            <button @click="dropDown('custom')"
              class="flex items-center w-[88%] p-3 transition-all rounded mx-5 hover:bg-white hover:text-[#AA0927] lg:w-[95%]">
              <li class="flex justify-between w-full">
                <span class="flex items-center">
                  <span class="flex justify-center mr-2">
                    <i v-html="icons.Custom" class="text-slate-500 hover:text-[#AA0927]"></i>
                  </span>
                  <span>Customization </span>
                </span>
                <span class="flex flex-col justify-center">
                  <i v-if="isDropdownOpenCustom === false" v-html="icons.DownTriangle"></i>
                  <i v-else v-html="icons.UpTriangle"></i>
                </span>
              </li>
            </button>
            <ul id="customize" class="hidden">
              <RouterLink class-active="active" :to="`/admin/customization/taxonomies`">
                <li class="transition-all text-slate-500 hover:text-[#AA0927]">
                  Taxonomies
                </li>
              </RouterLink>
              <RouterLink class-active="active" :to="`/admin/customization/fees`">
                <li class="transition-all text-slate-500 hover:text-[#AA0927]">
                  Fees
                </li>
              </RouterLink>
              <RouterLink class-active="active" :to="`/admin/customization/requestpriority`">
                <li class="transition-all text-slate-500 hover:text-[#AA0927]">
                  Request Priority
                </li>
              </RouterLink>
            </ul>
          </div>
          <RouterLink class-active="active" :to="`/admin/delivery`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Delivery" class="text-slate-500 hover:text-[#AA0927]"></i>
              </span>
              <span>Book Delivery Service</span>
            </li>
          </RouterLink>
          <RouterLink class-active="active" :to="`/admin/bookings`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Booking" class="text-slate-500 hover:text-[#AA0927]"></i>
              </span>
              <span>Booking History</span>
            </li>
          </RouterLink>
          <RouterLink class-active="active" :to="`/admin/reports`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Report" class="text-slate-500 hover:text-[#AA0927]"></i>
              </span>
              <span>Requests</span>
            </li>
          </RouterLink>
        </ul>
      </div>
      <div class="mx-2">
        <button @click="logout"
          class="text-center w-full text-white flex justify-center p-2 bg-[#AA0927] hover:bg-slate-100 hover:text-[#AA0927] rounded-md">
          Logout
        </button>
      </div>
    </div>

    <!-- <div id="admin" v-if="userStatus == 1" class="flex flex-col justify-between h-full pb-2">
      <div>
        <p class="mx-6 my-6 text-sm font-bold uppercase text-slate-500">
          Management
        </p>
        <ul
          class="flex flex-col w-full gap-1 text-base font-bold text-white lg:flex-wrap lg:justify-center lg md:block md:overflow-hidden">
          <RouterLink :to="`/admin/dashboard`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Home" class="text-slate-500 hover:text-[#AA0927]"></i>
              </span>
              <span>Dashboard</span>
            </li>
          </RouterLink>
          <RouterLink :to="`/admin/account`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Gear" class="text-slate-500"></i>
              </span>
              <span>Account Management</span>
            </li>
          </RouterLink>
          <div>
            <button @click="dropDown('user')"
              class="flex items-center w-[88%] p-3 transition-all rounded mx-5 hover:bg-white hover:text-[#AA0927] active:text-[#AA0927] lg:w-[95%]">
              <li class="flex justify-between w-full">
                <span class="flex items-center">
                  <span class="flex justify-center mr-2">
                    <i v-html="icons.User" class="text-slate-500 hover:text-[#AA0927]"></i>
                  </span>
                  <span>Users Management </span>
                </span>
                <span class="flex justify-center fill-cyan-500 hover:fill-cyan-700">
                  <i v-if="isDropdownOpenUser === false" v-html="icons.DownTriangle"></i>
                  <i v-else v-html="icons.UpTriangle"></i>
                </span>
              </li>
            </button>
            <ul id="user" class="hidden transition-all">
              <RouterLink class-active="active" :to="`/admin/manage/company`">
                <li class="transition-all text-slate-500 hover:text-[#AA0927]">
                  Companies
                </li>
              </RouterLink>
              <RouterLink class-active="active" :to="`/admin/manage/customer`">
                <li class="transition-all text-slate-500 hover:text-[#AA0927]">
                  Customers
                </li>
              </RouterLink>
              <RouterLink class-active="active" :to="`/admin/manage/riders`">
                <li class="transition-all text-slate-500 hover:text-[#AA0927]">
                  Delivery Riders
                </li>
              </RouterLink>
            </ul>
          </div>
          <div class="">
            <button @click="dropDown('custom')"
              class="flex items-center w-[88%] p-3 transition-all rounded mx-5 hover:bg-white hover:text-[#AA0927] lg:w-[95%]">
              <li class="flex justify-between w-full">
                <span class="flex items-center">
                  <span class="flex justify-center mr-2">
                    <i v-html="icons.Custom" class="text-slate-500 hover:text-[#AA0927]"></i>
                  </span>
                  <span>Customization </span>
                </span>
                <span class="flex flex-col justify-center">
                  <i v-if="isDropdownOpenCustom === false" v-html="icons.DownTriangle"></i>
                  <i v-else v-html="icons.UpTriangle"></i>
                </span>
              </li>
            </button>
            <ul id="customize" class="hidden">
              <RouterLink class-active="active" :to="`/admin/customization/taxonomies`">
                <li class="transition-all text-slate-500 hover:text-[#AA0927]">
                  Taxonomies
                </li>
              </RouterLink>
              <RouterLink class-active="active" :to="`/admin/customization/fees`">
                <li class="transition-all text-slate-500 hover:text-[#AA0927]">
                  Fees
                </li>
              </RouterLink>
              <RouterLink class-active="active" :to="`/admin/customization/requestpriority`">
                <li class="transition-all text-slate-500 hover:text-[#AA0927]">
                  Request Priority
                </li>
              </RouterLink>
            </ul>
          </div>
          <RouterLink class-active="active" :to="`/admin/delivery`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Delivery" class="text-slate-500 hover:text-[#AA0927]"></i>
              </span>
              <span>Book Delivery Service</span>
            </li>
          </RouterLink>
          <RouterLink class-active="active" :to="`/admin/reports/request`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Booking" class="text-slate-500 hover:text-[#AA0927]"></i>
              </span>
              <span>Booking History</span>
            </li>
          </RouterLink>
        </ul>
      </div>
      <div class="mx-2">
        <button @click="logout"
          class="text-center w-full text-white flex justify-center p-2 bg-[#AA0927] hover:bg-slate-100 hover:text-[#AA0927] rounded-md">
          Logout
        </button>
      </div>
    </div> -->

    <div id="company" v-if="userStatus == 2" class="flex flex-col justify-between h-full pb-2">
      <div>
        <p class="mx-6 my-6 text-sm font-bold uppercase text-slate-500">
          Management
        </p>
        <ul
          class="flex flex-col w-full gap-1 text-base font-bold text-white lg:flex-wrap lg:justify-center lg md:block md:overflow-hidden">
          <RouterLink class-active="active" :to="`/company/dashboard/${userId}`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex items-center mr-2">
                <i v-html="icons.Home" class="text-slate-500"></i>
              </span>
              <span>Dashboard</span>
            </li>
          </RouterLink>
          <RouterLink class-active="active" :to="`/company/account/${userId}`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex items-center mr-2">
                <i v-html="icons.Gear" class="text-slate-500"></i>
              </span>
              <span>Account Management</span>
            </li>
          </RouterLink>
          <RouterLink class-active="active" :to="`/company/manage/employees/${userId}`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex items-center mr-2">
                <i v-html="icons.User" class="text-slate-500"></i>
              </span>
              <span>Employees Management</span>
            </li>
          </RouterLink>
          <RouterLink class-active="active" :to="`/company/delivery/${userId}`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex items-center mr-2">
                <i v-html="icons.Delivery" class="text-slate-500"></i>
              </span>
              <span>Book Delivery Service</span>
            </li>
          </RouterLink>
          <RouterLink class-active="active" :to="`/company/reports/request/${userId}`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex items-center mr-2">
                <i v-html="icons.Booking" class="text-slate-500"></i>
              </span>
              <span>Booking History</span>
            </li>
          </RouterLink>
        </ul>
      </div>
      <div class="mx-2">
        <button @click="logout"
          class="text-center w-full text-white flex justify-center p-2 bg-[#AA0927] hover:bg-slate-100 hover:text-[#AA0927] rounded-md">
          Logout
        </button>
      </div>
    </div>

    <div id="customer" v-if="userStatus == 3" class="flex flex-col justify-between h-full pb-2">
      <div>
        <p class="mx-6 my-6 text-sm font-bold uppercase text-slate-500">
          Management
        </p>
        <ul
          class="flex flex-col w-full gap-1 text-base font-bold text-white lg:flex-wrap lg:justify-center lg md:block md:overflow-hidden">
          <RouterLink :to="`/customer/dashboard`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Home" class="text-slate-500 hover:text-[#AA0927]"></i>
              </span>
              <span>Dashboard</span>
            </li>
          </RouterLink>
          <RouterLink :to="`/customer/account`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Gear" class="text-slate-500"></i>
              </span>
              <span>Account Management</span>
            </li>
          </RouterLink>
          <RouterLink :to="`/customer/delivery`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Delivery" class="text-slate-500 hover:text-[#AA0927]"></i>
              </span>
              <span>Book Delivery Service</span>
            </li>
          </RouterLink>
          <RouterLink :to="`/customer/history`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Booking" class="text-slate-500 hover:text-[#AA0927]"></i>
              </span>
              <span>Booking History</span>
            </li>
          </RouterLink>
        </ul>
      </div>
      <div class="mx-2">
        <button @click="logout"
          class="text-center w-full text-white flex justify-center p-2 bg-[#AA0927] hover:bg-slate-100 hover:text-[#AA0927] rounded-md">
          Logout
        </button>
      </div>
    </div>

    <div id="rider" v-if="userStatus == 4" class="flex flex-col justify-between h-full pb-2">
      <div>
        <p class="mx-6 my-6 text-sm font-bold uppercase text-slate-500">
          Management
        </p>
        <ul
          class="flex flex-col w-full gap-1 text-base font-bold text-white lg:flex-wrap lg:justify-center lg md:block md:overflow-hidden">
          <RouterLink class-active="active" :to="`/rider/dashboard`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex items-center mr-2">
                <i v-html="icons.Home" class="text-slate-500"></i>
              </span>
              <span>Dashboard</span>
            </li>
          </RouterLink>
          <RouterLink class-active="active" :to="`/rider/account`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex items-center mr-2">
                <i v-html="icons.Gear" class="text-slate-500"></i>
              </span>
              <span>Account Management</span>
            </li>
          </RouterLink>
          <RouterLink class-active="active" :to="`/rider/requests`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Delivery" class="text-slate-500 hover:text-[#AA0927]"></i>
              </span>
              <span>Requests Management</span>
            </li>
          </RouterLink>
          <RouterLink class-active="active" :to="`/rider/tasks`">
            <li
              class="flex items-center p-3 mx-5 transition-all rounded justify-left hover:bg-white hover:text-[#AA0927]">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Booking" class="text-slate-500 hover:text-[#AA0927]"></i>
              </span>
              <span>Tasks History</span>
            </li>
          </RouterLink>
        </ul>
      </div>
      <div class="mx-2">
        <button @click="logout"
          class="text-center w-full text-white flex justify-center p-2 bg-[#AA0927] hover:bg-slate-100 hover:text-[#AA0927] rounded-md">
          Logout
        </button>
      </div>
    </div>

    <div id="companyUser" v-if="userStatus == 5" class="flex flex-col justify-between h-full pb-2">
      <div>
        <p class="mx-6 my-6 text-sm font-bold uppercase text-slate-500">
          Management
        </p>
        <ul
          class="flex flex-col w-full gap-1 text-base font-bold text-white lg:flex-wrap lg:justify-center lg md:block md:overflow-hidden">
          <RouterLink class-active="active" :to="`/company/user/dashboard/${userId}`">
            <li class="mx-5 transition-all hover:scale-95">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Home" class="text-slate-500 hover:text-[#AA0927]"></i>
              </span>
              <span>Dashboard </span>
            </li>
          </RouterLink>
          <RouterLink class-active="active" :to="`/rider/account/${userId}`">
            <li class="mx-5 transition-all hover:scale-95">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Gear" class="text-slate-500 hover:text-[#AA0927]"></i>
              </span>
              <span>Employee Management </span>
            </li>
          </RouterLink>
          <RouterLink class-active="active" :to="`/rider/delivery/${userId}`">
            <li class="mx-5 transition-all hover:scale-95">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Delivery" class="text-slate-500 hover:text-[#AA0927]"></i>
              </span>
              <span>Book Delivery Service </span>
            </li>
          </RouterLink>
          <RouterLink class-active="active" :to="`/rider/reports/request/${userId}`">
            <li class="mx-5 transition-all hover:scale-95">
              <span class="flex justify-center mr-2">
                <i v-html="icons.Booking" class="text-slate-500 hover:text-[#AA0927]"></i>
              </span>
              <span>Booking History </span>
            </li>
          </RouterLink>
        </ul>
      </div>
      <div class="mx-2">
        <button @click="logout"
          class="text-center w-full text-white flex justify-center p-2 bg-[#AA0927] hover:bg-slate-100 hover:text-[#AA0927] rounded-md">
          Logout
        </button>
      </div>
    </div>
  </nav>
</template>

<script setup>
//Imports
import { RouterLink, useRouter } from "vue-router";
import icons from "../assets/icons.js";
import { ref, onMounted } from "vue";
import { retrieveData } from "@/services/ApiServices.js";

//Variables
let userStatus = ref("");
let userId = ref("");
let cond = ref(false);
let cust = ref(false);
let isDropdownOpenUser = ref(false);
let isDropdownOpenCustom = ref(false);
let props = defineProps({
  navBar: false,
});

const router = useRouter();

//Functions
function dropDown(prop) {
  if (prop == "user") {
    document.getElementById("user").classList.toggle("block");
    isDropdownOpenUser.value = !isDropdownOpenUser.value;
  } else if (prop == "custom") {
    document.getElementById("customize").classList.toggle("block");
    isDropdownOpenCustom.value = !isDropdownOpenCustom.value;
  }
}

//Logout
const logout = () => {
  if (localStorage.getItem("token")) {
    localStorage.removeItem("token");
    router.push("/login");
  } else {
    localStorage.removeItem("token");
    router.push("/login");
  }
};

//OnMounted
onMounted(() => {
  try {
    const promise = retrieveData();
    promise
      .then((data) => {
        if (data.data.UserAccess !== undefined) {
          const status = data.data.UserAccess;
          // const usersId = data.data.UserID;
          const usersId = btoa(data.data.UserID);
          userStatus.value = status;
          userId.value = usersId;
        } else if (data.data.UserAccess == undefined) {
          const adminstatus = data.data.data.UserAccess;
          // const adminusersId = data.data.data.UserID;
          const adminusersId = btoa(data.data.data.UserID);
          userStatus.value = adminstatus;
          userId.value = adminusersId;
        }
      })
      .catch((error) => {
        console.error("Error fetching data:", error);
        router.push("/login");
      });
  } catch (error) {
    console.error("Error:", error);
  }
});
</script>

<style lang="scss" scoped>
* {
  //border: 1px solid red;
}

// Styles
.block {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  padding-top: 0.75rem;
  margin: 0 4.1rem;

  //transition
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}

#user>.router-link-active>li,
#customize>.router-link-active>li {
  color: #aa0927;
}

i svg#triangle:hover {
  fill: #ff0000;
}
</style>
