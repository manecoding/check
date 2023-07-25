import { createRouter, createWebHistory } from 'vue-router'

// Import your components for each route
import main from '../pages/public.vue'
import dashboard from '../pages/dashboard.vue'
import detail from '../pages/detail.vue';
import payment from '../pages/payment.vue';
import adminDashboard from '../pages/admin/adminDashboard.vue';
import detailChecked from '../pages/admin/detailChecked.vue';

const routes = [
    {
    path: '/',
    component: main,
    children: [
      {
        path: '/',
        name: 'dashboard',
        component: dashboard,
      },
      {
        path: '/detail/:id',
        name: 'detail',
        component: detail,
      },
      {
        path: '/payment/:id',
        name: 'payment',
        component: payment,
      },
      {
        path: 'admin/dashboard',
        name: 'adminDashboard',
        component: adminDashboard,
      },
      {
        path: 'admin/detail',
        name: 'detailChecked',
        component: detailChecked,
      },
    ],
  },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router