<template>
  <SRModalSlots v-show="isOpen == true" @close="isOpen = false">
    <template #Modal-Header>
      <div class="flex justify-between px-5 py-5 bg-[#AA0927] text-white text-3xl font-semibold">
        <!-- Buttons for create, update, delete, and search in Taxonomies -->
        <h2 v-show="TaxonomiesCreate == true">Create Taxonomy</h2>
        <!-- Buttons for create, update, delete, and search in Taxonomies Size-->
        <h2 v-show="TaxonomiesSizeCreate == true">Create Size</h2>
        <h2 v-show="TaxonomiesSizeUpdate == true">Update Size</h2>
        <h2 v-show="TaxonomiesSizeDelete == true">Delete Size</h2>
        <!-- Buttons for create, update, and delete in Taxonomies Weight -->
        <h2 v-show="TaxonomiesWeightCreate == true">Create Weight</h2>
        <h2 v-show="TaxonomiesWeightUpdate == true">Update Weight</h2>
        <h2 v-show="TaxonomiesWeightDelete == true">Delete Weight</h2>
        <span><button @click="isOpen = false" class="w-6">
            <svg class="hover:scale-105" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
              <line x1="10" y1="10" x2="90" y2="90" stroke="currentColor" stroke-width="5" />
              <line x1="90" y1="10" x2="10" y2="90" stroke="currentColor" stroke-width="5" />
            </svg>
          </button>
        </span>
      </div>
    </template>
    <template #Modal-Body>
      <div class="mx-6 mb-6">
        <div v-show="TaxonomiesCreate == true" id="create">
          <form class="flex items-center justify-center h-44 [&>label]:text-2xl [&>label]:text-center [&>*]:w-1/2"
            @submit.prevent="createTaxonomy()" id="createTaxonomyForm">
            <label for="">Taxonomy Name: </label>
            <input type="text" v-model="categoryName"
              class="p-2 border-2 rounded focus:ring-1 focus:ring-red-500 focus:border-gray-400 focus:outline-none" />
          </form>
        </div>
        <div v-show="TaxonomiesSizeCreate == true">
          <form @submit.prevent="createSize(sizeCategoryName, sizeMin, sizeMax, sizeSetFee)" id="createSize"
            class="m-2 [&>div>input]:h-12">
            <div class="flex items-center [&>*]:w-1/2 my-2">
              <label for="" class="text-xl text-left">Size Name :</label>
              <input type="text" class="w-1/2 p-2 border rounded focus:border-gray-400 focus:outline-none"
                v-model="sizeCategoryName" required />
            </div>
            <div class="flex items-center [&>*]:w-1/2 my-2">
              <label for="" class="text-xl text-left">Minimum Value :</label>
              <input type="number" min="1" max="999"
                class="w-1/2 p-2 border rounded focus:border-gray-400 focus:outline-none" v-model="sizeMin" required />
            </div>
            <div class="flex items-center [&>*]:w-1/2 my-2">
              <label for="" class="text-xl text-left">Maximum Value :</label>
              <input type="number" min="1" max="999"
                class="w-1/2 p-2 border rounded focus:border-gray-400 focus:outline-none" v-model="sizeMax" required />
            </div>
            <div class="flex items-center [&>*]:w-1/2 my-2">
              <label for="" class="text-xl text-left focus:border-gray-400 focus:outline-none">Set Fee :</label>
              <input type="number" min="1" max="999"
                class="w-1/2 p-2 border rounded focus:border-gray-400 focus:outline-none" v-model="sizeSetFee"
                required />
            </div>
          </form>
        </div>
        <div v-show="TaxonomiesSizeUpdate == true">
          <form @submit.prevent="renewSize(viewSize.SizeCategoryID, sizeCategoryName, sizeMin, sizeMax, sizeSetFee)"
            id="renewSize" class="m-2 [&>div>input]:h-12">
            <div class="flex items-center [&>*]:w-1/2 my-2">
              <label for="" class="text-xl text-left">Size Name: </label>
              <input type="text" class="w-1/2 p-2 border rounded focus:border-gray-400 focus:outline-none"
                :placeholder="viewSize.sc_categoryName" v-model="sizeCategoryName" />
            </div>
            <div class="flex items-center [&>*]:w-1/2 my-2">
              <label for="" class="text-xl text-left">Minimum Value: </label>
              <input type="text" class="w-1/2 p-2 border rounded focus:border-gray-400 focus:outline-none"
                :placeholder="viewSize.sc_minSize" v-model="sizeMin" />
            </div>
            <div class="flex items-center [&>*]:w-1/2 my-2">
              <label for="" class="text-xl text-left">Maximum Value:</label>
              <input type="text" class="w-1/2 p-2 border rounded focus:border-gray-400 focus:outline-none"
                :placeholder="viewSize.sc_minSize" v-model="sizeMax" />
            </div>
            <div class="flex items-center [&>*]:w-1/2 my-2">
              <label for="" class="text-xl text-left">Set Fee:</label>
              <input type="text" class="w-1/2 p-2 border rounded focus:border-gray-400 focus:outline-none"
                :placeholder="viewSize.sc_setFee" v-model="sizeSetFee" />
            </div>
          </form>
        </div>
        <form v-show="TaxonomiesSizeDelete == true" id="removeSize" class="pt-5 text-3xl font-bold text-center"
          @submit.prevent="removeSize(viewSize.SizeCategoryID)">
          <h2>Are you sure you want to delete?</h2>
        </form>

        <div v-show="TaxonomiesWeightCreate == true">
          <form @submit.prevent="createWeight(weightCategoryName, weightMin, weightMax, weightSetFee)" id="createWeight"
            class="m-2 [&>div>input]:h-12">
            <div class="flex items-center [&>*]:w-1/2 my-2">
              <label for="" class="text-xl text-left focus:border-gray-400 focus:outline-none">Weight Name:</label>
              <input type="text" class="w-1/2 p-2 border rounded focus:border-gray-400 focus:outline-none"
                v-model="weightCategoryName" required />
            </div>
            <div class="flex items-center [&>*]:w-1/2 my-2">
              <label for="" class="text-xl text-left">Minimum Value</label>
              <input type="number" min="1" max="999"
                class="w-1/2 p-2 border rounded focus:border-gray-400 focus:outline-none" v-model="weightMin"
                required />
            </div>
            <div class="flex items-center [&>*]:w-1/2 my-2">
              <label for="" class="text-xl text-left">Maximum Value</label>
              <input type="number" min="1" max="999"
                class="w-1/2 p-2 border rounded focus:border-gray-400 focus:outline-none" v-model="weightMax"
                required />
            </div>
            <div class="flex items-center [&>*]:w-1/2 my-2">
              <label for="" class="text-xl text-left">Set Fee</label>
              <input type="number" min="1" max="999"
                class="w-1/2 p-2 border rounded focus:border-gray-400 focus:outline-none" v-model="weightSetFee"
                required />
            </div>
          </form>
        </div>
        <div v-show="TaxonomiesWeightUpdate == true">
          <form
            @submit.prevent="renewWeight(viewWeight.WeightCategoryID, weightCategoryName, weightMin, weightMax, weightSetFee)"
            id="renewWeight" class="m-2 [&>div>input]:h-12">
            <div class="flex items-center [&>*]:w-1/2 my-2">
              <label for="" class="text-xl text-left ">Weight Name :
              </label>
              <input type="text" class="w-1/2 p-2 border rounded focus:border-gray-400 focus:outline-none"
                :placeholder="viewWeight.wc_categoryName" v-model="weightCategoryName" />
            </div>
            <div class="flex items-center [&>*]:w-1/2 my-2">
              <label for="" class="text-xl text-left ">Minimum Value :
              </label>
              <input type="text" class="w-1/2 p-2 border rounded focus:border-gray-400 focus:outline-none"
                :placeholder="viewWeight.wc_minWeight" v-model="weightMin" />
            </div>
            <div class="flex items-center [&>*]:w-1/2 my-2">
              <label for="" class="text-xl text-left ">Maximum Value
                :</label>
              <input type="text" class="w-1/2 p-2 border rounded focus:border-gray-400 focus:outline-none"
                :placeholder="viewWeight.wc_minWeight" v-model="weightMax" />
            </div>
            <div class="flex items-center [&>*]:w-1/2 my-2">
              <label for="" class="text-xl text-left ">Set Fee :</label>
              <input type="text" class="w-1/2 p-2 border rounded focus:border-gray-400 focus:outline-none"
                :placeholder="viewWeight.wc_setFee" v-model="weightSetFee" />
            </div>
          </form>
        </div>
        <form v-show="TaxonomiesWeightDelete == true" id="removeWeight" class="pt-5 text-3xl font-bold text-center"
          @submit.prevent="removeWeight(viewWeight.WeightCategoryID)">
          <h2>Are you sure you want to delete?</h2>
        </form>
      </div>
    </template>
    <template #Modal-Footer>
      <div class="flex justify-end w-full p-5">
        <!-- Buttons for create, update, delete, and search in Taxonomies -->
        <div id="" v-show="TaxonomiesCreate == true">
          <button class="w-64 p-3 text-2xl font-bold text-white bg-[#09aa3c] rounded-xl " type="submit"
            form="createTaxonomyForm">
            Create
          </button>
        </div>

        <!-- Buttons for create, update, and delete in Taxonomies Size -->
        <div v-show="TaxonomiesSizeCreate == true">
          <button class="w-64 p-3 text-2xl font-bold text-white bg-red-700 rounded-xl hover:bg-red-00" type="submit"
            form="createSize">
            Create
          </button>
        </div>
        <div v-show="TaxonomiesSizeUpdate == true">
          <button class="w-64 p-3 text-2xl font-bold text-white bg-[#09aa3c] rounded-xl " type="submit"
            form="renewSize">
            Update
          </button>
        </div>
        <div v-show="TaxonomiesSizeDelete == true">
          <button class="w-64 p-3 text-2xl font-bold text-white bg-[#09aa3c] rounded-xl " type="submit"
            form="removeSize">
            Delete
          </button>
        </div>
        <div v-show="TaxonomiesWeightCreate == true">
          <button class="w-64 p-3 text-2xl font-bold text-white bg-[#09aa3c] rounded-xl " type="submit"
            form="createWeight">
            Create
          </button>
        </div>
        <div v-show="TaxonomiesWeightUpdate == true">
          <button class="w-64 p-3 text-2xl font-bold text-white bg-[#09aa3c] rounded-xl " type="submit"
            form="renewWeight">
            Update
          </button>
        </div>
        <div v-show="TaxonomiesWeightDelete == true">
          <button class="w-64 p-3 text-2xl font-bold text-white bg-[#09aa3c] rounded-xl " type="submit"
            form="removeWeight">
            Delete
          </button>
        </div>
      </div>
    </template>
  </SRModalSlots>
  <SRContents>
    <template #Content-Header>
      <div class="flex justify-between ">
        <h2>Taxonomies</h2>
        <div class="flex gap-x-2">
          <button @click="
            isOpen = true;
          TaxonomiesCreate = true;
          TaxonomiesSizeCreate = false;
          TaxonomiesSizeUpdate = false;
          TaxonomiesSizeDelete = false;
          TaxonomiesWeightCreate = false;
          TaxonomiesWeightUpdate = false;
          TaxonomiesWeightDelete = false;
          " class="w-12 md:w-8 hover:scale-105" v-html="icons.AddBtn"></button>
        </div>
      </div>
    </template>
    <template #Content-Body>
      <div class="flex flex-col">
        <div class="flex justify-between w-auto p-2 m-3 bg-white border-2 rounded-xl">
          <div class="flex justify-between items-center p-2 h-[75px]">
            <p class="text-xl font-bold">Categories</p>
          </div>
          <div class="flex justify-between items-center p-2 h-[75px]">
            <button class="flex items-center justify-between mx-3 h-[75px] border-b-2 px-3 hover:bg-[#FBFBFB]"
              @click="activeTable = 'size'"
              :class="activeTable === 'size' ? 'border-b-2 border-red-700' : 'border-b-0'">
              <span>Size</span>
            </button>
            <button class="flex items-center justify-between mx-3 h-[75px] border-b-2 px-3 hover:bg-[#FBFBFB]"
              @click="activeTable = 'weight'"
              :class="activeTable === 'weight' ? 'border-b-2 border-red-700' : 'border-b-0'">
              <span>Weight</span>
            </button>
            <button class="flex items-center justify-between mx-3 h-[75px] border-b-2 px-3 hover:bg-[#FBFBFB]"
              @click="activeTable = 'vehicle'"
              :class="activeTable === 'vehicle' ? 'border-b-2 border-red-700' : 'border-b-0'">
              <span>Vehicle</span>
            </button>
          </div>
        </div>
        <SRScroll class="w-auto my-0 border-0 border-none">
          <div v-show="activeTable === 'size'" class="w-full p-6 m-3 bg-white border-2 rounded-xl" id="size">
            <div class="flex items-center justify-between mb-5">
              <p class="text-xl font-bold ">Size</p>
              <div class="flex gap-x-3">
                <button class="hover:scale-105">
                  <i v-html="icons.PlusCircle" class="text-[#AA0927]" @click="
                    isOpen = true;
                  TaxonomiesCreate = false;
                  TaxonomiesSizeCreate = true;
                  TaxonomiesSizeUpdate = false;
                  TaxonomiesSizeDelete = false;
                  TaxonomiesWeightCreate = false;
                  TaxonomiesWeightUpdate = false;
                  TaxonomiesWeightDelete = false;
                  "></i>
                </button>
                <button class="hover:scale-105">
                  <i v-html="icons.EllipsisHorizontalCircle" class="text-[#AA0927]" @click="
                    isOpen = true;
                  TaxonomiesCreate = false;
                  TaxonomiesSizeCreate = false;
                  TaxonomiesSizeUpdate = false;
                  TaxonomiesSizeDelete = true;
                  TaxonomiesWeightCreate = false;
                  TaxonomiesWeightUpdate = false;
                  TaxonomiesWeightDelete = false;
                  "></i>
                </button>
              </div>
            </div>
            <SRTable>
              <template #Table-Header>
                <th class="tableHeader">ID</th>
                <th class="tableHeader">Sizes</th>
                <th class="tableHeader">Size Range (Min - Max)</th>
                <th class="tableHeader">Set Fee (in $)</th>
                <th class="tableHeader">Action</th>
              </template>
              <template #Table-Body>
                <tr v-for="items in dataSize" :key="items.id" class="[&>*]:p-5">
                  <td>{{ items.SizeCategoryID }}</td>
                  <td>{{ items.sc_categoryName }}</td>
                  <td>
                    {{ items.sc_minSize }} - {{ items.sc_maxSize }}
                  </td>
                  <td>$ {{ items.sc_setFee }}</td>
                  <td>
                    <div class="flex flex-row">
                      <button class="table-buttons bg-white border-2 border-[#AA0927] text-[#AA0927] hover:scale-105"
                        @click="
                          isOpen = true;
                        TaxonomiesCreate = false;
                        TaxonomiesSizeCreate = false;
                        TaxonomiesSizeUpdate = true;
                        TaxonomiesSizeDelete = false;
                        TaxonomiesWeightCreate = false;
                        TaxonomiesWeightUpdate = false;
                        TaxonomiesWeightDelete = false;
                        sizeId(items.SizeCategoryID);
                        ">
                        EDIT
                      </button>
                      <button class="table-buttons bg-[#AA0927] text-white hover:scale-105" @click="
                        isOpen = true;
                      TaxonomiesCreate = false;
                      TaxonomiesSizeCreate = false;
                      TaxonomiesSizeUpdate = false;
                      TaxonomiesSizeDelete = true;
                      TaxonomiesWeightCreate = false;
                      TaxonomiesWeightUpdate = false;
                      TaxonomiesWeightDelete = false;
                      sizeId(items.SizeCategoryID);
                      ">
                        DELETE
                      </button>
                    </div>
                  </td>
                </tr>
              </template>
            </SRTable>
          </div>
        </SRScroll>
        <SRScroll class="w-auto my-0 border-0 border-none">
          <div v-show="activeTable === 'weight'" class="w-full p-6 m-3 bg-white border-2 rounded-xl" id="weight">
            <div class="flex items-center justify-between mb-5">
              <p class="text-xl font-bold ">Weight</p>
              <span class="flex gap-x-3">
                <button class="hover:scale-105">
                  <i v-html="icons.PlusCircle" class="text-[#AA0927]" @click="
                    isOpen = true;
                  TaxonomiesCreate = false;
                  TaxonomiesSizeCreate = false;
                  TaxonomiesSizeUpdate = false;
                  TaxonomiesSizeDelete = false;
                  TaxonomiesWeightCreate = true;
                  TaxonomiesWeightUpdate = false;
                  TaxonomiesWeightDelete = false;
                  "></i>
                </button>
                <button class="hover:scale-105">
                  <i v-html="icons.EllipsisHorizontalCircle" class="text-[#AA0927]" @click="
                    isOpen = true;
                  TaxonomiesCreate = false;
                  TaxonomiesSizeCreate = false;
                  TaxonomiesSizeUpdate = false;
                  TaxonomiesSizeDelete = false;
                  TaxonomiesWeightCreate = false;
                  TaxonomiesWeightUpdate = false;
                  TaxonomiesWeightDelete = true;
                  "></i>
                </button>
              </span>
            </div>
            <SRTable>
              <template #Table-Header>
                <th class="tableHeader">ID</th>
                <th class="tableHeader">Weights</th>
                <th class="tableHeader">Weight Range (Min - Max)</th>
                <th class="tableHeader">Set Fee (in $)</th>
                <th class="tableHeader">Action</th>
              </template>
              <template #Table-Body>
                <tr v-for="items in dataWeight" :key="items.id" class="[&>*]:p-5">
                  <td>{{ items.WeightCategoryID }}</td>
                  <td>{{ items.wc_categoryName }}</td>
                  <td>
                    {{ items.wc_minWeight }} - {{ items.wc_maxWeight }}
                  </td>
                  <td>$ {{ items.wc_setFee }}</td>
                  <td>
                    <div class="flex flex-row">
                      <button class="table-buttons bg-white border-2 border-[#AA0927] text-[#AA0927] hover:scale-105"
                        @click="
                          isOpen = true;
                        TaxonomiesCreate = false;
                        TaxonomiesSizeCreate = false;
                        TaxonomiesSizeUpdate = false;
                        TaxonomiesSizeDelete = false;
                        TaxonomiesWeightCreate = false;
                        TaxonomiesWeightUpdate = true;
                        TaxonomiesWeightDelete = false;
                        weightId(items.WeightCategoryID);
                        ">
                        EDIT
                      </button>
                      <button class=" table-buttons bg-[#AA0927] text-white hover:scale-105" @click="
                        isOpen = true;
                      TaxonomiesCreate = false;
                      TaxonomiesSizeCreate = false;
                      TaxonomiesSizeUpdate = false;
                      TaxonomiesSizeDelete = false;
                      TaxonomiesWeightCreate = false;
                      TaxonomiesWeightUpdate = false;
                      TaxonomiesWeightDelete = true;
                      weightId(items.WeightCategoryID);
                      ">
                        DELETE
                      </button>
                    </div>
                  </td>
                </tr>
              </template>
            </SRTable>
          </div>
        </SRScroll>
        <SRScroll class="w-auto my-0 border-0 border-none">
          <div v-show="activeTable === 'vehicle'" class="w-full p-6 m-3 bg-white border-2 rounded-xl" id="vehicle">
            <div class="flex items-center justify-between mb-5 ">
              <p class="text-xl font-bold ">Vehicle</p>
              <span class="flex gap-x-3">
                <button class="hover:scale-105">
                  <i v-html="icons.PlusCircle" class="text-[#AA0927]"></i>
                </button>
                <button>
                  <i v-html="icons.EllipsisHorizontalCircle" class="text-[#AA0927]" @click="
                    isOpen = true;
                  TaxonomiesCreate = true;
                  TaxonomiesSizeCreate = false;
                  TaxonomiesSizeUpdate = false;
                  TaxonomiesSizeDelete = false;
                  TaxonomiesWeightCreate = false;
                  TaxonomiesWeightUpdate = false;
                  TaxonomiesWeightDelete = false;"></i>
                </button>
              </span>
            </div>
            <SRTable>
              <template #Table-Header>
                <th class="tableHeader">ID</th>
                <th class="tableHeader">Size Categories</th>
                <th class="tableHeader">Description</th>
                <th class="tableHeader">Set Fee</th>
                <th class="tableHeader">Action</th>
              </template>
              <template #Table-Body>
                <tr class="[&>*]:p-5">
                  <td>00001</td>
                  <td>TechNova Solutions</td>
                  <td>dummy@email.com</td>
                  <td>123 Main StreetAnyTouw, CA 90210</td>
                  <td>
                    <div class="flex flex-row">
                      <button class="table-buttons bg-white border-2 border-[#AA0927] text-[#AA0927]">
                        EDIT
                      </button>
                      <button class="table-buttons bg-[#AA0927] text-white">
                        DELETE
                      </button>
                    </div>
                  </td>
                </tr>
              </template>
            </SRTable>
          </div>
        </SRScroll>
      </div>
    </template>
  </SRContents>
