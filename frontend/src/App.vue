<template>
  <SRHeader @navOpen="navOpen = !navOpen" v-if="!outsidePaths.includes(route.path)" />
  <div class="flex w-full scroll-smooth lg:block lg:relative md:flex md:justify-end"
    v-if="!outsidePaths.includes(route.path)">
    <SRNavbar :navBar="navOpen" />
    <div id="Content"
      class="block w-full h-screen pt-16 ml-[277.5px] pl-16 pr-9 py-5 lg:ml-0 md:px-4 sm:px-4 overflow-scroll bg-[#F7F7F7]">
      <RouterView />
    </div>
  </div>
  <RouterView v-else />
</template>

<script setup>
import SRFooter from "@/layouts/SRFooter.vue";
import SRHeader from "@/layouts/SRHeader.vue";
import SRNavbar from "@/layouts/SRNavbar.vue";

import { RouterView, useRoute } from "vue-router";
import { ref } from "vue";

let navOpen = ref(false);
const route = useRoute();
const outsidePaths = ref([
  "/login",
  "/signup",
  "/reset",
  "/change-password",
  "/password-reset-success",
  "/access-level",
  "/otp",
  "/load",
  `/:pathMatch(.*)*`,
  "/",
]);
</script>

<style lang="scss" scoped>
* {
  @apply scroll-smooth;
}
</style>
