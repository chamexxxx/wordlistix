<template>
  <div class="min-h-screen flex flex-col items-center px-5 pt-24 pb-10
    bg-gradient-to-r from-cyan-400 to-sky-500">
    <h1 class="mb-10 text-5xl text-white text-center">
      wordlistix
    </h1>

    <NavTabs :links="routerLinks" />

    <RouterView />
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useStore } from './store';
import NavTabs from './components/base/NavTabs.vue';

const routerLinks = [];
</script>
