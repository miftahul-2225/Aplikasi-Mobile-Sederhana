import { createRouter, createWebHistory } from '@ionic/vue-router';
import TabsPage from '../views/TabsPage.vue';
import TabPage4 from '../views/TabsPage4.vue'; 
import TabPage3 from '../views/TabPage3.vue';
import LoginPage from '../views/LoginPage.vue';
import InputLoginPage from '../views/InputLoginPage.vue';

const routes = [
  {
    path: '/',
    redirect: '/tabs/tab4', 
  },
  {
    path: '/tabs/',
    component: TabsPage,
    children: [
      {
        path: '',
        redirect: '/tabs/tab4',
      },
      {
        path: 'tab4', 
        component: TabPage4,
      },
      {
        path: 'tab3',
        component: TabPage3,
      },
    ],
  },
  {
    path: '/login',
    component: LoginPage,
  },
  {
    path: '/input-login',
    component: InputLoginPage,
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

export default router;
