<template>
  <div
      :class="[
          'my-2 first:mt-0 last:mb-0 px-5 py-1 text-lg text-center',
          'bg-gray-100 rounded-lg transition',
          { 'active:bg-gray-200 cursor-pointer': active || !hidden }
      ]"
      @click="(active || !hidden) && speak()"
  >
    <Transition name="fade" mode="out-in" appear>
      <span v-if="!active && hidden">
        ???
      </span>

      <span v-else>
        {{ text }}
      </span>
    </Transition>
  </div>
</template>

<script setup>
import { useSpeechSynthesis } from '@vueuse/core';
import { computed, toRefs } from 'vue';
import languageCodes from '../language-codes';

const props = defineProps({
  languageCode: {
    type: String,
    required: true,
  },
  text: {
    type: String,
    required: true,
  },
  hidden: Boolean,
  active: Boolean,
});

const { text } = toRefs(props);

const lang = computed(() => {
  // eslint-disable-next-line no-shadow
  const { '639-1': lang } = languageCodes.find(
    ({ '639-3': code }) => props.languageCode.toLowerCase() === code,
  );

  return lang;
});

const { speak } = useSpeechSynthesis(text, { lang });
</script>
