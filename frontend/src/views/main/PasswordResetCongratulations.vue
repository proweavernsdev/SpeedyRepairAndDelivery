<template>
    <div id="error" class="flex items-center justify-center flex-col h-screen gap-5 bg-[#550514]">
        <i v-html="icons.PassEmail"></i>
        <h1 class="text-3xl font-bold text-white">Password Changed!</h1>
        <p class="text-base text-white">Your password has been changed successfully.</p>
        <router-link to="/login">
            <button class="w-64 h-10 bg-white rounded hover:bg-[#D9D9D9] ">
                Back to Login
            </button>
        </router-link>
    </div>

</template>
<script>
</script>
<style lang="scss" scoped>
* {}
</style>