</template>

<script setup>
//
import icons from "@/assets/icons";
import SRModalSlots from "@/components/SRModalSlots.vue";
import SRTable from "@/components/SRTable.vue";
import SRScroll from "@/components/SRScroll.vue";
import SRContents from "@/layouts/SRContents.vue";
import { getTaxonomies, addSize, addWeight, updateSize, updateWeight, deleteSize, deleteWeight } from "@/services/ApiServices.js";
import { onMounted, ref } from "vue";

// Define a reactive variable 'isOpen' with initial value as false
let isOpen = ref(Boolean);

// Taxonomies
let TaxonomiesCreate = ref(false);

// Taxonomies Size
let TaxonomiesSizeCreate = ref(false);
let TaxonomiesSizeUpdate = ref(false);
let TaxonomiesSizeDelete = ref(false);

// Taxonomies Size
let TaxonomiesWeightCreate = ref(false);
let TaxonomiesWeightUpdate = ref(false);
let TaxonomiesWeightDelete = ref(false);

// Table
let activeTable = ref("size");
let dataSize = ref([]);
let dataWeight = ref([]);

// Taxonomies
let viewSize = ref("");
let viewWeight = ref("");
let sizeIdNumber = ref("");
let categoryName = ref("");
let sizeCategoryName = ref("");
let sizeMin = ref("");
let sizeMax = ref("");
let sizeSetFee = ref("");
let weightIdNumber = ref("");
let weightCategoryName = ref("");
let weightMin = ref("");
let weightMax = ref("");
let weightSetFee = ref("");

