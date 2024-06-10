<template>
  <div class="flex items-center justify-between w-full px-4">
    <div id="left"
      class="flex gap-x-3 [&>div>label]:text-base sm:[&>div>label]:text-sm [&>div>label]:flex [&>div>label]:justify-center [&>div>label]:items-center [&>div]:my-5 sm:justify-between sm:w-full [&>div>select]:text-base sm:[&>div>select]:text-xs sm:gap-x-1 px-3 rounded-lg">
      <div class="flex flex-row items-center justify-center gap-3 sm:items-start sm:flex-col">
        <label for="Results" class="text-black">Show Results:</label>
        <select name="" id="Results" class="p-2">
          <option value="">10</option>
          <option value="">50</option>
          <option value="">100</option>
        </select>
      </div>
      <div class="flex flex-row items-center justify-center gap-3 sm:items-start sm:flex-col">
        <label for="OrderBy" class="text-black">Order by:</label><select name="" id="OrderBy" class="p-2">
          <option value="">ID</option>
          <option value="">Name</option>
        </select>
      </div>
      <div class="flex flex-row items-center justify-center gap-3 sm:items-start sm:flex-col">
        <select name="" id="" class="p-2">
          <option value="">Ascending</option>
          <option value="">Descending</option>
        </select>
      </div>
      <div class="flex flex-row items-center justify-center gap-3 sm:items-start sm:flex-col">
        <button class="px-2 h-full rounded-md text-sm bg-[#AA0927] text-white font-light hover:bg-rose-600">
          Export Table
        </button>
      </div>
    </div>
    <div id="right" class="flex justify-center items-center [&>button]:w-12 gap-x-2 mx-2 lg:[&>button]:w-8">
      <button class="hover:scale-105" v-show="props.AddStatus == true">
        <i v-html="icons.AddBtn"></i>
      </button>
      <button class="hover:scale-105"><i v-html="icons.Search"></i></button>
    </div>
  </div>
</template>

<script setup>
import icons from "@/assets/icons.js";

let props = defineProps({
  AddStatus: Boolean,
});
</script>

<style lang="scss" scoped></style>
