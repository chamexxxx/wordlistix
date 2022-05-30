<template>
  <Form>
    <Field
        v-model="dictionaryName"
        label="Название словаря"
        placeholder="Internet and network"
        :valid="!errors.name"
        :error-message="errors.name && errors.name[0]"
    />

    <Uploader
        label="Словарь"
        message="Файл должен быть в формате CSV"
        @upload="onDictionaryFileUpload"
        :valid="!errors.dictionary"
        :error-message="errors.dictionary && errors.dictionary[0]"
    />

    <Uploader
        label="Архив с изображениями"
        message="Файл должен быть в формате zip"
        @upload="onImageArchiveUpload"
        :valid="!errors.images"
        :error-message="errors.images && errors.images[0]"
    />

    <div class="mt-4">
      <div class="flex justify-end items-center mt-6">
        <Button class="mr-6" secondary @click="onCancelButtonClick">
          Отмена
        </Button>

        <Button primary @click="onSaveButtonClick">
          Сохранить
        </Button>
      </div>
    </div>
  </Form>
</template>

<script setup>
import { ref } from 'vue';
import Form from './base/Form.vue';
import Field from './base/Field.vue';
import Uploader from './base/Uploader.vue';
import Button from './base/Button.vue';
import { useStore } from '../store';

const emit = defineEmits(['cancel', 'save']);

const store = useStore();
const { uploadDictionary } = store;

const dictionaryName = ref(null);
const dictionaryFile = ref(null);
const imageArchive = ref(null);

const errors = ref({});

const save = () => uploadDictionary({
  name: dictionaryName.value,
  dictionary: dictionaryFile.value,
  images: imageArchive.value,
})
  .catch((error) => {
    const { data } = error.response;

    errors.value = data;

    throw error;
  });

const onDictionaryFileUpload = (file) => {
  dictionaryFile.value = file;

  if (!dictionaryName.value) {
    dictionaryName.value = file.name.replace(/\.[^/.]+$/, '');
  }
};

const onImageArchiveUpload = (file) => {
  imageArchive.value = file;
};

const onCancelButtonClick = () => emit('cancel');

const onSaveButtonClick = async () => {
  await save();
  emit('save');
};
</script>
