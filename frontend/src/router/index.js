import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    // MAIN PAGES
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/main/LoginPage.vue')
    },

    {
      path: '/',
      name: 'landing',
      component: () => import('../views/main/LoginPage.vue')
    },
    {
      path: '/access-level',
      name: 'accesslevel',
      component: () => import('../views/main/AdditionalInfoPage.vue')
    },
    {
      path: '/reset',
      name: 'reset',
      component: () => import('../views/main/PasswordResetEmail.vue')
    },
    {
      path: '/load',
      name: 'load',
      component: () => import('../views/main/LoadingPage.vue')
    },
    {
      path: '/change-password',
      name: 'changepassword',
      component: () => import('../views/main/PasswordResetPage.vue')
    },
    {
      path: '/otp',
      name: 'otp',
      component: () => import('../views/users/SignupwithOTPPageUsers.vue')
    },
    {
      path: '/password-reset-success',
      name: 'passwordresetsuccess',
      component: () => import('../views/main/PasswordResetCongratulations.vue')
    },

    //SIGN UP PAGES
    {
      path: '/company/signup',
      name: 'signup_company',
      component: () => import('../views/company/SignupPageCompany.vue')
    },
    {
      path: '/signup',
      name: 'signup_users',
      component: () => import('../views/users/SignupPageUsers.vue')
    },

    // DASHBOARD PAGES
    {
      path: '/admin/dashboard',
      name: 'admin/dashboard',
      component: () => import('../views/admin/DashboardView.vue')
    },
    {
      path: '/company/dashboard/:id',
      name: 'company/dashboard',
      component: () => import('../views/admin/DashboardView.vue')
    },
    {
      path: '/customer/dashboard',
      name: 'customer/dashboard',
      component: () => import('../views/users/DashboardView.vue')
    },
    {
      path: '/rider/dashboard/:id',
      name: 'rider/dashboard',
      component: () => import('../views/driver/DashboardView.vue')
    },
    {
      path: '/company/user/dashboard/:id',
      name: 'company_user/dashboard',
      component: () => import('../views/admin/DashboardView.vue')
    },

    // ADMIN PAGES
    {
      path: '/admin/dashboard',
      name: 'admin/dashboard',
      component: () => import('../views/admin/DashboardView.vue')
    },
    {
      path: '/admin/account',
      name: 'admin/account',
      component: () => import('../views/admin/AccountManagement.vue')
    },
    {
      path: '/admin/manage/customer',
      name: 'admin/manage/customer',
      component: () => import('../views/admin/CustomerManagement.vue')
    },
    {
      path: '/admin/manage/company',
      name: 'admin/manage/company',
      component: () => import('../views/admin/CompanyManagement.vue')
    },
    {
      path: '/admin/manage/riders',
      name: 'admin/manage/riders',
      component: () => import('../views/admin/DeliveryRiders.vue')
    },
    {
      path: '/admin/customization/taxonomies',
      name: 'admin/customization/taxonomies',
      component: () => import('../views/admin/CustomizationTaxonomies.vue')
    },
    {
      path: '/admin/customization/fees',
      name: 'admin/customization/fees',
      component: () => import('../views/admin/CustomizationFees.vue')
    },
    {
      path: '/admin/customization/requestpriority',
      name: 'admin/customization/requestpriority',
      component: () => import('../views/admin/CustomizationRequestPriority.vue')
    },
    {
      path: '/admin/reports',
      name: 'admin/reports',
      component: () => import('../views/admin/ReportsView.vue')
    },
    {
      path: '/admin/bookings',
      name: 'admin/bookings',
      component: () => import('../views/admin/RequestReport.vue')
    },
    {
      path: '/admin/delivery',
      name: 'admin/delivery',
      component: () => import('../views/admin/DeliveryService.vue')
    },
    // COMPANY PAGES
    {
      path: '/company/account/:id',
      name: 'company/account',
      component: () => import('../views/company/AccountManagement.vue')
    },
    {
      path: '/company/manage/employees/:id',
      name: 'company/manage/employees',
      component: () => import('../views/company/EmployeesManagement.vue')
    },

    {
      path: '/company/bookings',
      name: 'company/bookings',
      component: () => import('../views/company/TaskHistory.vue')
    },

    //CUSTOMER PAGES
    {
      path: '/customer/dashboard',
      name: 'customer/dashboard',
      component: () => import('../views/users/DashboardView.vue')
    },
    {
      path: '/customer/account',
      name: 'customer/account',
      component: () => import('../views/users/AccountManagement.vue')
    },
    {
      path: '/customer/delivery',
      name: 'customer/delivery',
      component: () => import('../views/users/DeliveryService.vue')
    },

    {
      path: '/customer/history',
      name: 'customer/history',
      component: () => import('../views/users/TaskHistory.vue')
    },

    //RIDER PAGES
    {
      path: '/rider/dashboard',
      name: 'rider/dashboard',
      component: () => import('../views/driver/DashboardView.vue')
    },

    {
      path: '/rider/account',
      name: 'rider/account',
      component: () => import('../views/driver/AccountManagement.vue')
    },

    {
      path: '/rider/requests',
      name: 'rider/requests',
      component: () => import('../views/driver/RequestsPage.vue')
    },

    {
      path: '/rider/requests/:id',
      name: 'rider/requests/:id',
      component: () => import('../views/driver/DeliveryItem.vue')
    },

    {
      path: '/rider/requests/:id/track',
      name: 'rider/requests/track',
      component: () => import('../views/driver/ItemAccepted.vue')
    },

    {
      path: '/rider/requests/:id/success',
      name: 'rider/requests/success',
      component: () => import('../views/driver/ItemDelivered.vue')
    },

    {
      path: '/rider/tasks',
      name: 'rider/tasks',
      component: () => import('../views/driver/TaskHistory.vue')
    },


    //ERROR PAGES
    // {
    //   path: '/',
    //   name: 'Home',
    //   component: () => import('../views/main/LoginPage.vue')
    // },
    // {
    //   path: '/test',
    //   name: 'Home',
    //   component: () => import('../views/tests/TestView.vue')
    // },
    // {
    //   path: '/test2',
    //   name: 'test2',
    //   component: () => import('../views/tests/NewTest.vue')
    // },
    // {
    //   path: '/modal-test',
    //   name: 'modal-test',
    //   component: () => import('../views/tests/ModalTest.vue')
    // },
    // ERROR PAGE
    {
      path: '/:pathMatch(.*)*',
      name: 'error',
      component: () => import('../views/main/ErrorPage.vue')
    }
  ]
})

export default router
