<template>
    <div class="main">
        <div class="image"
            :style="{ 'background-image': image === null || image === '' || image === undefined ? `url(${userNotFound})` : `url(${image})` }">
            <div class="edit" v-if="isEditModeOn === true">
                <label for="file-upload" class="custom-file-upload">
                    <i v-html="icons.Pen"></i>
                </label>
                <input id="file-upload" type="file" @change="handleFileChange"
                    accept="image/png, image/gif, image/jpeg">
            </div>
        </div>
    </div>
</template>


<script setup>
// Imports
import icons from '@/assets/icons.js';
import { ref } from 'vue';
import { uploadProfilePicture } from '@/services/api/company.js';

// Variables
const userNotFound = ref("/admin-delivery/src/assets/user.svg");
const props = defineProps(['image', 'isEditModeOn']);
const photos = ref(null);
// console.log(props['image']);


// Function to handle file change
const handleFileChange = (event) => {
    if (event && event.target && event.target.files) {
        const selectedFile = event.target.files[0];
        photos.value = selectedFile;
    } else {
        console.error("Event object is undefined or missing necessary properties.");
    }

    console.log("Photos: ", photos.value);
    // Set profile picture
    setProfilePictures(photos.value);

};

// Function to set profile picture
function setProfilePictures(photos) {
    uploadProfilePicture(photos).then(() => {
        window.location.reload();
    });
}
</script>

<style lang="scss" scoped>
input[type="file"] {
    display: none;
}

.custom-file-upload {
    border: 10px solid #AA0927;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    height: 35px;
    width: 35px;
    border-radius: 50%;
    background-color: #AA0927;
}

.image {
    width: 140px;
    height: 140px;
    display: flex;
    justify-content: flex-end;
    align-items: last baseline;
    border: 4px solid #AA0927;
    border-radius: 50%;
    background-size: auto 140px;
    background-repeat: no-repeat;
    background-position: center;
}

.edit {
    width: min-content;
}
</style>