if (isOpen.value == false) {
  weightCategoryName = "";
  weightMin = "";
  weightMax = "";
  weightSetFee = "";
  sizeCategoryName = "";
  sizeMin = "";
  sizeMax = "";
  sizeSetFee = "";
}

function createTaxonomy() {
  console.log(categoryName.value);
}

// Size-related Functions
function createSize(category, min, max, fee) {
  addSize(category, min, max, fee)
    .then((info) => {
      isOpen.value = false;
      sizeCategoryName = "";
      sizeMin = "";
      sizeMax = "";
      sizeSetFee = "";
      getData();
    }).catch((error) => {
      sizeCategoryName = "";
      sizeMin = "";
      sizeMax = "";
      sizeSetFee = "";
    });
}

function sizeId(id) {
  viewSize.value = JSON.parse(
    JSON.stringify(dataSize.value.find((items) => items.SizeCategoryID === id))
  );
  sizeIdNumber.value = viewSize.SizeCategoryID;
}
function renewSize(id, category, min, max, fee) {
  updateSize(id, category, min, max, fee).then((info) => {
    console.log("Success message: ", info);
    isOpen.value = false;
    sizeCategoryName = "";
    sizeMin = "";
    sizeMax = "";
    sizeSetFee = "";
    getData();
  }).catch((error) => {
    console.error("Error message: ", error);
    sizeCategoryName = "";
    sizeMin = "";
    sizeMax = "";
    sizeSetFee = "";
  })
}

