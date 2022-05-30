<script>
import { h } from 'vue';
import { useSwiper } from 'swiper/vue';
import Button from './base/Button.vue';

export default {
  setup() {
    const swiper = useSwiper();

    const onClick = () => {
      swiper.value.slideNext();
    };

    return () => h(Button, { onClick }, () => 'Следующее слово');
  },
};
</script>
