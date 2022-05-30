import { defineStore } from 'pinia';
import axios from './axios';

// eslint-disable-next-line import/prefer-default-export
export const useStore = defineStore('main', {
  state: () => ({
    dictionaries: [],
    dictionariesAreLoading: false,
  }),
  getters: {},
  actions: {
    async fetchDictionaryList() {
      this.dictionariesAreLoading = true;

      try {
        const { data: items } = await axios.get('/dictionaries/');

        this.dictionaries = items;
      } finally {
        this.dictionariesAreLoading = false;
      }

      return this.dictionaries;
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
          this.dictionaries.push(data);
          return data;
        });
    },
  },
});