function removeSize(id) {
  console.log(id);
  deleteSize(id)
    .then((info) => {
      console.log("Success message: ", info);
      isOpen.value = false;
      getData();
    }).catch((error) => {
      console.error("Error message: ", error);
    });
}

// Weight-related Functions
function createWeight(category, min, max, fee) {
  addWeight(category, min, max, fee)
    .then((info) => {
      console.log("Success message: ", info);
      isOpen.value = false;
      weightCategoryName = "";
      weightMin = "";
      weightMax = "";
      weightSetFee = "";
      getData();
    }).catch((error) => {
      console.error("Error message: ", error);
      weightCategoryName = "";
      weightMin = "";
      weightMax = "";
      weightSetFee = "";
    });
}

function weightId(id) {
  viewWeight.value = JSON.parse(
    JSON.stringify(dataWeight.value.find((items) => items.WeightCategoryID === id))
  );
  weightIdNumber.value = viewWeight.WeightCategoryID;
}

function renewWeight(id, category, min, max, fee) {
  updateWeight(id, category, min, max, fee).then((info) => {
    console.log("Success message: ", info);
    isOpen.value = false;
    weightCategoryName = "";
    weightMin = "";
    weightMax = "";
    weightSetFee = "";
    getData();
  }).catch((error) => {
    console.error("Error message: ", error);
    weightCategoryName = "";
    weightMin = "";
    weightMax = "";
    weightSetFee = "";
  })
}


function removeWeight(id) {
  console.log(id);
  deleteWeight(id)
    .then((info) => {
      isOpen.value = false;
      getData();
    }).catch((error) => {
      console.error(error);
    });
}

function getData() {
  getTaxonomies()
    .then((info) => {
      console.log("Retrieved data: ", info.data.results);
      if (info.data.results.size || info.data.results.weight) {
        dataSize.value = info.data.results.size;
        dataWeight.value = info.data.results.weight;
      } else {
        location.reload();
      }
    })
    .catch((error) => {
      console.error("Error fetching data: ", error);
      location.reload();
    });
}

onMounted(getData);
</script>

<style lang="scss" scoped>
.table-buttons {
  width: 50%;
  padding: 0.5rem;
  margin: 0.25rem;
  border-radius: 0.375rem;
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
