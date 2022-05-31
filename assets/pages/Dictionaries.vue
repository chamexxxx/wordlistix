<template>
  <div class="flex flex-col w-full h-96 my-10">
    <div v-if="store.dictionariesAreLoading" class="flex justify-center items-center h-full">
      <PixelSpinner />
    </div>

    <div v-else class="flex flex-col items-center max-w-xl w-full">
      <Card class="w-full max-h-96 h-full p-3">
        <DictionaryList
            v-if="store.dictionaries.length > 0"
            :items="store.dictionaries"
        />

        <div
            v-else
            class="flex flex-col justify-center items-center h-full py-5"
        >
          <BookOpenIcon class="h-16 w-16 text-gray-500" />

          <p class="mt-3 font-medium">Не найдено ни одного словаря</p>

          <Button
              primary
              class="mt-5"
              @click="dialogIsOpen = true"
          >
            Загрузить словарь
          </Button>
        </div>
      </Card>

      <Button
          v-if="store.dictionaries.length > 0"
          opacity
          class="mt-6"
          @click="dialogIsOpen = true"
      >
        Загрузить словарь
      </Button>
    </div>
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
import { useStore } from '../store';
import Card from '../components/base/Card.vue';
import Button from '../components/base/Button.vue';
import Dialog from '../components/base/Dialog.vue';
import DictionaryUploadForm from '../components/DictionaryUploadForm.vue';
import PixelSpinner from '../components/base/PixelSpinner.vue';
import DictionaryList from '../components/DictionaryList.vue';

const store = useStore();
const dialogIsOpen = ref(false);
</script>
