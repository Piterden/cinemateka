<style lang="css"></style>

<template lang="html">
  <div class="toggler">
    <ul>
      <li v-for="item in list"
        :class.sync="active(item)"
        @click="handleClick(item)"
      >{{ item }}</li>
    </ul>
  </div>
</template>

<script>

export default {
  data() {
    return {
      checked: 'checked'
    };
  },
  props: ['value', 'list'],
  computed: {},
  ready() {},
  attached() {},
  methods: {
    handleClick(item) {
      this.$set('value', item);
    },
    active(item) {
      return item == this.value ? 'active' : '';
    }
  },
  components: {}
}

</script>
