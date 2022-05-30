<template>
  <Dialog v-model="isOpen">
    <template #title>
      Загрузить словарь
    </template>

    <DictionaryUploadForm @cancel="closeModal" @save="closeModal" />
  </Dialog>

  <div class="flex flex-col max-w-md w-full">
    <div
        v-if="store.dictionaryIsLoading || store.dictionariesAreLoading"
         class="flex justify-center items-center my-10"
         style="min-height: 410px"
    >
      <PixelSpinner />
    </div>

    <template v-else>
      <div v-if="currentDictionary" class="flex justify-between items-center mt-10">
        <Select
            :modelValue="currentDictionary"
            :items="store.dictionaries"
            class="w-5/12"
            @update:modelValue="onChangeDictionary"
        />

        <Button class="w-5/12" opacity @click="openModal">
          Загрузить словарь
        </Button>
      </div>

      <template v-if="currentDictionary?.comparisons">
        <Card class="max-w-sm mx-auto my-10 pt-3" style="min-height: 410px">
          <div class="flex justify-between mt-2 mb-5 px-8">
            <LanguageSwitch
                :language-codes="languageCodes"
                v-model="languageCodeEnabled"
                @update:modelValue="onLanguageCodeChanged"
            />

            <span class="text-sm text-gray-600">
              {{ activeSlideIndex + 1 }}/{{ currentDictionary.comparisons.length }}
            </span>
          </div>

          <ComparisonSwiper
              class="px-8 p-5"
              :comparisons="currentDictionary?.comparisons"
              @swiper="onSwiper"
              @slideChange="realIndexChange"
          >
            <template #container-end>
              <hr class="my-5">

              <div class="flex justify-between items-center">
                <Button
                    secondary
                    :disabled="!(currentComparison && !currentComparison?.displayed)"
                    @click="onShowTranslationButtonClick"
                >
                  Показать перевод
                </Button>

                <NextWordButton secondary />
              </div>
            </template>
          </ComparisonSwiper>
        </Card>

        <DictionaryMessage
            :dictionary-name="currentDictionary.name"
            :comparisons-length="currentDictionary.comparisons.length"
        />
      </template>
    </template>
  </div>
</template>

<script setup>
import {
  computed, onMounted, provide, reactive, ref, watch,
} from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from '../store';
import Button from '../components/base/Button.vue';
import Card from '../components/base/Card.vue';
import Dialog from '../components/base/Dialog.vue';
import DictionaryUploadForm from '../components/DictionaryUploadForm.vue';
import ComparisonSwiper from '../components/ComparisonSwiper.vue';
import Select from '../components/base/Select.vue';
import NextWordButton from '../components/NextWordButton.vue';
import DictionaryMessage from '../components/DictionaryMessage.vue';
import PixelSpinner from '../components/base/PixelSpinner.vue';
import LanguageSwitch from '../components/LanguageSwitch.vue';

const props = defineProps({
  dictionaryId: String,
});

const router = useRouter();
const store = useStore();

const { fetchDictionaryList, fetchDictionary } = store;

const languageCodes = ['RUS', 'ENG'];

const isOpen = ref(false);
const languageCodeEnabled = ref(false);
const activeSlideIndex = ref(0);
const activeLanguageCode = ref(languageCodes[0]);

provide('activeLanguageCode', activeLanguageCode);

const currentDictionary = computed(
  () => store.dictionaries.find(({ id }) => Number(props.dictionaryId) === id),
);

onMounted(async () => {
  await fetchDictionaryList();

  await fetchDictionary(props.dictionaryId);
});

watch(() => props.dictionaryId, () => {
  fetchDictionary(props.dictionaryId);
});

const onLanguageCodeChanged = (value) => {
  activeLanguageCode.value = value ? 'ENG' : 'RUS';
};

const currentComparison = computed(() => currentDictionary.value?.comparisons[
  activeSlideIndex.value
]);

const onShowTranslationButtonClick = () => {
  currentDictionary.value.comparisons[activeSlideIndex.value].displayed = true;
};

const onChangeDictionary = ({ id }) => {
  router.push({ name: 'Dictionary', params: { id } });
};

const onSwiper = (swiper) => {
  activeSlideIndex.value = swiper.realIndex;
};

const realIndexChange = (swiper) => {
  activeSlideIndex.value = swiper.realIndex;
};

const closeModal = () => {
  isOpen.value = false;
};

const openModal = () => {
  isOpen.value = true;
};
</script>
