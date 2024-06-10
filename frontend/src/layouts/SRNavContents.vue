<template>
  <div
    id="Content-Header"
    class="[&>h2]:text-[#AA0927] text-3xl font-extrabold"
  >
    <slot name="Content-Header" />
  </div>
  <slot name="Content-Body" />
</template>

<script setup>
</script>

<style lang="scss" scoped></style>