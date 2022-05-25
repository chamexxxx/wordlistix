<template>
  <Field>
    <template #append>
      <SearchIcon />
    </template>
  </Field>
</template>

<script setup>
import { SearchIcon } from '@heroicons/vue/outline';
import Field from './Field.vue';
</script>
