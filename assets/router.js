import { createRouter, createWebHistory } from 'vue-router';

const routes = [
  {
    path: '/',
    name: 'Dictionaries',
    component: () => import('./pages/Dictionaries.vue'),
  },
  {
    path: '/dictionaries/:id',
    name: 'Dictionary',
    component: () => import('./pages/Dictionary.vue'),
    props: (route) => ({ dictionaryId: route.params.id }),
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
