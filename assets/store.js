import { defineStore } from 'pinia';
import axios from './axios';

// eslint-disable-next-line import/prefer-default-export
export const useStore = defineStore('main', {
  state: () => ({
    dictionaries: [],
  }),
  getters: {},
  actions: {
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
