<template>
  <div>
    <label
        v-if="label"
        :for="id"
        class="block mb-2.5 text-sm font-medium text-gray-900"
    >
      {{ label }}
    </label>

    <div :class="[
        'relative bg-gray-50 border border-gray-300 rounded-lg overflow-hidden',
        'focus-within:outline outline-offset-2 outline-2 outline-blue-500',
        { '!bg-red-100 border border-red-500': !valid }
    ]">
      <div
          v-if="$slots.prepend"
          class="absolute h-5 w-5 absolute top-1/2 left-3
           transform -translate-y-1/2 pointer-events-none"
      >
        <slot name="prepend" />
      </div>

      <input
          :id="id"
          :type="type"
          :placeholder="placeholder"
          :value="modelValue"
          :class="[
              'w-full h-full p-2.5 text-gray-900 text-sm bg-inherit outline-none',
              { 'pl-12': $slots.prepend, 'pr-12': $slots.append },
          ]"
          @input="$emit('update:modelValue', $event.target.value)"
      >

      <div
          v-if="$slots.append"
          class="absolute h-5 w-5 absolute top-1/2 right-3
           transform -translate-y-1/2 pointer-events-none"
      >
        <slot name="append" />
      </div>
    </div>

    <p v-if="!valid" class="mt-2 text-red-500 text-xs italic">
      {{ errorMessage }}
    </p>
  </div>
</template>

<script setup>

defineProps({
  id: String,
  type: String,
  label: String,
  placeholder: String,
  modelValue: String,
  valid: {
    type: Boolean,
    default: true,
  },
  errorMessage: String,
});

defineEmits(['update:modelValue']);

</script>
