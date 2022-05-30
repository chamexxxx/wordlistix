<template>
  <div class="flex flex-col justify-center items-center">
    <img
        v-if="image"
        :src="`/uploads/${image}`"
        alt=""
        class="w-28 h-28 mb-6 object-cover rounded-full"
    >

    <div class="flex flex-col">
      <Word
          v-for="({ languageCode, text }, index) in words"
          :key="index"
          :text="text"
          :language-code="languageCode"
          :hidden="!displayed"
          :active="languageCode === activeLanguageCode"
      />
    </div>
  </div>
</template>

<script setup>
import { inject } from 'vue';
import Word from './Word.vue';

defineProps({
  words: {
    type: Array,
    required: true,
  },
  image: String,
  displayed: Boolean,
});

const activeLanguageCode = inject('activeLanguageCode');
</script>
