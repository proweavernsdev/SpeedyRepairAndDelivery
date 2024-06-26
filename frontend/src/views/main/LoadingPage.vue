<template>
  <div id="load" class="flex items-center justify-center flex-col h-screen gap-5 bg-[#630617] px-20 md:text-center">
    <div v-if="status === 'approved'">
      <img src=" /src/assets/loading.gif" alt="" srcset="" />
    </div>
    <div v-else-if="status === 'denied'"
      class="flex flex-col text-center gap-5 max-w-[1080px] w-full m-16 p-16 text-[#630617] bg-white rounded-xl">
      <h1 class="my-5 text-2xl font-bold">Account Denied</h1>
      <p class="text-xl font-bold">
        🚫 We regret to inform you that your account application has been
        denied.
      </p>
      <p>
        Our team has carefully reviewed your submission, and unfortunately, we
        are unable to approve your account at this time. We apologize for any
        inconvenience this may cause.
      </p>
      <p>
        If you believe this decision was made in error or have any questions,
        please feel free to
        <span class="font-bold">contact our support team. </span> We appreciate
        your interest and hope to assist you in the future.
      </p>
      <p>
        Thank you for considering us, and we wish you the best in your
        endeavors.
      </p>
      <div class="flex justify-center w-full py-5">
        <p class="p-2 text-sm font-bold text-left md:text-white">
          Already have an account?
          <router-link to="/login">
            <span class="text-[#39030D] active:underline hover:underline md:text-[#AA0927]">
              Login
            </span>
          </router-link>
        </p>
      </div>
    </div>
    <div v-else-if="status === 'pending'"
      class="flex flex-col text-center gap-5 max-w-[1080px] w-full m-16 p-16 text-[#630617] bg-white rounded-xl">
      <h1 class="my-5 text-2xl font-bold">Account Approval Status</h1>
      <p class="text-xl font-bold">🔍 Your Account is Pending Approval</p>
      <p>
        Thank you for registering with us! We appreciate your interest in
        joining our community. However, your account is currently
        <span class="font-bold">under review. </span>Our team is working
        diligently to process all applications.
      </p>
      <p>
        We apologize for any inconvenience and appreciate your understanding.
      </p>
      <p class="font-bold">🌟 Thank you for choosing us!</p>
      <div class="flex justify-center w-full py-5">
        <p class="p-2 text-sm font-bold text-left md:text-white">
          Already have an account?
          <router-link to="/login">
            <span class="text-[#39030D] active:underline hover:underline md:text-[#AA0927]">
              Login
            </span>
          </router-link>
        </p>
      </div>
    </div>

    <div v-else-if="status === 'blocked'"
      class="flex flex-col text-center gap-5 max-w-[1080px] w-full m-16 p-16 text-[#630617] bg-white rounded-xl">
      <h1 class="my-5 text-2xl font-bold">🚫 Account Blocked</h1>
      <p>
        We regret to inform you that your account has been
        <span class="font-bold">temporarily blocked</span> due to a violation of
        our terms of use. Our team has detected suspicious activity associated
        with your account, which prompted this action.
      </p>
      <p class="font-bold">Reasons for Account Blocking:</p>
      <ul>
        <li>
          <span class="font-bold">Malware:</span> Sending intentionally unwanted
          or harmful code or software.
        </li>
        <li>
          <span class="font-bold">Phishing: </span>Attempting to steal private
          information from others by tricking or spoofing them.
        </li>
        <li>
          <span class="font-bold">Interfering with Microsoft networks:</span>
          Harming or spoofing our systems.
        </li>
      </ul>
      <p class="font-bold">Next Steps:</p>
      <ol>
        <li>
          <span class="font-bold">Contact Support:</span> If you believe this
          decision was made in error, please
          <span class="font-bold">contact our support team</span> for further
          assistance.
        </li>
        <li>
          <span class="font-bold">Unlock Process:</span> To unlock your account,
          sign in to receive a security code. You can use any phone number to
          request the code, even if it’s not associated with your account. Once
          unlocked, you may need to create a new password.
        </li>
      </ol>
      <p>
        We apologize for any inconvenience and appreciate your understanding.
        Thank you for choosing us, and we hope to resolve this situation
        promptly.
      </p>
      <div class="flex justify-center w-full py-5">
        <p class="p-2 text-sm font-bold text-left md:text-white">
          Already have an account?
          <router-link to="/login">
            <span class="text-[#39030D] active:underline hover:underline md:text-[#AA0927]">
              Login
            </span>
          </router-link>
        </p>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { retrieveData  } from '@/services/ApiServices.js';
