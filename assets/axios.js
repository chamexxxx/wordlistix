import axios from 'axios';
import router from './router';

const instance = axios.create({
  baseURL: '/api',
});

instance.interceptors.response.use((response) => response, (error) => {
  if (error.response.status === 404) {
    router.push({ name: 'NotFound' });
  }

  return Promise.reject(error);
});

export default instance;
