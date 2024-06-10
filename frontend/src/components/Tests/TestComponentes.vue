<template>
  <table
    class="w-full table-fixed [&>th:first-child]:border-x-0 [&>th]:border-x-2 [&>th:last-child]:border-x-0 [&>th]:border-b-2 [&>td]:border-x-2 md:table-auto"
  >
    <thead class="text-4xl-xl [&>th]:py-6 [&>th:nth-child(1)]:w-[8.5%]">
      <slot name="Table-Header" />
    </thead>

    <tbody
      class="[&>td]:py-5 text-2xl-lg [&>td]:text-center [&>td]:font-light [&>tr:nth-child(even)]:bg-[#D9D9D9]"
    >
      <slot name="Table-Body" />
    </tbody>
  </table>
</template>

<script setup>
</script>

<style lang="scss" scoped>
</style>