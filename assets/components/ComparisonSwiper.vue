<template>
  <Swiper
      ref="swiper"
      class="w-full h-full overflow-y-auto select-none"
      :allowTouchMove="false"
      :allowSlidePrev="false"
      :auto-height="true"
      loop
  >
    <SwiperSlide
        v-for="({ words, image, displayed }, index) in comparisons"
        :key="index"
        class="flex flex-col justify-center items-center"
    >
      <img
          v-if="image"
          :src="`/uploads/${image}`"
          alt=""
          class="w-28 h-28 mb-6 object-cover rounded-full"
      >

      <div class="flex flex-col">
        <Word
            v-for="({ languageCode, text }, index) in words"
            :key="index"
            :text="text"
            :language-code="languageCode"
            :hidden="!displayed"
            :active="languageCode === activeLanguageCode"
        />
      </div>
    </SwiperSlide>

    <template v-slot:container-end>
      <div>
        <slot name="container-end" />
      </div>
    </template>
  </Swiper>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import { Swiper, SwiperSlide, useSwiper } from 'swiper/vue';
import Word from './Word.vue';

defineProps({
  comparisons: {
    type: Array,
    required: true,
  },
  activeLanguageCode: {
    type: String,
    required: true,
  },
});

const route = useRoute();
const swiper = ref(null);
</script>

<style>
.swiper-wrapper {
  align-items: center;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
