<template>
  <SRHeader />
  <div class="flex w-full wrapper">
    <SRNavbar />
    <div id="Content" class="block w-full px-16">
      <div id="Content-Header" class="flex w-full py-10 [&>h2]:text-3xl [&>h2]:text-[#AA0927] [&>h2]:font-extrabold">
        <h2>Dashboard</h2>
      </div>
      <div id="Content-Body" class="flex items-start w-full">
        <div id="left" class="flex flex-wrap w-full">
          <div id="feedbacks"
            class="flex justify-between w-full px-5 pt-5 pb-10 [&>h2]:text-2xl [&>h2]:font-bold [&>span]:text-xl [&>span]:text-[#AA0927] border-2 rounded-2xl">
            <h2>Latest Feedbacks</h2>
            <span><a href="">View All</a></span>
          </div>
          <div id="task-report" class="flex px-5 pt-5 h-full [&>h2]:text-2xl [&>h2]:font-bold">
            <h2>Task Report</h2>
          </div>
        </div>
        <div id="right" class="flex items-start w-full px-5 pt-5 pb-8"></div>
      </div>
    </div>
  </div>
  <SRFooter />
</template>

<script setup>
import SRFooter from "@/layouts/SRFooter.vue";
import SRHeader from "@/layouts/SRHeader.vue";
import SRNavbar from "@/layouts/SRNavbar.vue";
</script>

<style scoped></style>