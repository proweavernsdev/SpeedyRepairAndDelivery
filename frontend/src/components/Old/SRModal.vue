<template>
  <div @click="HandleOverlayClick" id="modal" class="fixed inset-0 bg-black bg-opacity-75">
    <div class="flex items-center justify-center w-full h-full This-Modal">
      <!-- Modal Content -->
      <div id="modal-content" class="w-[570px] h-auto bg-white">
        <div v-show="props.StatusCreate == true ||
          props.StatusView == true ||
          props.StatusUpdate == true ||
          props.StatusDelete == true ||
          props.StatusSearch == true
          " id="modal-header" class="flex justify-between px-5 py-5 bg-[#AA0927] text-white text-3xl font-semibold">
          <h2 v-show="props.StatusCreate == true">Create Company</h2>
          <h2 v-show="props.StatusView == true">View Company</h2>
          <h2 v-show="props.StatusUpdate == true">Edit Company</h2>
          <h2 v-show="props.StatusDelete == true">Delete Company</h2>
          <h2 v-show="props.StatusSearch == true">Search Company</h2>
          <span><button @click="emit('close', false)" class="w-6">
              <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <line x1="10" y1="10" x2="90" y2="90" stroke="currentColor" stroke-width="5" />
                <line x1="90" y1="10" x2="10" y2="90" stroke="currentColor" stroke-width="5" />
              </svg>
            </button>
          </span>
        </div>
        <div id="modal-body" class="px-6 mb-5">
          <div v-show="props.StatusCreate == true" id="create">
            <form
              class="grid grid-cols-2 mt-16 gap-y-3 [&>label]:col-start-1 [&>input]:col-start-2 text-xl font-normal [&>input[type=text]]:border-2"
              @submit.prevent="dashboardCompany(docs)">
              <label for="">Company Name: </label><input type="text"
                class="focus:border-gray-400 focus:outline-none" /><br />
              <label for="">Email: </label><input type=" text" class="focus:border-gray-400 focus:outline-none" /><br />
              <label for="">Password:</label><input type="text"
                class="focus:border-gray-400 focus:outline-none" /><br />
              <label for="">Address:</label><input type="text" class="focus:border-gray-400 focus:outline-none" /><br />
              <label for="">Upload Documents:</label><input id="docs" type="file" @change="handleFileChange" />
            </form>
          </div>
          <div v-show="props.StatusView == true" id="view">
            <div id="modal-body-header" class="flex justify-center">
              <SRProfile />
            </div>
            <div id="modal-body-conent"
              class="grid grid-cols-2 mt-16 gap-y-3 [&>label]:col-start-1 [&>h2]:col-start-2 text-xl font-normal [&>h2]:text-[#AA0927]">
              <label for="">Company Name: </label>
              <h2>TechNova Sollutions</h2>
              <br />
              <label for="">Email: </label>
              <h2>dummy@email.com</h2>
              <br />
              <label for="">Password:</label>
              <h2>password123</h2>
              <br />
              <label for="">Address:</label>
              <h2>123 StreetAnytown, CA 90210</h2>
            </div>
          </div>
          <div v-show="props.StatusUpdate == true">
            <div id="modal-body-header" class="flex justify-center">
              <SRProfile />
            </div>
            <div
              class="grid grid-cols-2 mt-16 gap-y-3 [&>label]:col-start-1 [&>input]:col-start-2 text-xl font-normal [&>input[type=text]]:border-2">
              <label for="">Company Name: </label><input type="text"
                class="focus:border-gray-400 focus:outline-none" /><br />
              <label for="">Email: </label><input type="text" class="focus:border-gray-400 focus:outline-none" /><br />
              <label for="">Password:</label><input type="text"
                class="focus:border-gray-400 focus:outline-none" /><br />
              <label for="">Address:</label><input type="text" class="focus:border-gray-400 focus:outline-none" /><br />
              <label for="">Upload Documents:</label><input type="file" name="" id=""
                class="focus:border-gray-400 focus:outline-none" />
            </div>
          </div>
          <div v-show="props.StatusDelete == true" id="delete" class="pt-5 text-3xl font-bold text-center">
            <h2>Are you sure you want to delete?</h2>
          </div>
          <div v-show="props.StatusSearch == true" id="searcg" class="pt-5 text-3xl font-bold text-center">
            <input type="text" class="focus:border-gray-400" /><br />
          </div>
        </div>
        <div id="modal-footer" class="flex justify-end px-6 py-6 border-t-2">
          <div v-show="props.StatusCreate">
            <button class="w-[223px] h-[64px] rounded-2xl bg-[####09aa3ccccccccc] text-3xl text-white font-bold">
              Create
            </button>
          </div>
          <div v-show="props.StatusView">
            <button class="w-[223px] h-[64px] rounded-2xl bg-[#aa0927] text-3xl text-white font-bold">
              Close
            </button>
          </div>
          <div v-show="props.StatusUpdate">
            <button class="w-[223px] h-[64px] rounded-2xl bg-[#09aa3c] text-3xl text-white font-bold">
              Update
            </button>
          </div>
          <div v-show="props.StatusDelete">
            <button class="w-[223px] h-[64px] rounded-2xl bg-[#aa0927] text-3xl text-white font-bold">
              Delete
            </button>
          </div>
          <div v-show="props.StatusSearch">
            <button class="w-[223px] h-[64px] rounded-2xl bg-[#09aa3c] text-3xl text-white font-bold">
              Search
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import SRProfile from "@/components/SRProfile.vue";

let props = defineProps({
  StatusCreate: Boolean,
  StatusView: Boolean,
  StatusUpdate: Boolean,
  StatusDelete: Boolean,
  StatusSearch: Boolean,
});
let emit = defineEmits(["close"]);
const HandleOverlayClick = (event) => {
  if (event.target.classList.contains("This-Modal")) {
    emit("close", false);
  }
};

let pwAuth = localStorage.getItem("token");

const updateToken = () => {
  pwAuth = localStorage.getItem("token");
  console.log(pwAuth);
};

const docs = ref(null);
const handleFileChange = (event) => {
  docs.value = event.target.files;
  console.log(docs.value);
};

function dashboardCompany(docs) {
  updateToken();
  createCompany(docs).then(() => {
    router.push("/login?success=true");
  });
}
</script>

<style lang="scss" scoped></style>