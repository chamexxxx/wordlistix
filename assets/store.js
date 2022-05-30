import { defineStore } from 'pinia';
import axios from './axios';

// eslint-disable-next-line import/prefer-default-export
export const useStore = defineStore('main', {
  state: () => ({
    dictionaries: [],
    dictionaryIsLoading: false,
    dictionariesAreLoading: false,
  }),
  getters: {},
  actions: {
    addDictionary(dictionary, status) {
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
  },
});
