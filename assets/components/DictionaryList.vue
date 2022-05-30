<template>
  <div class="pr-2 overflow-y-auto scroll">
    <RouterLink
        v-for="({ id, name }, index) in items"
        :to="{ name: 'Dictionary', params: { id } }"
        :key="index"
        class="block w-full mb-2 last:mb-0 px-5 py-3 bg-white rounded-md cursor-pointer
                hover:bg-gray-100 active:bg-gray-200"
    >
      <h3 class="font-medium leading-5">
        {{ name }}
      </h3>
    </RouterLink>
  </div>
</template>

<script setup>
defineProps({
  items: {
    type: Array,
    required: true,
  },
});
</script>
