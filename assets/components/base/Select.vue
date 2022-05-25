<template>
  <Listbox
      :model-value="modelValue"
      @update:modelValue="onUpdate"
      class="cursor-pointer"
  >
    <div class="relative z-10">
      <ListboxButton
          class="relative w-full rounded-lg text-white py-2 pl-3 pr-10 text-left
            focus:outline-none focus-visible:border-indigo-500 focus-visible:ring-2
            focus-visible:ring-white focus-visible:ring-opacity-75
            focus-visible:ring-offset-2
            focus-visible:ring-offset-orange-300 sm:text-sm bg-black bg-opacity-20
            font-medium transition hover:scale-110 hover:bg-opacity-30"
      >
        <span class="block truncate">
          {{ modelValue.name }}
        </span>

        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
          <SelectorIcon class="h-5 w-5 text-white" aria-hidden="true" />
        </span>
      </ListboxButton>

      <transition
          leave-active-class="transition duration-100 ease-in"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
      >
        <ListboxOptions
            class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1
              text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none
              sm:text-sm scroll"
        >
          <ListboxOption
              v-slot="{ active, selected }"
              v-for="item in items"
              :key="item.id"
              :value="item"
              as="template"
          >
            <li :class="[
                active ? 'bg-blue-100 text-blue-900' : 'text-gray-900',
                'relative select-none py-2 pl-10 pr-4'
            ]">
              <span :class="[
                  selected ? 'font-medium' : 'font-normal',
                  'block truncate'
              ]">
                {{ item.name }}
              </span>

              <span
                  v-if="selected"
                  class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-600"
              >
                  <CheckIcon class="h-5 w-5" aria-hidden="true" />
              </span>
            </li>
          </ListboxOption>
        </ListboxOptions>
      </transition>
    </div>
  </Listbox>
</template>

<script setup>
import { ref } from 'vue';
import {
  Listbox,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from '@headlessui/vue';
import { CheckIcon, SelectorIcon } from '@heroicons/vue/solid';

const props = defineProps({
  items: {
    type: Array,
    required: true,
  },
  modelValue: Object,
});

const emit = defineEmits(['update:modelValue']);

const onUpdate = (selectedItem) => {
  emit('update:modelValue', selectedItem);
};
</script>
