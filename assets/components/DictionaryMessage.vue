<template>
  <span class="text-center text-lg text-zinc-800">
    Текущий словарь: {{ dictionaryName }} ({{ comparisonsLength }}
    {{ declineWord(comparisonsLength, ['слово', 'слова', 'слов']) }})
  </span>
</template>

<script setup>
import { declineWord } from '../helpers';

defineProps({
  dictionaryName: {
    type: String,
    required: true,
  },
  comparisonsLength: {
    type: Number,
    required: true,
  },
});
</script>
