<script setup>
import { ref, reactive } from 'vue';
import axiosR from 'axios';

const changeDP = ref(false);
const uploadProgress = ref(0); // Track upload progress
const showProgressBar = ref(false); // Show or hide progress bar
const emits = defineEmits(['close', 'fileChange', 'fullURL']);
const props = defineProps({
    showModal: Boolean
});
const baseUrl = "https://speedyrepairanddelivery.com/api-delivery/";
const fileName = ref("");

const closeModal = () => {
    emits('close');
};

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        fileName.value = file.name;
    }
};

// New method to handle image upload with progress bar
const uploadItemImage = async () => {
    changeDP.value = true;
    const imageFile = document.getElementById("imageUpload").files[0];
    if (!imageFile) {
        console.log('No image selected for upload.');
        changeDP.value = false;
        return;
    }

    const formData = new FormData();
    formData.append('file', imageFile);
    showProgressBar.value = true;

    try {
        const response = await axiosR.post(baseUrl + 'BookService/uploadImg', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
            onUploadProgress: (progressEvent) => {
                uploadProgress.value = Math.round((progressEvent.loaded * 100) / progressEvent.total);
            }
        });

        if (response.data.status === 'success') {
            console.log('Video uploaded successfully!');
            emits('fullURL', response.data.file_path);
            const filePathArray = response.data.file_path.split('/');
            const fileName = filePathArray[filePathArray.length - 1];
            emits('fileChange', fileName);
        } else {
            console.log(`Upload failed: ${response.data.message}`);
        }
    } catch (error) {
        console.error('Error uploading image', error);
        console.log('An error occurred while uploading the image.');
    } finally {
        changeDP.value = false;
        fileName.value = "";
        showProgressBar.value = false;
        uploadProgress.value = 0;
    }
    emits('close');
};
</script>

<template>
    <div class="fixed inset-0 flex items-center justify-center z-50">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md z-10">
            <div class="flex flex-col space-y-4">
                <h2 class="text-xl font-bold text-gray-800">Upload Image</h2>
                <div>
                    <label for="imageUpload" class="block text-sm font-medium text-gray-700">Select Image File</label>
                    <div class="mt-1 relative">
                        <input id="imageUpload" type="file" accept="image/*" class="hidden" @change="handleFileChange">
                        <label for="imageUpload" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Select Image
                        </label>
                        <span v-if="fileName" class="ml-4 text-gray-500">{{ fileName }}</span>
                    </div>
                </div>
                <div class="flex justify-end space-x-4">
                    <button @click="closeModal" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Cancel
                    </button>
                    <button :disabled="changeDP" @click="uploadItemImage" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Save and Upload
                    </button>
                </div>
                <div class = "w-full" v-if="showProgressBar">
                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200">
                                    Upload Progress
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-semibold inline-block text-blue-600">
                                    {{ uploadProgress }}%
                                </span>
                            </div>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
                            <div :style="{ width: uploadProgress + '%' }" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<style scoped>
/* Add any additional styling if needed */
</style>