<style lang="css">

</style>

<template lang="html">
  <div class="mdl-cell mdl-cell--{{ getCols(method) }}-col"
    v-bind:style="styleObject"
    @click.stop.prevent="$router.go( 'event/' + item.slug )"

  ></div>
</template>

<script>
export default {

  props: {
    item: Object,
    index: Number,
    cols: Number,
    method: String,
    limit: Number,
    height: Number,
    styleObject: {
      type: Object,
      default() {
        return { height: 'inherit' }
      }
    }
  },

  methods: {
    getCols(m) {
      return this[m];
    }
  },

  computed: {
    /**
     * Получает одинаковые по размерам элементы списка
     * @return {Number} Grid Width
     */
    same() {
      return this.cols
    },

    /**
     * Получает первый и последний элемент в 2 раза шире
     * @return {Number} Grid Width
     */
    firstLastDoubleWidth() {
      return !this.index || this.index == this.limit - 1 ? this.cols * 2 : this.cols
    }
  }
}
</script>
