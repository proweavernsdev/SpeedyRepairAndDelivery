<template>
    <div @click="HandleOverlayClick" id="modal"
        class="flex fixed justify-center items-center inset-0 bg-black bg-opacity-75 z-50 SignUpModal">
        <div class="flex w-full">
            <div id="otp-page" class="flex items-center justify-center flex-col h-screen gap-5 bg-[#550514] w-full">
                <slot name="Icon"></slot>
                <slot name="Description"></slot>
                <slot name="Form"></slot>
                <slot name="Footer"></slot>
            </div>
        </div>
    </div>
</template>
script
<script setup>

let emit = defineEmits(['close'])
const HandleOverlayClick = (event) => {
    if (event.target.classList.contains('This-Modal')) {
        emit('close')
    }
}
</script>
<style scoped>
* {}
</style>