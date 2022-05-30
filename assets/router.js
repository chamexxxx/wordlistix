import { createRouter, createWebHistory } from 'vue-router';

const routes = [
  {
    path: '/',
    name: 'Dictionaries',
    component: () => import('./pages/Dictionaries.vue'),
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
