<template>
  <nav
    class="max-w-[400px] w-full h-screen bg-[#0E0E0E] pt-8 pl-10 hover:scale-125"
  >
    <ul
      class="w-full text-white text-2xl [&>span]:font-bold [&>span]:flex [&>li]:mb-6 [&>span]:gap-x-5 [&>i]:w-8"
    >
      <RouterLink to="/dashboard"
        ><a>
          <li>
            <span><i v-html="icons.Home"></i>Dashboard</span>
          </li>
        </a></RouterLink
      >
      <RouterLink to="/manage/account"
        ><a>
          <li>
            <span><i v-html="icons.Gear"></i>Account Management</span>
          </li>
        </a></RouterLink
      >
      <button @click="cond = !cond">
        <li>
          <span
            ><i v-html="icons.User"></i>Users Management
            <i v-html="icons.DownTriangle" class="w-9"></i
          ></span>
        </li>
      </button>
      <ul
        class="overflow-hidden px-16 text-right font-bold [&>li:first-child]:mt-0 transition-all ease-in-out duration-[300ms]"
        :class="{
          'h-0': !cond,
          'h-auto': cond,
        }"
      >
        <RouterLink to="/manage/company"
          ><a>
            <li>Companies</li>
          </a></RouterLink
        >
        <RouterLink to="/manage/customer"
          ><a>
            <li>Customers</li>
          </a></RouterLink
        >
        <RouterLink to="/manage/riders"
          ><a>
            <li>Delivery Riders</li>
          </a></RouterLink
        >
      </ul>
      <RouterLink to="/delivery"
        ><a>
          <li>
            <span><i v-html="icons.Delivery"></i>Book Delivery Service</span>
          </li>
        </a></RouterLink
      >
      <RouterLink to="/reports/request"
        ><a>
          <li>
            <span><i v-html="icons.Booking"></i>Booking History</span>
          </li>
        </a></RouterLink
      >
    </ul>
  </nav>
</template>

<script setup>
import { ref } from "vue";
import { RouterLink } from "vue-router";
import icons from "../assets/icons.js";

let cond = ref(false);
</script>

<style lang="scss" scoped></style>