<template>
  <Switch
      :model-value="modelValue"
      @update:modelValue="$emit('update:modelValue', $event)"
      :class="modelValue ? 'bg-blue-500' : 'bg-red-500'"
      class="relative inline-flex items-center justify-between gap-x-1.5 h-6 px-1.5 rounded-full
        transition duration-300 ease-in-out"
  >
    <span v-if="!modelValue" class="ml-1 text-white">RUS</span>

    <span class="inline-block h-4 w-4 rounded-full bg-white" />

    <span v-if="modelValue" class="mr-1 text-white">ENG</span>
  </Switch>
</template>

<script setup>
import { Switch } from '@headlessui/vue';

defineProps({
  modelValue: Boolean,
});
</script>
