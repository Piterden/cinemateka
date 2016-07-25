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
      <a href="#" v-link="{ path: '/event/' + item.slug }">
        <div class="category">{{ eventTypeName }}</div>
      </a>
      <a href="#" v-link="{ path: '/event/' + item.slug }">
        <div class="bluncardy"></div>
      </a>
      <div class="bottom-block">
        <a href="#" v-link="{ path: '/event/' + item.slug }">
          <div class="dates">
            {{ getSpendingRange() }}
          </div>
          <div class="title">
              <h3>{{ item.title }}</h3>
          </div>
        </a>
        <div class="program">
          <div v-if="closestProgram">
            <a href="#" v-link="{ path:'/program/' + closestProgram.slug }">
              {{ closestProgram.title }}
            </a>
          </div>
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
      return this.item.wide != '1' ? this.cols : this.cols * 2
    },

    /**
     * Получает первый и, если нужно, последний элемент в 2 раза шире
     * @return {Number} Grid Width
     */
    firstLastDoubleWidth() {
      // let showed = this.$parent.$children.length
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
        start, end, formatted_start, formatted_end
      if (!seances.length) {
        return ''
      }
      start = new Date(seances[0].start_time)
      // if (seances.length == 1) {

      // }
      end = new Date(seances[seances.length - 1].start_time)
      if ((end - start) / 1000 / 60 / 60 / 24 / 365 > 1) {
        formatted_start = this.$root.formatDateToStr(start, 'DD.MM.YY')
        formatted_end = this.$root.formatDateToStr(end, 'DD.MM.YY')
      } else {
        formatted_start = this.$root.formatDateToStr(start, 'DD.MM')
        formatted_end = this.$root.formatDateToStr(end, 'DD.MM')
      }
      return (formatted_start == formatted_end)
        ? formatted_start
        : formatted_start + this.separator + formatted_end
    },

    getCols(method) {
      return this[method]
    }
  }

}
</script>

