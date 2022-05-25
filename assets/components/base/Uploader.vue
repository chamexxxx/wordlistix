<template>
  <div>
    <p v-if="label" class="block mb-2.5 text-sm font-medium text-gray-900">
      {{ label }}
    </p>

    <label
        @dragover.prevent
        @drop.prevent="onDrop"
        @dragenter.prevent="dragged = true"
        @dragleave.prevent="dragged = false"
        :class="[
        'uploader flex flex-col justify-center items-center h-44 w-full border border-gray-300',
        'bg-gray-50 text-gray-900 rounded-lg p-2.5 py-5 leading-6 cursor-pointer',
        'hover:bg-gray-100 border-1.5 border-gray-300 border-dashed',
        'focus:outline outline-offset-2 outline-1 outline-blue-500',
        { '!bg-gray-100 text-white': dragged, '!bg-red-100 border border-red-500': !valid }
      ]"
    >
      <template v-if="!uploadedFile">
        <UploadIcon class="h-8 w-8 mt-2" />

        <span class="mt-3 mb-1 px-3 py-1 text-center">
        Нажмите или перетащите файл в эту область
      </span>

        <span v-if="message" class="text-sm text-gray-500">
          {{ message }}
        </span>
      </template>

      <template v-else>
        <ArchiveIcon class="h-8 w-8 mt-2" />

        <span class="mt-3 mb-1 px-3 py-1 text-center">
        Файл загружен
      </span>
      </template>

      <input type="file" class="invisible" @change="onFileChanged">
    </label>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { UploadIcon, ArchiveIcon } from '@heroicons/vue/outline';

defineProps({
  label: String,
  message: String,
  valid: {
    type: Boolean,
    default: true,
  },
});

const emit = defineEmits(['upload']);

const uploadedFile = ref(null);
const dragged = ref(false);

const onDrop = ({ dataTransfer }) => {
  const { files } = dataTransfer;
  const [file] = files;

  uploadedFile.value = file;

  console.log('drop', file);
};

const onFileChanged = (event) => {
  const { files } = event.target;
  const [file] = files;

  uploadedFile.value = file;

  emit('upload', file);
};
</script>

<style>
.uploader * {
  pointer-events: none;
}
</style>
