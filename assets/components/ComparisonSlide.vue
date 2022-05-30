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
          v-for="({ languageCode, text }, index) in sortedWords"
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
import { computed, inject } from 'vue';
import Word from './Word.vue';

const props = defineProps({
  words: {
    type: Array,
    required: true,
  },
  image: String,
  displayed: Boolean,
});

const activeLanguageCode = inject('activeLanguageCode');

const sortedWords = computed(() => {
  const firstWord = props.words.find(
    ({ languageCode }) => languageCode === activeLanguageCode.value,
  );

  return [
    firstWord,
    ...props.words.filter(
      ({ languageCode }) => languageCode !== activeLanguageCode.value,
    ),
  ];
});
</script>
