<template>
    <header>
        <div
            class="fixed flex flex-row justify-between w-full h-16 py-[14px] z-10 bg-[#AA0927] md:py-5 sm:py-2 lg:z-50">
            <div class="flex items-center justify-start gap-5 mx-5 md:invisible lg:ml-16">
                <h1 class="text-3xl text-white"><span>Speedy</span></h1>
            </div>
            <div class="flex items-center">
                <button @click="emits('navOpen')" class="right-0 hidden w-10 mx-5 text-white md:mx-2 lg:block">
                    <span v-html="icons.Hamburger" class="md:size-2"></span>
                </button>
            </div>
        </div>
    </header>
</template>

<script setup>
import icons from '@/assets/icons.js'
import { useRouter } from 'vue-router';

let emits = defineEmits(['navOpen']);
const router = useRouter();

const logout = () => {
    localStorage.removeItem("token");
    router.push('/login');
};

</script>

<style lang="scss" scoped>
* {
    //border: 1px solid pink;
}
</style>