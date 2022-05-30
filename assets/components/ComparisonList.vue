<template>
  <RecycleScroller
    :items="items"
    :item-size="145"
    key-field="id"
    class="scroll"
    v-slot="{ item }"
  >
    <div class="pb-3">
      <ComparisonListItem
          :words="item.words"
          :image="item.image"
          :dictionary-name="item.dictionary.name"
      />
    </div>
  </RecycleScroller>
</template>

<script setup>
import { RecycleScroller } from 'vue-virtual-scroller';
import 'vue-virtual-scroller/dist/vue-virtual-scroller.css';
import ComparisonListItem from './ComparisonListItem.vue';

defineProps({
  items: {
    type: Array,
    required: true,
  },
});
</script>
