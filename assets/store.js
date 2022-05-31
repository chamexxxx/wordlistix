import { defineStore } from 'pinia';
import axios from './axios';

// eslint-disable-next-line import/prefer-default-export
export const useStore = defineStore('main', {
  state: () => ({
    dictionaries: [],
    comparisons: [],
    dictionaryIsLoading: false,
    dictionariesAreLoading: false,
    comparisonsAreLoading: false,
  }),
  getters: {
    getComparisons: (state) => (search = null) => {
      if (!search) {
        return state.comparisons;
      }

      return state.comparisons.filter(
        ({ words }) => words.some(({ text }) => text.toLowerCase().includes(search)),
      );
    },
  },
  actions: {
    addDictionary(dictionary) {
      const d = this.dictionaries.find(({ id }) => dictionary.id === id);

      if (!d) {
        this.dictionaries.push(dictionary);
      } else if (!d.comparisons) {
        d.comparisons = dictionary.comparisons;
      }
    },
    async fetchDictionaryList() {
      this.dictionariesAreLoading = true;

      try {
        const { data: items } = await axios.get('/dictionaries/');

        items.forEach(this.addDictionary);
      } finally {
        this.dictionariesAreLoading = false;
      }
    },
    async fetchDictionary(id) {
      this.dictionaryIsLoading = true;

      try {
        const { data: dictionary } = await axios.get(`/dictionaries/${id}`);

        this.addDictionary(dictionary);
      } finally {
        this.dictionaryIsLoading = false;
      }
    },
    async uploadDictionary({ name, dictionary, images }) {
      const formData = new FormData();

      if (name) {
        formData.append('name', name);
      }

      if (dictionary) {
        formData.append('dictionary', dictionary);
      }

      if (images) {
        formData.append('images', images);
      }

      return axios.post('/dictionaries', formData)
        .then(({ data }) => {
          this.addDictionary(data);
          return data;
        });
    },
    async fetchComparisonList() {
      try {
        this.comparisonsAreLoading = true;

        const { data: items } = await axios.get('/comparisons');

        this.comparisons = items;
      } finally {
        this.comparisonsAreLoading = false;
      }
    },
  },
});
