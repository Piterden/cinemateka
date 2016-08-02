<template>
  <div class="mdl-grid list-box {{ wrapClass }}" v-cloak>
    <slot name="top"></slot>
    <list-box-item
      v-if="events"
      v-for="item in events
        | filterMethod filterValues
        | limitBy limit"
      :class="itemClass"
      :index.once="$index"
      :item.sync="item"
      :limit.sync="limit"
      :cols.once="cols"
      :method="method"
      :style-object="styleObject"
      transition="item"
    ></list-box-item>
    <slot name="bottom"></slot>
    <div v-if="moreVisible" class="show-more-block mdl-cell mdl-cell--12-col">
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
    filteredCount: Number,
    itemWidth: Number,
    styleObject: { // Объект стилей для квадратов
      type: Object,
      default () {
        return {}
      }
    },
    events: { // События
      type: Array,
      required: true
    },
    filterValues: { // Значения фильтров
      type: Object,
      default () {
        return {}
      }
    },
    // Количество отображаемых событий
    limit: {
      type: Number,
      default () {
        return 9
      }
    },
    // Количество добавляемых событий
    incrementLimit: {
      type: Number,
      default () {
        return 9
      }
    },
    // Название метода для вычисления ширины
    method: {
      type: String,
      default: 'same'
    },
    // Ширина квадрата в колонках сетки
    cols: {
      type: Number,
      default: 4
    },
    itemClass: String,
    wrapClass: String,
    entity: String,
    notEmpty: {
      type: Boolean,
      default: true
    }
  },

  computed: {
    /**
     * Видимость кнопки "Показать еще"
     * @return {Boolean}
     */
    moreVisible() {
      return this.filteredCount && this.filteredCount >= this.limit
    }
  },

  methods: {
    /**
     * Возвращает ширину самого узкого элемента
     * для создания квадратов и прямоугольников.
     * @method getMinWidth
     * @return {Number}
     */
    getMinWidth() {
      return this.$children.map((el) => {
        return el.$el.offsetWidth
      }).min()
    },
    /**
     * Срабатывает при изменении размера окна.
     * Корректирует высоту пропорций квадратов.
     * @method handleResize
     */
    handleResize() {
      let h = this.itemHeight || this.getMinWidth()
      this.styleObject = {
        height: h + 'px'
      }
    },
    /**
     * Срабатывает при нажатии "Показать еще".
     * @method showMore
     */
    showMore() {
      this.limit += this.incrementLimit
    }
  },

  /**
   * По готовности.
   * Равняет высоту квадратов и вешает обработчики.
   * @method ready
   */
  ready() {
    this.handleResize()
    window.removeEventListener('resize', this.handleResize)
    window.addEventListener('resize', this.handleResize)
  },

  beforeDestroy() {
    window.removeEventListener('resize', this.handleResize)
  },

  watch: {
    filterValues: {
      deep: true,
      handler() {
        this.handleResize()
      }
    }
  },

  filters: {
    /**
     * Ссылается на метод filterMethod у родителя
     * @param  {Array}      events    Массив объектов событий
     * @param  {Object}     filters   Объект фильтров со значениями
     * @return {Array}      Фильтрованный массив объектов событий
     */
    filterMethod(events, filters) {
      let res = this.$parent.filterMethod(events.filter((e) => {
        return e
      }), filters)
      this.notEmpty = res.length > 0
      return res
    }
  }
}
</script>
<style lang="css">
</style>
