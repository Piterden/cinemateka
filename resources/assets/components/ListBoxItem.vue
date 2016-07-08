<style lang="css">
.fade-transition {
  transition: opacity .3s ease;
}
.fade-enter, .fade-leave {
  opacity: 0;
}
</style>
<template lang="html">
  <div class="mdl-cell mdl-cell--{{ getCols(method) }}-col"
    :style="styleObject"
    transition="fade"
    transition-mode="out-in"
  >
    <div class="event-item-card"
      :style="bgStyleObject"
    >
      <div class="category">{{ eventTypeName }}</div>
      <div class="bottom-block">
        <div class="dates">
          {{ getSpendingRange() }}
        </div>
        <div class="title">
          <a href="#" v-link="{ path: '/event/' + item.slug }">
            <h3>{{ item.title }}</h3>
          </a>
        </div>
        <div class="program" v-if="closestProgram">
          <a href="#" v-link="{ path:'/program/' + closestProgram.slug }">
            {{ closestProgram.title }}
          </a>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
// @click.stop.prevent="$router.go( 'event/' + item.slug )"
export default {

  data() {
    let catId = this.item ? this.item.category_id : 0,
      cat = this.$root.getCategoryById(catId)
    return {
      eventTypeName: cat && cat.name
    }
  },

  props: {
    item: Object,
    index: Number,
    cols: Number,
    method: String,
    limit: Number,
    height: Number,
    separator: {
      type: String,
      default: ' – '
    },
    styleObject: {
      type: Object,
      default: 'inherit'
    }
  },

  computed: {
    closestProgram() {
      return this.$root.getClosestSeanceProgram(this.item)
    },

    bgStyleObject() {
      return {
        backgroundImage: 'url("/' + this.thumb + '")'
      }
    },

    /**
     * Изображение плитки
     */
    thumb() {
      return this.item && this.item.images && JSON.parse(this.item.images).mainimage
    },

    /**
     * Вычисляет ширину элемента списка в кол-ве колонок
     * @return {Number} Одинаковая ширина для всех элементов
     */
    same() {
      return this.cols
    },

    /**
     * Получает первый и, если нужно, последний элемент в 2 раза шире
     * @return {Number} Grid Width
     */
    firstLastDoubleWidth() {
      let showed = this.$parent.$children.length
      return !this.index || (
        this.$parent.$children.length == this.limit && this.index == this.limit - 1
      ) ? this.cols * 2 : this.cols
    }
  },

  methods: {
    /**
     * Получает строку из 2 дат - первого и последнего сеанса события, через '-'
     */
    getSpendingRange() {
      if (this.item === undefined) return ''
      let seances = this.item.seances || [],
        start, end
      if (!seances.length) {
        return ''
      }
      start = new Date(seances[0].start_time)
      if (seances.length == 1) {

      }
      end = new Date(seances[seances.length - 1].start_time)
      if ((end - start) / 1000 / 60 / 60 / 24 / 365 > 1) {
        return this.$root.formatDateToStr(start, 'DD.MM.YY') + this.separator + this.$root.formatDateToStr(end, 'DD.MM.YY')
      }
      return this.$root.formatDateToStr(start, 'DD.MM') + this.separator + this.$root.formatDateToStr(end, 'DD.MM')
    },

    getCols(method) {
      return this[method]
    }
  }

}
</script>

