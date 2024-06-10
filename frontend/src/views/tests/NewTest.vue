<template>
  <div class="w-full h-[89.2vh]">
    <div class="py-[50px] bg-red-600"></div>
    <div class="flex w-full h-full">
      <nav
        id="navbar"
        class="w-[400px] h-full bg-green-500 p-10 text-2xl font-bold text-white"
      >
        <ul>
          <li @click="toggleDropdown" id="subs">This is menu 0</li>
          <transition name="fade">
            <div v-if="isDropdownOpen" class="text-right h-auto">
              <ul>
                <li>This is sub-menu 1</li>
                <li>This is sub-menu 2</li>
              </ul>
            </div>
          </transition>
          <li>This is menu 1</li>
          <li>This is menu 2</li>
          <li>This is menu 3</li>
        </ul>
      </nav>
      <div id="content" class="w-full h-full bg-blue-500">
        <div id="content-header">
          <h2>Account</h2>
        </div>
        <div
          id="content-body"
          class="flex flex-wrap px-16 [&>h1]:p-32 [&>h1]:bg-white gap-3"
        >
          <h1>test1</h1>
          <h1>test2</h1>
          <h1>test3</h1>
          <h1>test4</h1>
          <h1>test5</h1>
          <h1>test6</h1>
          <h1>test7</h1>
          <h1>test8</h1>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

const isDropdownOpen = ref(false);

function toggleDropdown() {
  isDropdownOpen.value = !isDropdownOpen.value;
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
