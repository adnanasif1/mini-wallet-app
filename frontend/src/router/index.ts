import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/LoginView.vue';
import Dashboard from '../views/DashboardView.vue';
import { useAuthStore } from '../stores/auth';

const routes = [
  { path: '/', redirect: '/dashboard' },
  { path: '/login', component: Login },
  { path: '/dashboard', component: Dashboard, meta: { requiresAuth: true } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();
  if (to.meta.requiresAuth && !authStore.token) return next('/login');
  if (to.path === '/login' && authStore.token) return next('/dashboard');
  next();
});

export default router;
