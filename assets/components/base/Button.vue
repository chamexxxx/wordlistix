<template>
  <button :class="[
      'px-3 py-2 text-center text-sm font-medium rounded-lg',
      'transition transform hover:scale-110',
      'disabled:opacity-50 disabled:transform-none',
      'focus:outline-none focus-visible:border-indigo-500 focus-visible:ring-2',
      'focus-visible:ring-white focus-visible:ring-opacity-75',
      'focus-visible:ring-offset-2',
      'focus-visible:ring-offset-orange-300',
      styles
  ]">
    <slot />
  </button>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  primary: Boolean,
  secondary: Boolean,
  opacity: Boolean,
});

const styles = computed(() => {
  if (props.primary) {
    return 'bg-blue-500 text-white';
  }

  if (props.secondary) {
    return 'bg-blue-100 text-blue-700 border border-blue-400';
  }

  if (props.opacity) {
    return `bg-black bg-opacity-20 text-white hover:bg-opacity-30
      focus:outline-none active:bg-opacity-40`;
  }

  return null;
});
</script>
