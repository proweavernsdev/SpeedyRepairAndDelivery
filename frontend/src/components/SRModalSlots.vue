<template>
    <div @click="HandleOverlayClick" id="modal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 This-Modal">
        <!-- Modal Content -->
        <div id="modal-content" class="max-w-[750px] w-full h-auto bg-white m-2">
            <div id="modal-header" class="rounded-t-lg ">
                <slot name="Modal-Header" />
            </div>

            <div id="modal-body" class="mt-5 shadow">
                <slot name="Modal-Body" />
            </div>

            <div id="modal-footer">
                <slot name="Modal-Footer" />
            </div>

        </div>
    </div>
</template>

<script setup>

let emit = defineEmits(['close'])
const HandleOverlayClick = (event) => {
    if (event.target.classList.contains('This-Modal')) {
        emit('close')
    }
}

</script>

<style lang="scss" scoped></style>