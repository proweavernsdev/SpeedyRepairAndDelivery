<template>
  <div
    id="Content-Header"
    class="w-full py-5 pb-5 text-[#AA0927] text-3xl font-extrabold lg:py-7 sm:text-2xl sm:py-4 overflow-y-scroll no-scrollbar"
  >
    <slot name="Content-Header" />
  </div>
  <slot name="Content-Body" />
</template>

<script setup></script>

<style lang="scss" scoped></style>
