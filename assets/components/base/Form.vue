<script>
export default {
  setup(props, { slots }) {
    return () => slots.default().map((el) => {
      // eslint-disable-next-line no-param-reassign
      el.props.class = 'my-5 first:mt-0 last:mb-0';

      return el;
    });
  },
};
</script>
