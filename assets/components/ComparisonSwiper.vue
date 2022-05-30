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
    >
      <ComparisonSlide
          :words="words"
          :image="image"
          :displayed="displayed"
      />
    </SwiperSlide>

    <template v-slot:container-end>
      <div>
        <slot name="container-end" />
      </div>
    </template>
  </Swiper>
</template>

<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import ComparisonSlide from './ComparisonSlide.vue';

defineProps({
  comparisons: {
    type: Array,
    required: true,
  },
});
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
