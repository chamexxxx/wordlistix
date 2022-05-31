<template>
  <div class="flex flex-col justify-center items-center h-full py-5">
    <BookOpenIcon class="h-16 w-16 text-gray-500" />

    <p class="mt-3 font-medium">
      {{ message }}
    </p>

    <Button
        primary
        class="mt-5"
        @click="dialogIsOpen = true"
    >
      Загрузить словарь
    </Button>
  </div>

  <Dialog v-model="dialogIsOpen">
    <template #title>
      Загрузить словарь
    </template>

    <DictionaryUploadForm
        @cancel="dialogIsOpen = false"
        @save="dialogIsOpen = false"
    />
  </Dialog>
</template>

<script setup>
import { ref } from 'vue';
import { BookOpenIcon } from '@heroicons/vue/outline';
import Button from './base/Button.vue';
import Dialog from './base/Dialog.vue';
import DictionaryUploadForm from './DictionaryUploadForm.vue';

defineProps({
  message: {
    type: String,
    required: true,
  },
});

const dialogIsOpen = ref(false);
</script>
