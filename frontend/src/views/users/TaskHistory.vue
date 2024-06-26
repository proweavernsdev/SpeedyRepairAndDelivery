<template>
    <div class="flex flex-col w-full gap-10 pt-5 md:flex-col md:justify-start">
        <dialog id="searchDialog" class="w-2/3 p-5 rounded-xl">
            <form id="searchTask" class="flex flex-col gap-3" @submit.prevent>
                <div class="flex items-center justify-between">
                    <h2 class="text-3xl font-medium text-red-800">Search</h2>
                    <button type="button" class="text-3xl size-12"
                        @click="openDialog('searchDialog', 'close')">✖</button>
                </div>
                <hr class="w-full border">
                <div class="flex [&>*]:p-2 [&>*]:border-2">
                    <input type="text" name="search" id="searchInput" placeholder="Search tasks"
                        class="w-11/12 focus:outline-none focus:border-[#D9D9D9] focus:ring-[#D9D9D9] focus:border">
                    <button type="submit"
                        class="w-1/12 text-white bg-red-800 hover:bg-white hover:text-red-800 hover:border hover:border-red-800">Search</button>
                </div>
            </form>
        </dialog>
        <dialog id="sortDialog" class="w-2/3 p-5 rounded-xl">
            <div class="flex justify-between w-full p-3 md:p-1">
                <h2 class="flex items-center text-3xl font-medium text-red-800">
                    Filter
                </h2>
                <p class="h-auto px-4 py-2 text-3xl cursor-pointer hover:scale-105"
                    @click="openDialog('sortDialog', 'close')">✖</p>
            </div>
            <hr class="w-full border">
            <div class="flex flex-col h-[85%]">
                <form method="dialog" class="flex flex-col">
                    <div class="flex justify-around items-center w-full p-3 [&>*]:w-[48%]">
                        <label for="date-range" class="text-lg text-center">Date Range:</label>
                        <div class="flex justify-around items-center w-full [&>*]:w-[49%]">
                            <input type="date" id="start-date" name="start-date"
                                class="p-2 border focus:outline-none focus:border-slate-400">
                            <input type="date" id="end-date" name="end-date"
                                class="p-2 border focus:outline-none focus:border-slate-400">
                        </div>
                    </div>
                    <div class="flex justify-around items-center w-full p-3 [&>*]:w-[48%]">
                        <label for="priority" class="text-lg text-center">Priority:</label>
                        <select id="priority" name="priority" class="w-full p-2 rounded-sm">
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>
                    <div class="flex justify-around items-center w-full p-3 [&>*]:w-[48%]">
                        <label for="customer" class="text-lg text-center">Driver/Company:</label>
                        <input type="text" id="customer" name="customer"
                            class="w-full p-2 border rounded-sm focus:outline-none focus:border-slate-400 ">
                    </div>
                    <div class="flex justify-around w-full [&>*]:w-[48%] p-3">
                        <button type="submit"
                            class="p-2 text-white bg-red-800 rounded-lg hover:opacity-80">Apply</button>
                        <button type="button" id="closeDialog"
                            class="p-2 text-red-800 border-2 border-red-800 rounded-lg hover:opacity-80"
                            @click="openDialog('sortDialog', 'close')">Cancel</button>
                    </div>
                </form>
            </div>
        </dialog>
        <dialog id="taskDetails" class="w-2/3 p-5 rounded-xl ">
            <div class="flex items-center justify-between w-full p-3 md:p-1">
                <h2 class="flex items-center text-3xl font-medium text-red-800">Booking Details</h2>
                <button class="text-3xl size-12" @click="openDialog('taskDetails', 'close')">✖</button>
            </div>
            <hr class="w-full border">
            <div v-if="itemName === 'pendingItem'">
                <div
                    class="flex flex-wrap gap-3 p-3 first:[&>*]:w-full last:[&>*]:w-full last:[&>*]:border-0 [&>*]:w-[49%] [&>*]:p-2 [&>*]:border-2 [&>*]:border-[#D9D9D9]">
                    <div>
                        <h2 class="text-lg font-medium sm:text-lg">Tracking Number</h2>
                        <p class="sm:text-sm">{{ itemData.trackingNumber }}
                        </p>
                    </div>
                    <div>
                        <h2 class="text-lg font-medium sm:text-lg">Pickup Location</h2>
                        <p class="sm:text-sm">{{ itemData.senderaddressInfo }}
                        </p>
                    </div>
                    <div>
                        <h2 class="text-lg font-medium sm:text-lg">Dropoff Location</h2>
                        <p class="sm:text-sm">{{ itemData.receiveraddressInfo }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-medium sm:text-lg">Package Details</h2>
                        <p class="sm:text-sm">Size: A </p>
                        <p class="sm:text-sm">Weight: A</p>
                        <p class="sm:text-sm">Special Instructions: {{ itemData.notes }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-medium sm:text-lg">Status</h2>
                        <p class="capitalize sm:text-sm">{{ itemData.status }}</p>
                    </div>
                    <div class="flex flex-col gap-px p-3">
                        <h2 class="text-lg font-medium sm:text-lg">Tracking Link</h2>
                        <a href="#"
                            class="w-full p-1 text-center text-white bg-red-800 rounded-sm sm:text-sm hover:opacity-80">Track
                            Package</a>
                    </div>
                    <div>
                        <h2 class="text-lg font-medium sm:text-lg">Preferred Delivery Time</h2>
                        <p class="sm:text-sm">{{ itemData.preferredDeliveryDate }}</p>
                    </div>
                    <div class="flex p-3 gap-2 text-white justify-end w-full [&>*]:w-[25%]">
                        <button class="w-full p-2 text-xl bg-red-700 rounded-lg hover:opacity-80"
                            @click="openDialog('reportBooking', 'open')">Report</button>
                    </div>
                </div>
            </div>
            <div v-if="itemName === 'ongoingItem'">
                <div
                    class="flex flex-wrap gap-3 p-3 first:[&>*]:w-full last:[&>*]:w-full last:[&>*]:border-0 [&>*]:w-[49%] [&>*]:p-2 [&>*]:border-2 [&>*]:border-[#D9D9D9]">
                    <div>
                        <h2 class="text-lg font-medium sm:text-lg">Tracking Number</h2>
                        <p class="sm:text-sm">{{ itemData.trackingNumber }}
                        </p>
                    </div>
                    <div>
                        <h2 class="text-lg font-medium sm:text-lg">Pickup Location</h2>
                        <p class="sm:text-sm">{{ itemData.senderaddressInfo }}
                        </p>
                    </div>
                    <div>
                        <h2 class="text-lg font-medium sm:text-lg">Dropoff Location</h2>
                        <p class="sm:text-sm">{{ itemData.receiveraddressInfo }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-medium sm:text-lg">Package Details</h2>
                        <p class="sm:text-sm">Size: A </p>
                        <p class="sm:text-sm">Weight: A</p>
                        <p class="sm:text-sm">Special Instructions: {{ itemData.notes }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-medium sm:text-lg">Status</h2>
                        <p class="capitalize sm:text-sm">{{ itemData.status }}</p>
                    </div>
                    <div class="flex flex-col gap-px p-3">
                        <h2 class="text-lg font-medium sm:text-lg">Tracking Link</h2>
                        <a href="#"
                            class="w-full p-1 text-center text-white bg-red-800 rounded-sm sm:text-sm hover:opacity-80">Track
                            Package</a>
                    </div>
                    <div>
                        <h2 class="text-lg font-medium sm:text-lg">Preferred Delivery Time</h2>
                        <p class="sm:text-sm">{{ itemData.preferredDeliveryDate }}</p>
                    </div>
                    <div class="flex p-3 gap-2 text-white justify-end w-full [&>*]:w-[25%]">
                        <button class="w-full p-2 text-xl bg-red-700 rounded-lg hover:opacity-80"
                            @click="openDialog('reportBooking', 'open')">Report</button>
                    </div>
                </div>
            </div>
            <div v-if="itemName === 'completedItem'"
                class="flex flex-wrap gap-3 p-3 first:[&>*]:w-full last:[&>*]:w-full last:[&>*]:border-0 [&>*]:w-[49%] [&>*]:p-2 [&>*]:border-2 [&>*]:border-[#D9D9D9]">
                <div>
                    <h2 class="text-lg font-medium sm:text-lg">Task ID</h2>
                    <p class="sm:text-sm">123456</p>
                </div>
                <div>
                    <h2 class="text-lg font-medium sm:text-lg">Pickup Location</h2>
                    <p class="sm:text-sm">123 Main St, Anytown, USA</p>
                </div>
                <div>
                    <h2 class="text-lg font-medium sm:text-lg">Dropoff Location</h2>
                    <p class="sm:text-sm">456 Pine St, Anytown, USA</p>
                </div>
                <div>
                    <h2 class="text-lg font-medium sm:text-lg">Package Details</h2>
                    <p class="sm:text-sm">Size: Small</p>
                    <p class="sm:text-sm">Weight: 1kg</p>
                    <p class="sm:text-sm">Special Instructions: None</p>
                </div>
                <div>
                    <h2 class="text-lg font-medium sm:text-lg">Status</h2>
                    <p class="sm:text-sm">Completed</p>
                </div>
                <div>
                    <h2 class="text-lg font-medium sm:text-lg">Completion Date and Time</h2>
                    <p class="sm:text-sm">01/01/2023 11:00 AM</p>
                </div>
                <div class="flex p-3 gap-2 text-white justify-end w-full [&>*]:w-[25%]">
                    <button class="w-full p-2 text-xl text-red-700 border border-red-700 rounded-md hover:opacity-80"
                        @click="openDialog('leaveFeedback', 'open')">Leave
                        Feedback</button>
                    <button class="w-full p-2 text-xl bg-red-700 rounded-lg hover:opacity-80"
                        @click="openDialog('reportBooking', 'open')">Report</button>
                </div>
            </div>
            <div v-if="itemName === 'cancelledItem'"
                class="flex flex-wrap gap-3 p-3 first:[&>*]:w-full last:[&>*]:w-full  [&>*]:w-[49%] [&>*]:p-2 [&>*]:border-2 [&>*]:border-[#D9D9D9]">
                <div>
                    <h2 class="text-lg font-medium sm:text-lg">Task ID</h2>
                    <p class="sm:text-sm">12345</p>
                </div>
                <div>
                    <h2 class="text-lg font-medium sm:text-lg">Pickup Location</h2>
                    <p class="sm:text-sm">123 Main St, Anytown, USA</p>
                </div>
                <div>
                    <h2 class="text-lg font-medium sm:text-lg">Dropoff Location</h2>
                    <p class="sm:text-sm">456 Pine St, Anytown, USA</p>
                </div>
                <div>
                    <h2 class="text-lg font-medium sm:text-lg">Package Details</h2>
                    <p class="sm:text-sm">Size: Small</p>
                    <p class="sm:text-sm">Weight: 1kg</p>
                    <p class="sm:text-sm">Special Instructions: None</p>
                </div>
                <div>
                    <h2 class="text-lg font-medium sm:text-lg">Status</h2>
                    <p class="sm:text-sm">Canceled</p>
                </div>
                <div>
                    <h2 class="text-lg font-medium sm:text-lg">Cancellation Reason</h2>
                    <p class="sm:text-sm">Customer Request</p>
                </div>

            </div>
        </dialog>
        <dialog id="leaveFeedback" class="w-2/3 p-5 rounded-xl ">
            <form @submit.prevent="submitFeedback()">
                <div class="flex items-center justify-between w-full p-3 md:p-1">
                    <h2 class="flex items-center text-3xl font-medium text-red-800">Leave Feedback</h2>
                    <button class="text-3xl size-12" @click="openDialog('leaveFeedback', 'close')">✖</button>
                </div>
                <hr class="w-full border">
                <div class="flex flex-col gap-3 p-3 [&>*]:w-full [&>*]:p-2 [&>*]:border-2 [&>*]:border-[#D9D9D9]">
                    <h2 class="text-lg font-medium sm:text-lg">Feedback</h2>
                    <textarea
                        class="w-full p-2 border-2 border-[#D9D9D9] rounded-md focus:outline-none focus:border-[#D9D9D9] focus:ring-[#D9D9D9] focus:border"
                        v-model="feedback" name="feedback" id="feedback" cols="30" rows="10"></textarea>
                </div>
                <div class="flex gap-3 p-3 [&>*]:w-full [&>*]:p-2 [&>*]:border-[#D9D9D9]">
                    <h2 class="text-lg font-medium text-center sm:text-lg">Rating</h2>
                    <select v-model="rating" name="rating" id="rating"
                        class="w-full p-2 border-2 border-[#D9D9D9] rounded-md focus:outline-none focus:border-[#D9D9D9] focus:ring-[#D9D9D9] focus:border">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">6</option>
                    </select>
                </div>
                <div class="flex p-3 gap-2 text-white justify-end w-full [&>*]:w-[25%]">
                    <button class="w-full p-2 text-red-700 border border-red-700 rounded-md hover:opacity-80">Submit
                        Feedback</button>
                </div>
            </form>
        </dialog>
        <dialog id="reportBooking" class="w-2/3 p-5 rounded-xl ">
            <div class="flex items-center justify-between w-full p-3 md:p-1">
                <h2 class="flex items-center text-3xl font-medium text-red-800">Report Booking</h2>
                <button class="text-3xl size-12" @click="openDialog('reportBooking', 'close')">✖</button>
            </div>
            <hr class="w-full border">
            <div class="flex flex-col gap-3 p-3 [&>*]:w-full [&>*]:p-2 [&>*]:border-2 [&>*]:border-[#D9D9D9]">
                <select name="report" id="report_type" class="text-lg font-medium rounded-md sm:text-lg bg-slate-50"
                    @change="reportBooking">
                    <option disabled selected>Issue Type</option>
                    <option value="packageIssues">Package Issues</option>
                    <option value="deliveryIssues">Delivery Issues</option>
                    <option value="handlingIssues">Handling Issues</option>
                    <option value="serviceIssues">Service Issues</option>
                    <option value="technicalIssues">Technical Issues</option>
                    <option value="customerServiceIssues">Customer Service Issues</option>
                    <option value="productIssues">Product Issues</option>
                    <option value="feedbackAndImprovement">Feedback and Improvement</option>
                    <option value="other">Other</option>
                </select>
                <textarea
                    class="w-full p-2 border-2 border-[#D9D9D9] rounded-md focus:outline-none focus:border-[#D9D9D9] focus:ring-[#D9D9D9] focus:border"
                    name="report" id="report" cols="30" rows="10" placeholder="Describe the issue"></textarea>
                <input type="file" accept="image/png, image/gif, image/jpeg" id="report_file" name="report_file"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-[#630617] dark:border-none dark:placeholder-gray-400"
                    multiple>
            </div>
            <div class="flex p-3 gap-2 text-white justify-end w-full [&>*]:w-[25%]">
                <button class="w-full p-2 text-red-700 border border-red-700 rounded-md hover:opacity-80">Submit
                    Report</button>
            </div>
        </dialog>
        <div class="flex flex-col gap-10 py-3 sm:py-1">
            <h1 class="text-3xl sm:text-lg font-bold text-[#AA0927]">Task List</h1>
            <div class="flex items-center justify-between w-full">
                <p class="text-xl font-bold text-red-950 sm:text-lg">Task List Overview</p>
                <span class="flex gap-2">
                    <button @click="openDialog('searchDialog', 'open')"
                        class="p-2 bg-red-700 rounded-sm hover:scale-105">
                        <i v-html="icons.Search"
                            class="[&>svg]:font-extrabold [&>svg]:size-9 [&>svg]:text-white md:[&>svg]:size-5"></i>
                    </button>
                    <button @click="openDialog('sortDialog', 'open')" class="p-2 bg-red-700 rounded-sm hover:scale-105">
                        <i v-html="icons.Sort"
                            class="[&>svg]:font-extrabold [&>svg]:size-9 [&>svg]:text-white md:[&>svg]:size-5"></i>
                    </button>
                </span>
            </div>
            <div>
                <div class="flex justify-between [&>*]:w-full [&>*]:border [&>*]:p-4">
                    <button @click="viewTableContents('all')"
                        :class="taskTable === 'all' ? 'text-red-500 border-8 border-red-500' : 'text-black'">All</button>
                    <button @click="viewTableContents('pending')"
                        :class="taskTable === 'pending' ? 'text-red-500 border-4 border-red-500' : 'text-black'">Pending</button>
                    <button @click="viewTableContents('ongoing')"
                        :class="taskTable === 'ongoing' ? 'text-red-500 border-4 border-red-500' : 'text-black'">Ongoing</button>
                    <button @click="viewTableContents('completed')"
                        :class="taskTable === 'completed' ? 'text-red-500 border-4 border-red-500' : 'text-black'">Completed</button>
                    <button @click="viewTableContents('cancelled')"
                        :class="taskTable === 'cancelled' ? 'text-red-500 border-4 border-red-500' : 'text-black'">Cancelled</button>
                </div>
                <SRScroll>
                    <div id="Content-Body-Main" class="rounded-lg hover:shadow-md">
                        <SRTable>
                            <template #Table-Header>
                                <th>Item Name</th>
                                <th>Pickup Location</th>
                                <th>Dropoff Location</th>
                                <th>Size</th>
                                <th>Weight</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </template>
                            <template #Table-Body v-if="taskTable === 'pending' || taskTable === 'all'">
                                <tr id="pending" :data-status="item.status" class=" [&>*]:p-4" v-for="item in
                                    pendingDeliveries" :key="item.id">
                                    <td>{{ item.itemName }}</td>
                                    <td>{{ item.senderaddressInfo }}</td>
                                    <td>{{ item.receiveraddressInfo }}</td>
                                    <td>{{ item.height }} ✖ {{ item.width }} ✖ {{ item.length }} <br> {{
                                        item.sizeDropdown }}</td>
                                    <td>{{ item.weight }} {{ item.weightDropdown }}</td>
                                    <td class="capitalize">{{ item.status }}</td>
                                    <td>
                                        <button class="text-sm p-2 rounded-sm text-white bg-[#AA0927] hover:opacity-90"
                                            @click="openBooking('taskDetails', 'pendingItem', 'open', item.trackingNumber)">See
                                            More</button>
                                    </td>
                                </tr>
                                <tr id="ongoing" class="[&>*]:p-4"
                                    v-if="taskTable === 'ongoing' || taskTable === 'all'">
                                    <td>Item Name</td>
                                    <td>Location B</td>
                                    <td>Location C</td>
                                    <td>Medium package</td>
                                    <td>Ongoing</td>
                                    <td>5 days</td>
                                    <td>
                                        <button class="text-sm p-2 rounded-sm text-white bg-[#AA0927] hover:opacity-90"
                                            @click="openBooking('taskDetails', 'ongoingItem', 'open')">See
                                            More</button>
                                    </td>
                                </tr>
                                <tr id="completed" class="[&>*]:p-4"
                                    v-if="taskTable === 'completed' || taskTable === 'all'">
                                    <td>Item Name</td>
                                    <td>Location C</td>
                                    <td>Location D</td>
                                    <td>Medium package</td>
                                    <td>Completed</td>
                                    <td>5 days</td>
                                    <td>
                                        <button class="text-sm p-2 rounded-sm text-white bg-[#AA0927] hover:opacity-90"
                                            @click="openBooking('taskDetails', 'completedItem', 'open')">See
                                            More</button>
                                    </td>
                                </tr>
                                <tr id="canceled" class="[&>*]:p-4"
                                    v-if="taskTable === 'cancelled' || taskTable === 'all'">
                                    <td>Item Name</td>
                                    <td>Location E</td>
                                    <td>Location F</td>
                                    <td>Large package</td>
                                    <td>Cancelled</td>
                                    <td>5 days</td>
                                    <td>
                                        <button class="text-sm p-2 rounded-sm text-white bg-[#AA0927] hover:opacity-90"
                                            @click="openBooking('taskDetails', 'cancelledItem', 'open')">See
                                            More</button>
                                    </td>
                                </tr>
                            </template>
                        </SRTable>
                    </div>
                </SRScroll>
            </div>
        </div>
        <hr class="w-[90%] mx-auto border-dashed border-slate-300 border-t">
        <div class="flex flex-col gap-10 py-3 sm:py-1">
            <h1 class="text-3xl sm:text-lg font-bold text-[#AA0927]">Statistics Overview</h1>
            <div class="flex flex-col w-full">
                <p class="text-xl font-bold text-red-950 sm:text-lg">Summary</p>
                <div
                    class="flex flex-wrap w-full justify-center gap-3.5 sm:gap-2.5 p-3.5 [&>*]:size-64 sm:[&>*]:size-36 [&>*]:border-2 [&>*]:rounded-lg [&>*]:shadow [&>*]:flex [&>*]:flex-col [&>*]:items-center [&>*]:justify-center [&>*]:gap-3.5 [&>*]:p-3.5 [&>*]:text-center [&>*]:bg-white">
                    <div class="hover:shadow-md">
                        <h2 class="text-lg font-bold sm:text-base ">Total Completed Deliveries: </h2>
                        <h2 class="text-xl sm:text-base font-bold text-[#AA0927]">0</h2>
                    </div>
                    <div class="hover:shadow-md">
                        <h2 class="text-lg font-bold sm:text-base ">Total Deliveries: </h2>
                        <h2 class="text-xl sm:text-base font-bold text-[#AA0927]">0</h2>
                    </div>
                    <div class="hover:shadow-md">
                        <h2 class="text-lg font-bold sm:text-base ">Total Pending Deliveries: </h2>
                        <h2 class="text-xl sm:text-base font-bold text-[#AA0927]">{{ pendingDeliveries.length }}
                        </h2>
                    </div>
                    <div class="hover:shadow-md">
                        <h2 class="text-lg font-bold sm:text-base ">Total Ongoing Deliveries: </h2>
                        <h2 class="text-xl sm:text-base font-bold text-[#AA0927]">0</h2>
                    </div>
                    <div class="hover:shadow-md">
                        <h2 class="text-lg font-bold sm:text-base ">Total Cancelled Deliveries: </h2>
                        <h2 class="text-xl sm:text-base font-bold text-[#AA0927]">0</h2>
                    </div>
                    <div class="hover:shadow-md">
                        <h2 class="text-lg font-bold sm:text-base ">Average Delivery Time: </h2>
                        <h2 class="text-xl sm:text-base font-bold text-[#AA0927]">0</h2>
                    </div>
                    <div class="hover:shadow-md">
                        <h2 class="text-lg font-bold sm:text-base ">Rating: </h2>
                        <h2 class="text-xl sm:text-base font-bold text-[#AA0927]">0</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
import icons from "@/assets/icons";
import SRTable from "@/components/SRTable.vue";
import SRScroll from "@/components/SRScroll.vue";
import { addReview } from '@/services/ApiServices';
import { customerRetrieveData } from '@/services/api/customer';
import { db } from '@/services/firebaseConfig';
import { set as rtdbSet, ref as rtdbRef, get as rtdbGet } from 'firebase/database';

const taskTable = ref('all');
const itemName = ref('');
const feedback = ref('');
const rating = ref(0);

function openDialog(dialogName, action) {
    const dialog = document.getElementById(dialogName);
    if (dialog && action === "open") {
        dialog.showModal();
    } else if (dialog && action === "close") {
        dialog.close();
    }
}

let itemData = ref([]);
function openBooking(dialogName, table, state, trackingNumber) {

    itemName.value = table;
    const dialog = document.getElementById(dialogName);
    if (dialog && state === "open") {
        dialog.showModal();
        itemData.value = pendingDeliveries.value.find(item => item.trackingNumber === trackingNumber);
        console.log('Item Data:', itemData.value);
    } else {
        dialog.close();
    }
}

function viewTableContents(table) {
    taskTable.value = table;
}

function submitFeedback() {
    const feedbackData = {
        driver_id: '1',
        customer_id: userId.value,
        comment: feedback.value,
        rating: rating.value,
    }

    addReview(feedbackData).then((result) => {
        if (result.status === 200) {
            console.log('Feedback submitted successfully');
            feedback.value = '';
            rating.value = 0;
            openDialog('feedback-dialog', 'close');
        } else {
            console.log('Failed to submit feedback');
        }
    }).catch((err) => {
        console.error('Error submitting feedback:', err);
    });
}

const userId = ref('');
const pendingDeliveries = ref([]);
async function getData() {
    try {
        const data = await customerRetrieveData();
        userId.value = data.data.cust_userOwner;
        console.log('User ID:', userId.value);
        const pendingRef = rtdbRef(db, `deliveries/${userId.value}/pending`);
        console.log('Pending Ref:', pendingRef);
        if (pendingRef) {
            const snapshot = await rtdbGet(pendingRef);
            console.log('Snapshot:', snapshot);
            if (snapshot.exists()) {
                const pendingData = snapshot.val();
                console.log('Pending Data:', pendingData);
                pendingDeliveries.value = Object.values(pendingData);
                console.log('Pending Deliveries:', pendingDeliveries.value.length);
            } else {
                console.log('No pending deliveries found');
            }
        }
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

watch(pendingDeliveries, () => {
    console.log('WATCH: Pending Deliveries:', pendingDeliveries.value);
});



onMounted(getData);

</script>

<style lang="scss" scoped>
* {
    //border: 1px solid red;
}

.color {
    color: red;
}
</style>