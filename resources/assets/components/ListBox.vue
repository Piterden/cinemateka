<style lang="css">
</style>

<template lang="html">
  <div class="mdl-grid list-box">
    <list-box-item
      v-for="item in events
        | filterMethod filterValues
        | limitBy limit"
      :index.once="$index"
      :item.once="item"
      :limit.sync="limit"
      :cols.once="cols"
      :method="method"
      :style-object="styleObject"
    ></list-box-item>
    <div v-if="moreVisible"
      class="show-more-block mdl-cell mdl-cell--12-col"
    >
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
    // События
    events: Array,
    // Программы
    programs: Array,
    // Объект стилей для квадратов
    styleObject: Object,
    // Принудительная ширина элемента списка
    itemWidth: Number,
    // Значения фильтров
    filterValues: { type: Object, default() { return {} } },
    // Количество отображаемых событий
    limit: { type: Number, default() { return 9 } },
    // Количество добавляемых событий
    incrementLimit: { type: Number, default() { return 9 } },
    // Название метода для вычисления ширины
    method: { type: String, default() { return 'same' } },
    // Ширина квадрата в колонках сетки
    cols: { type: Number, default() { return 4 } }
  },

  computed: {
    /**
     * Видимость кнопки "Показать еще"
     * @return {Boolean}
     */
    moreVisible() {
      return this.$children.length >= this.limit
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
      this.styleObject = {height: h + 'px'}
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

  filters: {
    /**
     * Ссылается на метод filterMethod у родителя
     * @param  {Array}      events    Массив объектов событий
     * @param  {Object}     filters   Объект фильтров со значениями
     * @return {Array}      Фильтрованный массив объектов событий
     */
    filterMethod(events, filters) {
      return this.$parent.filterMethod(events, filters)
    }
  }
}
</script>
