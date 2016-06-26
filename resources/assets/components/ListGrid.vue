<style lang="css">
</style>

<template lang="html">
  <div class="mdl-grid list-grid">
    <list-grid-item
      v-for="(index, item) in seances
      | filterMethod filterValues | limitBy limit"
      :index.once="index"
      :item.once="item"
      :limit.sync="limit"
      :cols.once="cols"
      :method="method"
      :style-object.sync="styleObject"
    ></list-grid-item>
    <div class="show-more-block mdl-cell mdl-cell--12-col"
      v-show="moreVisible">
      <a class="show-more-btn"
        @click="showMore">
        Показать еще
      </a>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    seances: Array,
    limit: Number,
    moreVisible: Boolean,
    incrementLimit: Number,
    cols: Number,
    method: String,
    filterValues: Object
  },
  methods: {
    showMore() {
      this.$set('limit', this.$get('limit') + this.$get('incrementLimit'));
    }
  },
  filters: {
    filterMethod(seances, method) {
      return this.$parent.filterMethod(seances, method);
    }
  },
  computed: {},
  ready: function () {},
  attached: function () {},
  components: {}
}
</script>
