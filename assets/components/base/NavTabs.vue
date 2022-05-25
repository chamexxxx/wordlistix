<template>
  <div class="flex justify-center max-w-sm w-full">
    <RouterLink
        v-for="({ to, label }, index) in links"
        :key="index"
        :to="to"
        class="py-2 px-4 text-black/70 font-medium border-b-4 border-black/20"
        active-class="!text-white font-medium !border-white"
    >
      {{ label }}
    </RouterLink>
  </div>
</template>

<script setup>
defineProps({
  links: {
    type: Array,
    required: true,
  },
});
</script>
