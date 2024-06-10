<template>
    <table class="w-full bg-white table-fixed rounded-xl">
        <thead class="text-xl *:bg-[#AA0927] *:text-white *:p-6 ">
            <slot name="Table-Header" />
        </thead>
        <tbody class="[&>td]:border-2 [&>td]:p-4 [&>td]:text-base text-center text-black border-2 child:p-3 ">
            <slot name="Table-Body" />
        </tbody>
    </table>

</template>

<script setup>

</script>

<style lang="scss" scoped></style>