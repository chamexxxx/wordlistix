<template>
  <div class="flex justify-between px-5 py-4 bg-gray-100 rounded-md">
    <div>
      <p
          v-for="({ languageCode, text }, index) in words"
          :key="index"
          class="leading-8"
      >
        {{ text }}

        <span class="ml-1 px-1 py-0.5 text-xs text-blue-600 bg-blue-200 rounded-sm">
          {{ languageCode }}
        </span>
      </p>

      <hr class="my-2">

      <p class="text-sm text-gray-500">
        {{ dictionaryName }}
      </p>
    </div>

    <img v-if="image"
         :src="`/uploads/${image}`"
         class="w-20 h-20 object-cover rounded-full"
         alt=""
    >
  </div>
</template>

<script setup>
defineProps({
  words: {
    type: Array,
    required: true,
  },
  image: {
    type: String,
    required: true,
  },
  dictionaryName: {
    type: String,
    required: true,
  },
});
</script>
