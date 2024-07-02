<template>
  <SRModalSlots v-show="isOpen == true" @close="isOpen = false">
    <template #Modal-Header>
      <div class="flex justify-between px-5 py-5 bg-[#AA0927] text-white text-3xl font-semibold">
        <h2 v-show="FeesCreate == true">Create Fees</h2>
        <h2 v-show="VehicleFeeCreate == true">Create Vehicle Fees</h2>
        <h2 v-show="FeesUpdate == true">Edit Fees</h2>
        <h2 v-show="VehicleFeeUpdate == true">Edit Vehicle Fees</h2>
        <h2 v-show="FeesDelete == true">Delete Fees</h2>
        <h2 v-show="VehicleFeesDelete == true">Delete Vehicle Fees</h2>
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
        <div v-show="FeesCreate == true" id="create">
          <form @submit.prevent="createFees(feesName, feesValue)" id="createFeesId">
            <div class="flex flex-col gap-3">
              <div class="flex items-center justify-between [&>*]:w-1/2 text-xl font-normal">
                <label for="">Fees Name: </label>
                <input type="text" class="p-2 border rounded focus:border-gray-400 focus:outline-none" />
              </div>
              <div class="flex items-center justify-between [&>*]:w-1/2 text-xl font-normal">
                <label for="">Value: </label>
                <input type="text" class="p-2 border rounded focus:border-gray-400 focus:outline-none" />
              </div>
            </div>
          </form>
        </div>

        <div v-show="VehicleFeeCreate == true" id="create">
          <form
            @submit.prevent="createVehicleFee(viewVehicle.vehicleTypeID, vehicleTypeName, vehicleBaseDistanceValue, vehicleBaseFeeValue, vehicleDistanceFeeValue)"
            id="createVehicleFeeId">
            <div class="flex flex-col gap-3">
              <div class="flex items-center justify-between [&>*]:w-1/2 text-xl font-normal">
                <label for="">Vehicle Type Name:</label>
                <input type="text" class="p-2 border rounded focus:outline-none focus:border-gray-400"
                  v-model="vehicleTypeName" />
              </div>
              <div class="flex items-center justify-between [&>*]:w-1/2 text-xl font-normal">
                <label for="">Base Distance Value: </label>
                <input type="number" min="1" max="999"
                  class="p-2 border rounded focus:border-gray-400 focus:outline-none"
                  v-model="vehicleBaseDistanceValue" />
              </div>
              <div class="flex items-center justify-between [&>*]:w-1/2 text-xl font-normal">
                <label for="">Base Fee Value:</label>
                <input type="number" min="1" max="999"
                  class="p-2 border rounded focus:outline-none focus:border-gray-400" v-model="vehicleBaseFeeValue" />
              </div>
              <div class="flex items-center justify-between [&>*]:w-1/2 text-xl font-normal">
                <label for="">Distance Fee Value:</label>
                <input type="number" min="1" max="999"
                  class="p-2 border rounded focus:outline-none focus:border-gray-400"
                  v-model="vehicleDistanceFeeValue" />
              </div>
            </div>
          </form>
        </div>

        <div v-show="VehicleFeeUpdate == true">
          <form
            @submit.prevent="updateVehicleFee(viewVehicle.vehicleTypeID, vehicleTypeName, vehicleBaseDistanceValue, vehicleBaseFeeValue, vehicleDistanceFeeValue)"
            id="updateVehicleFeeId">
            <div class="flex flex-col gap-3">
              <div class="flex items-center justify-between [&>*]:w-1/2 text-xl font-normal">
                <label for="">Vehicle Type Name:</label>
                <input type="text" class="p-2 border rounded focus:outline-none focus:border-gray-400"
                  :placeholder="viewVehicle.vehic_type" v-model="vehicleTypeName" />
              </div>
              <div class="flex items-center justify-between [&>*]:w-1/2 text-xl font-normal">
                <label for="">Base Distance Value: </label>
                <input type="number" min="1" max="999"
                  class="p-2 border rounded focus:border-gray-400 focus:outline-none"
                  :placeholder="viewVehicle.vehicle_baseDistance" v-model="vehicleBaseDistanceValue" />
              </div>
              <div class="flex items-center justify-between [&>*]:w-1/2 text-xl font-normal">
                <label for="">Base Fee Value:</label>
                <input type="number" min="1" max="999"
                  class="p-2 border rounded focus:outline-none focus:border-gray-400"
                  :placeholder="viewVehicle.vehicle_baseFee" v-model="vehicleBaseFeeValue" />
              </div>
              <div class="flex items-center justify-between [&>*]:w-1/2 text-xl font-normal">
                <label for="">Distance Fee Value:</label>
                <input type="number" min="1" max="999"
                  class="p-2 border rounded focus:outline-none focus:border-gray-400"
                  :placeholder="viewVehicle.vehicle_distanceFee" v-model="vehicleDistanceFeeValue" />
              </div>
            </div>
          </form>
        </div>

      </div>

      <div v-show="FeesDelete == true" id="delete" class="pt-5 text-3xl font-bold text-center">
        <form @submit.prevent="deleteFees()" id="deleteFeesId">
          <h2>Are you sure you want to delete?</h2>
        </form>
      </div>

      <div v-show="VehicleFeesDelete == true" id="delete" class="pt-5 text-3xl font-bold text-center">
        <form @submit.prevent="deleteVehicleFees()" id="deleteVehicleFeeId">
          <h2>Are you sure you want to delete?</h2>
        </form>
      </div>

    </template>
    <template #Modal-Footer>
      <div class="flex justify-end w-full px-6 py-5">
        <div v-show="FeesCreate == true">
          <button class="w-[223px] h-[64px] rounded-2xl bg-[#09aa3c] text-2xl text-white font-bold hover:bg-green-600"
            form="createFeesId">
            Create
          </button>
        </div>

        <div v-show="VehicleFeeCreate == true">
          <button class="w-[223px] h-[64px] rounded-2xl bg-[#09aa3c] text-2xl text-white font-bold hover:bg-green-600"
            type="submit" form="createVehicleFeeId">
            Create
          </button>
        </div>

        <div v-show="FeesUpdate == true">
          <button class="w-[223px] h-[64px] rounded-2xl bg-[#09aa3c] text-2xl text-white font-bold hover:bg-green-600"
            type="submit" form="updateFeesId">
            Update
          </button>
        </div>

        <div v-show="VehicleFeeUpdate == true">
          <button class="w-[223px] h-[64px] rounded-2xl bg-[#09aa3c] text-2xl text-white font-bold hover:bg-green-600"
            type="submit" form="updateVehicleFeeId">
            Update
          </button>
        </div>

        <div v-show="FeesDelete == true">
          <button class="w-[223px] h-[64px] rounded-2xl bg-[#aa0927] text-2xl text-white font-bold hover:bg-rose-950"
            type="submit" form="deleteFeesId">
            Delete
          </button>
        </div>

        <div v-show="VehicleFeesDelete == true">
          <button class="w-[223px] h-[64px] rounded-2xl bg-[#aa0927] text-2xl text-white font-bold hover:bg-rose-950"
            type="submit" form="deleteVehicleFeeId">
            Delete
          </button>
        </div>

      </div>
    </template>
  </SRModalSlots>
  <SRContents>
    <template #Content-Header>
      <div class="flex">
        <h2>Fees</h2>
      </div>
    </template>
    <template #Content-Body>
      <div class="flex flex-col w-full h-auto m-3 bg-white border-2 rounded-lg hover:shadow-lg">
        <div class="px-6 pb-3 m-3 ">
          <div class="flex items-center justify-between my-3 bg-white">
            <p class="text-xl font-bold">General Fees</p>
            <button @click="
              isOpen = true;
            FeesCreate = true;
            VehicleFeeCreate = false;
            FeesUpdate = false;
            VehicleFeeUpdate = false;
            FeesDelete = false;
            VehicleFeesDelete = false;
            " class="w-12 md:w-8 hover:scale-105" v-html="icons.AddBtn"></button>
          </div>
          <div class="flex gap-3">
            <div class="flex flex-col w-full p-5 bg-white border-2" v-for="items in feesData" :key="items.id">
              <div class="flex justify-between p-3 border-b-2">
                <p class="text-xl font-bold"> App Fee Info</p>
                <div
                  class="flex gap-x-1 [&>button]:p-1.5 [&>button]:w-9 [&>button]:bg-[#AA0927] [&>button]:text-white [&>button]:rounded-full">
                  <button class="hover:bg-rose-600" @click="isFeeEdit()" v-html="icons.EdtBtn"></button>
                  <button class="hover:bg-rose-600" @click="
                    isOpen = true;
                  FeesCreate = false;
                  VehicleFeeCreate = false;
                  FeesUpdate = false;
                  VehicleFeeUpdate = false;
                  FeesDelete = true;
                  VehicleFeesDelete = false;;
                  " v-html="icons.DelBtn"></button>
                </div>
              </div>
              <form @submit.prevent="updateFees(feeValue, vatValue)" id="updateFees">
                <div class="flex items-center justify-between gap-2 p-5">
                  <div class="flex items-center justify-center">
                    <i v-html="icons.CoinStack" class="w-7 h-7"></i>
                    <p class="w-24 text-lg font-bold">Fees</p>
                  </div>
                  <div>
                    <p v-show="!editAppFee == true" class="p-2">{{ items.af_appFees }}</p>
                    <input type="number" min="1" max="999" name="" id="" v-model="feeValue"
                      :placeholder="items.af_appFees" v-show="editAppFee == true"
                      class="p-2 text-center border rounded-lg focus:border-gray-400 focus:outline-none">
                  </div>
                  <div>
                  </div>
                </div>
                <div class="flex items-center justify-between gap-2 p-5">
                  <div class="flex items-center justify-center">
                    <i v-html="icons.CoinStack" class="w-7 h-7"></i>
                    <p class="w-24 text-lg font-bold">VAT</p>
                  </div>
                  <div>
                    <p v-show="!editAppFee == true" class="p-2">{{ items.af_vat }}</p>
                    <input type="number" min="1" max="999" name="" id="" v-model="vatValue" :placeholder="items.af_vat"
                      v-show="editAppFee == true"
                      class="p-2 text-center border rounded-lg focus:border-gray-400 focus:outline-none">
                  </div>
                  <div></div>
                </div>
              </form>
              <div v-show="editAppFee == true"
                class="flex items-center justify-end gap-2 pt-5 [&>button]:p-3  [&>button]:rounded-lg border-t-2">
                <button class="bg-white text-[#AA0927] border-2 border-[#AA0927] hover:shadow-shadow" type="submit"
                  form="updateFees">Save
                  Changes</button>
                <button class="bg-[#AA0927] text-white border-2 border-[#AA0927] hover:shadow-shadow"
                  @click="isFeeEdit(items.AppFeeID)"> Cancel</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="flex flex-col w-full h-auto m-3 bg-white border-2 rounded-lg hover:shadow-lg">
        <div class="px-6 pb-3 m-3">
          <div class="flex items-center justify-between my-3">
            <p class="text-xl font-bold">Vehicle Fees</p>
            <button @click="
              isOpen = true;
            FeesCreate = false;
            VehicleFeeCreate = true;
            FeesUpdate = false;
            VehicleFeeUpdate = false;
            FeesDelete = false;
            VehicleFeesDelete = false
              " class="w-12 md:w-8 hover:scale-105" v-html="icons.AddBtn"></button>
          </div>
          <SRTable>
            <template #Table-Header>
              <th class="tableHeader">Vehicle Type</th>
              <th class="tableHeader">Base Distance</th>
              <th class="tableHeader">Base Fee</th>
              <th class="tableHeader">Distance Fee</th>
              <th class="tableHeader">Action</th>
            </template>
            <template #Table-Body>
              <tr v-for="items in vehicleData" :key="items.id" class="[&>*]:p-5">
                <td class="tableData">{{ items.vehic_type }}</td>
                <td class="tableData">{{ items.vehicle_baseDistance }}</td>
                <td class="tableData">{{ items.vehicle_baseFee }}</td>
                <td class="tableData">{{ items.vehicle_distanceFee }}</td>
                <td class="tableData">
                  <div class="flex flex-row justify-center gap-2 [&>button]:rounded [&>button]:p-2">
                    <button class="table-buttons bg-white border-2 border-[#AA0927] text-[#AA0927]" @click="
                      isOpen = true;
                    FeesCreate = false;
                    VehicleFeeCreate = false;
                    FeesUpdate = false;
                    VehicleFeeUpdate = true;
                    FeesDelete = false;
                    VehicleFeesDelete = false;
                    updateVehicleFeeId(items.vehicleTypeID);
                    ">
                      EDIT
                    </button>
                    <button class=" table-buttons bg-[#AA0927] text-white" @click="isOpen = true;
                    FeesCreate = false;
                    VehicleFeeCreate = false;
                    FeesUpdate = false;
                    VehicleFeeUpdate = false;
                    FeesDelete = false;
                    VehicleFeesDelete = true">
                      DELETE
                    </button>
                  </div>
                </td>
              </tr>
            </template>
          </SRTable>
        </div>
      </div>
    </template>
  </SRContents>
