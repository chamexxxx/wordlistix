<template>
  <Switch
      v-model="enabled"
      :class="enabled ? 'bg-blue-500' : 'bg-red-500'"
      class="relative inline-flex items-center justify-between gap-x-1.5 h-6 px-1.5 rounded-full
        transition duration-300 ease-in-out"
  >
    <span v-if="enabled" class="ml-1 text-white">
      {{ languageCodes[0] }}
    </span>

    <span class="inline-block h-4 w-4 rounded-full bg-white" />

    <span v-if="!enabled" class="mr-1 text-white">
      {{ languageCodes[1] }}
    </span>
  </Switch>
</template>

<script setup>
import { ref, watch } from 'vue';
import { Switch } from '@headlessui/vue';

const props = defineProps({
  modelValue: String,
  languageCodes: {
    type: Array,
    required: true,
    validator: (codes) => codes.length === 2,
  },
});

const emit = defineEmits(['update:modelValue']);

const enabled = ref(null);

watch(() => props.modelValue, (value) => {
  enabled.value = value === props.languageCodes[0];
}, { immediate: true });

watch(enabled, (value) => {
  emit('update:modelValue', props.languageCodes[value ? 0 : 1]);
});
</script>
