<template>
  <div>
    <SRContents v-if="userStatus == 0">
      <template #Content-Header>
        <h2>Dashboard</h2>
      </template>
      <template #Content-Body>
        <div class="flex 2xl:block 2xl:space-y-2">
          <!-- column 1 -->
          <div id="left" class="flex flex-wrap w-[800px] gap-[20px] mr-5 2xl:w-full 2xl:mr-0 lg:w-full lg:gap-2">
            <div id="FeedBack"
              class="inline-block w-full p-6 border border-gray-300 border-solid rounded-lg sm:p-4 hover:shadow-sm">
              <span class="font-bold text-2xl-lg"> Latest Feedbacks </span>
              <a href="" class="relative float-right text-xl font-bold text-[#AA0927] sm:text-base">
                <span>View All</span>
              </a>
            </div>
            <div id="task-reports"
              class="w-full h-[650px] border hover:shadow-sm border-solid rounded-lg border-gray-300">
              <div id="task-header">
                <h3 class="p-6 font-bold text-2xl-lg sm:p-4">
                  <span>Task Reports</span>
                </h3>
              </div>
              <div id="Chart" class="flex items-center h-full px-10 pb-20 lg:z-10">
                <apexchart type="bar" class="w-full" height="90%" :options="BarOptions" :series="BarSeries">
                </apexchart>
              </div>
            </div>
          </div>
          <!-- column 2 -->
          <div id="right" class="flex flex-wrap w-[555px] gap-[20px] lg:w-full lg:flex-none lg:gap-2">
            <div class="flex flex-wrap w-full gap-[20px] lg:flex lg:flex-none lg:gap-2">
              <div id="total-income"
                class="w-full p-6 border border-gray-300 border-solid rounded-lg lg:w-auto lg:flex-grow sm:p-4 hover:shadow-sm border-3">
                <h2 class="font-bold text-2xl-lg lg:text-xl sm:text-lg">
                  Total Income
                  <small class="before:content-['|']"> This Month</small>
                </h2>
                <h3 class="mb-6 font-bold sm:text-sm sm:mb-3">$0</h3>
                <p class="w-auto mx-1 sm:text-xs">
                  Previous Month <span class="float-right">$0.00</span><br />
                  All Time <span class="float-right">$0.00</span>
                </p>
              </div>
              <div id="new-customers"
                class="w-full p-6 border border-gray-300 border-solid rounded-lg lg:w-auto lg:flex-grow sm:p-4 hover:shadow-sm border-3">
                <h2 class="font-bold text-2xl-lg lg:text-xl sm:text-lg">
                  <span>New Customers </span>
                  <small class="before:content-['|']"> This Month</small>
                </h2>
                <h3 class="mb-6 font-bold sm:text-sm sm:mb-3">$0</h3>
                <p class="w-auto mx-1 sm:text-xs">
                  Previous Month <span class="float-right">$0.00</span><br />
                  All Time <span class="float-right">$0.00</span>
                </p>
              </div>
            </div>
            <div id="employees"
              class="w-full h-auto p-6 border border-gray-300 border-solid rounded-lg sm:p-4 hover:shadow-sm">
              <div id="flexible" class="flex justify-between">
                <h2 class="font-bold text-2xl-lg">
                  <span class="pb-5">Employees</span><br />
                  <small>4</small>
                </h2>
                <h3 class="grid grid-cols-[1fr_50px] text-center">
                  <label class="col-start-1">Delivery Rider</label><span>3</span><br />
                  <label class="col-start-1">Ride Sharers</label><span>1</span>
                </h3>
              </div>
              <div id="EmployeePieChart">
                <apexchart type="pie" class="w-[440px] 6xl:w-[400px] 4xl:w-[350px] lg:w-[440px]" :options="PieOptions"
                  :series="PieSeries"></apexchart>
              </div>
            </div>
          </div>
        </div>
      </template>
    </SRContents>
  </div>
  <div>
    <SRContents v-if="userStatus == 1">
      <template #Content-Header>
        <h2>Dashboard</h2>
      </template>
      <template #Content-Body>
        <div class="flex 2xl:block 2xl:space-y-2">
          <div id="left" class="flex flex-wrap w-[800px] gap-[20px] mr-5 2xl:w-full 2xl:mr-0 lg:w-full lg:gap-2">
            <div id="FeedBack"
              class="inline-block w-full p-6 border border-gray-300 border-solid rounded-lg sm:p-4 hover:shadow-sm">
              <span class="font-bold text-2xl-lg"> Latest Feedbacks </span>
              <a href="" class="relative float-right text-xl font-bold text-[#AA0927] sm:text-base">
                <span>View All</span>
              </a>
            </div>
            <div id="task-reports"
              class="w-full h-[650px] hover:shadow-sm border border-solid rounded-lg border-gray-300">
              <div id="task-header">
                <h3 class="p-6 font-bold text-2xl-lg sm:p-4">
                  <span>Task Reports</span>
                </h3>
              </div>
              <div id="Chart" class="flex items-center h-full px-10 pb-20 lg:z-10">
                <apexchart type="bar" class="w-full" height="90%" :options="BarOptions" :series="BarSeries">
                </apexchart>
              </div>
            </div>
          </div>
          <div id="right" class="flex flex-wrap w-[555px] gap-[20px] lg:w-full lg:flex-none lg:gap-2">
            <div class="flex flex-wrap w-full gap-[20px] lg:flex lg:flex-none lg:gap-2">
              <div id="total-income"
                class="w-full p-6 border border-gray-300 border-solid rounded-lg lg:w-auto lg:flex-grow sm:p-4 hover:shadow-sm border-3">
                <h2 class="font-bold text-2xl-lg lg:text-xl sm:text-lg">
                  Total Income
                  <small class="before:content-['|']"> This Month</small>
                </h2>
                <h3 class="mb-6 font-bold sm:text-sm sm:mb-3">$0</h3>
                <p class="w-auto mx-1 sm:text-xs">
                  Previous Month <span class="float-right">$0.00</span><br />
                  All Time <span class="float-right">$0.00</span>
                </p>
              </div>
              <div id="new-customers"
                class="w-full p-6 border border-gray-300 border-solid rounded-lg lg:w-auto lg:flex-grow sm:p-4 hover:shadow-sm border-3">
                <h2 class="font-bold text-2xl-lg lg:text-xl sm:text-lg">
                  <span>New Customers </span>
                  <small class="before:content-['|']"> This Month</small>
                </h2>
                <h3 class="mb-6 font-bold sm:text-sm sm:mb-3">$0</h3>
                <p class="w-auto mx-1 sm:text-xs">
                  Previous Month <span class="float-right">$0.00</span><br />
                  All Time <span class="float-right">$0.00</span>
                </p>
              </div>
            </div>
            <div id="employees"
              class="w-full h-auto p-6 border border-2 border-gray-300 border-solid rounded-lg sm:p-4 hover:shadow-sm">
              <div id="flexible" class="flex justify-between">
                <h2 class="font-bold text-2xl-lg">
                  <span class="pb-5">Employees</span><br />
                  <small>4</small>
                </h2>
                <h3 class="grid grid-cols-[1fr_50px] text-center">
                  <label class="col-start-1">Delivery Rider</label><span>3</span><br />
                  <label class="col-start-1">Ride Sharers</label><span>1</span>
                </h3>
              </div>
              <div id="EmployeePieChart">
                <apexchart type="pie" class="w-[440px] 6xl:w-[400px] 4xl:w-[350px] lg:w-[440px]" :options="PieOptions"
                  :series="PieSeries"></apexchart>
              </div>
            </div>
          </div>
        </div>
      </template>
    </SRContents>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import SRContents from "@/layouts/SRContents.vue";
import { useRoute } from "vue-router";
import { retrieveData } from "@/services/ApiServices.js";

const userStatus = ref("");

const BarSeries = [
  {
    name: "Actual",
    data: [
      { x: "A", y: 550 },
      { x: "B", y: 380 },
      { x: "C", y: 0 },
      { x: "D", y: 0 },
    ],
  },
];
const BarOptions = {
  plotOptions: {
    bar: {
      columnWidth: "60%",
    },
  },
  colors: ["#AA0927"],
  dataLabels: {
    enabled: false,
  },
  legend: {
    show: false,
  },
};

const PieSeries = [3, 1];

const PieOptions = {
  colors: ["#AA0927", "#0E0E0E"],
  labels: ["Delivery Riders", "Rider Sharers"],
  legend: {
    position: "left",
    markers: {
      radius: 0,
      width: 50,
    },
  },
  dataLabels: {
    enabled: false,
  },
};
const route = useRoute();
onMounted(() => {
  retrieveData()
    .then((data) => {
      userStatus.value = data.data.data.UserAccess;
      console.info("data: ", data);
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
    });
});
</script>

<style scoped></style>