import { userRetrieveData } from "@/services/api/customer.js";
import { driverRetrieveData } from '@/services/api/driver.js';
import { customerRetrieveData } from '@/services/api/customer.js';
import { compRetrieveData } from '@/services/api/company.js';

const router = useRouter();
let accessLevelNumber = ref("");
let information = ref("");
let status = ref("");
let userType = ref("");

// On component mounted, retrieve data and handle based on user access level
onMounted(() => {
  try {
    const promise = retrieveData();
    promise
      .then((data) => {
        console.info("data: ", data);
        const level = JSON.stringify(data.data.UserAccess);
        accessLevelNumber.value = level;
        console.info("level: ", level);
        console.info(localStorage.getItem("token"));
        if (level === 'null') {
          router.push({
            path: "/access-level",
            query: {
              marker: btoa(data.data.UserID),
              email: btoa(data.data.Email),
              level: btoa(data.data.UserAccess),
              company: btoa(data.data.Company),
            },
          });
        } else {
          switch (level) {
            case '"0"':
              userType.value = "Super Admin";
              router.push(`/admin/dashboard`);
              break;
            case '"1"':
              userType.value = "Admin";
              router.push(`/admin/dashboard`);
              break;
            case '"2"':
              compRetrieveData().then((dat) => {
                information.value = dat.result;
                if (information.value.status === "approved") {
                  status.value = information.value.status;
                  userType.value = "Company";
                  router.push(`/company/dashboard/`);
                } else if (information.value.status === "denied") {
                  status.value = information.value.status;
                } else if (information.value.status === "blocked") {
                  status.value = information.value.status;
                } else if (information.value.status === "pending") {
                  status.value = information.value.status;
                } else {
                  router.push(`/company/dashboard/`);
                }
              });
              break;
            case '"3"':
              userRetrieveData().then((dat) => {
                // customerRetrieveData().then((dat) => {
                information.value = dat.data;
                userType.value = "Customer"; //Use this in case of emergency
                router.push(`/customer/dashboard/`);
              });
              break;

            case '"4"':
              driverRetrieveData().then((dat) => {
                information.value = dat.result;
                if (information.value.status === "approved") {
                  status.value = information.value.status;
                  userType.value = "Driver";
                  router.push(`/rider/dashboard`);
                } else if (information.value.status === "denied") {
                  status.value = information.value.status;
                } else if (information.value.status === "blocked") {
                  status.value = information.value.status;
                } else if (information.value.status === "pending") {
                  status.value = information.value.status;
                } else {
                  router.push(`/rider/dashboard`);
                }
              });
              break;

            case '"5"':
              userType.value = "Company Employee";
              router.push(`/company/user/dashboard/`);
              break;

            default:
              const level = JSON.stringify(data.data.data.UserAccess);
              console.log(level);
              if (level === '"0"') {
                userType.value = "Super Admin";
                router.push(`/admin/dashboard`);
                break;
              } else if (level === '"1"') {
                userType.value = "Admin";
                router.push(`/admin/dashboard`);
                break;
              } else {
                router.push(`/ErrorPage.vue`);
                break;
              }
          }
        }
      })
      .catch((error) => {
        console.error("Error fetching data:", error);
      });
  } catch (error) {
    console.error("Error:", error);
  }
});
</script>
<style lang="scss" scoped></style>
