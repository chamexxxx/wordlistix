<template>
  <div
      v-if="store.comparisonsAreLoading"
      class="flex justify-center items-center"
      style="min-height: 400px"
  >
    <PixelSpinner />
  </div>

  <Card v-else class="max-w-lg w-full my-10 p-5" style="max-height: 600px">
    <template v-if="store.comparisons.length > 0">
      <SearchField
          v-model="search"
          placeholder="Поиск по словам"
          class="mb-5"
      />

      <ComparisonList
          :items="filteredComparisons"
          class="pr-3"
      />
    </template>

    <DictionaryEmptyState
        v-else
        message="Не найдено ни одного слова"
    />
  </Card>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useStore } from '../store';
import Card from '../components/base/Card.vue';
import SearchField from '../components/base/SearchField.vue';
import ComparisonList from '../components/ComparisonList.vue';
import PixelSpinner from '../components/base/PixelSpinner.vue';
import DictionaryEmptyState from '../components/DictionaryEmptyState.vue';

const store = useStore();
const { fetchComparisonList, getComparisons } = store;

const search = ref(null);

const filteredComparisons = computed(() => getComparisons(search.value));

onMounted(async () => {
  await fetchComparisonList();
});
</script>
