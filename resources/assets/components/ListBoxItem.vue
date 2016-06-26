<style lang="css">

</style>

<template lang="html">
  <div class="mdl-cell mdl-cell--{{ getCols(method) }}-col"
    v-bind:style="styleObject"
    @click.stop.prevent="$router.go( 'event/' + item.slug )">
    <div class="event-item-card" style="background: url('');">
      <div class="category" v-text="item.event_type"></div>
      <div class="bottom-block">
        <div class="dates" v-text="spendingRange()"></div>
        <h3 class="title" v-text="item.title"></h3>
        <div class="program"></div>
      </div>
    </div>
  </div>
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
  },

  methods: {
    /**
     * Получает строку из 2 дат - первого и последнего сеанса события, через '-'
     */
    spendingRange() {
      let seances = this.item.seances || [],
        start = new Date(seances[0].start_time),
        end = new Date(seances[seances.length - 1].start_time)

      return this.$root.formatDateDDdotMM(start) + '-' + this.$root.formatDateDDdotMM(end)
    },
    getCols(method) {
      return this[method]
    }
  }
}
</script>