</template>

<script setup>
import icons from "@/assets/icons";
import { useRouter } from "vue-router";
import SRModalSlots from "@/components/SRModalSlots.vue";
import SRContents from "@/layouts/SRContents.vue";
import { getFees, getVehicles, vehicleAdd, vehicleUpdate } from "@/services/ApiServices.js";
import SRTable from "@/components/SRTable.vue";
import { onMounted, ref } from "vue";

//Variables
const router = useRouter();
let isOpen = ref(Boolean);
let FeesCreate = ref(false);
let FeesUpdate = ref(false);
let FeesDelete = ref(false);
let editAppFee = ref(false);
let feesData = ref([]);
let vehicleData = ref([]);
let viewVehicle = ref([]);

//Variable for Vehicle Fees
let vehicleTypeName = ref("");
let vehicleBaseDistanceValue = ref("");
let vehicleBaseFeeValue = ref("");
let vehicleDistanceFeeValue = ref("");

//Variable for Fees
let feeValue = ref("");
let vatValue = ref("");

function isFeeEdit() {
  editAppFee.value = !editAppFee.value;
}

function createFees() {
  console.log("create Fees");
}

function createVehicleFee(vehicleId, vehicleType, baseDistance, baseFee, distanceFee) {
  vehicleAdd(vehicleId, vehicleType, baseDistance, baseFee, distanceFee)
    .then(result => {
      isOpen.value = false;
      getData();
      console.log("Success adding vehicle: ", result);
    })
    .catch(error => {
      console.log("Error: ", error);
    });
}

function updateFees(id) {
  console.log("update App Fee: ", id);
}

function updateVehicleFeeId(id) {
  viewVehicle.value = JSON.parse(
    JSON.stringify(vehicleData.value.find((items) => items.vehicleTypeID === id))
  );
}
function updateVehicleFee(vehicleId, vehicleType, baseDistance, baseFee, distanceFee) {
  vehicleUpdate(vehicleId, vehicleType, baseDistance, baseFee, distanceFee)
    .then((response) => {
      console.log("Success updating vehicle fee:", response);
      isOpen.value = false;
      getData();
    })
    .catch((error) => {
      console.log("Error updating vehicle fee:", error);
    });
}


function deleteFees() {
  console.log("delete Fees");
}

function deleteVehicleFees() {
  console.log("delete Vehicle Fee");
}

async function getData() {
  try {
    const feesResponse = await getFees();
    feesData.value = feesResponse.data.results;
    console.log(feesData.value);

    const vehiclesResponse = await getVehicles();
    vehicleData.value = vehiclesResponse.data.result;
    console.log(vehicleData.value);
  } catch (error) {
    console.error("Error fetching data:", error);
    router.push("/login");
  }
}

onMounted(getData);
</script>

<style lang="scss" scoped>
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
