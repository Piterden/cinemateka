<style lang="css">

</style>

<template lang="html">
  <div class="wrap router-view {{ $options.name }}">
    <slot></slot>
    <index-page-events
      :title.once="week.title"
      :tabs.once="week.tabs"
      :limit.sync="week.limit"
      :cols.once="week.cols"
      :calc-sizes-method.once="week.calcSizesMethod"
      :active-tab.sync="week.activeTab"
    ></index-page-events>
    <index-page-soon
      :title.once="month.title"
      :tabs.once="month.tabs"
      :limit.once="month.limit"
      :cols.once="month.cols"
      :calc-sizes-method.once="month.calcSizesMethod"
      :active-tab.sync="month.activeTab"
    ></index-page-soon>
  </div>
</template>

<script>

export default {

  data() {
    return {
      /**
       * Основной блок главной страницы "События"
       */
      week: {
        title: 'События',
        tabs: [
          { name: 'week0', title: 'На этой неделе' },
          { name: 'week1', title: 'На следующей' },
          { name: 'week2', title: '' },
          { name: 'week3', title: '' },
        ],
        limit: 7,
        cols: 4,
        // calcSizesMethod: 'firstLastDoubleWidth',
        activeTab: 0,
      },

      /**
       * Нижний блок главной страницы "Скоро"
       */
      month: {
        title: 'Скоро',
        tabs: this.$root.getMonthTabsList(),
        limit: 4,
        cols: 3,
        calcSizesMethod: 'same',
        activeTab: 0,
      }
    }
  },

  methods: {
    /**
     * Обновляет даты на недельных вкладках
     * после готовности компонента, подставляет
     * даты сразу в нужном формате
     */
    initTabs() {
      this.week.tabs.forEach((tab, idx) => {
        if (tab.title === '') {
          let start = this.$root.getMonday(this.getTabDate(idx)),
            end = this.$root.getSunday(start)
          tab.title = this.$root.dateStrFromDateObj(start, 'DD.MM') +
            '-' + this.$root.dateStrFromDateObj(end, 'DD.MM')
        }
      })
    },

    /**
     * Возвращает объект даты для заданной недели вкладки
     * @param {Number}  i   Номер вкладки с 0
     */
    getTabDate(i) {
      let d = new Date(),
        t = 60 * 60 * 24 * 7 * 1000 * i + d.getTime()
      d.setTime(t)
      return d
    },

    /**
     * Срабатывает при нажатии на таб недели
     */
    clickWeekTab(name) { // 'week$'
      let i = name.slice(4),
        d = this.getTabDate(i),
        mon = this.$root.getMonday(d)
      this.$set('week.activeTab', Number(i))
    },

    /**
     * Срабатывает при нажатии на таб месяца
     */
    clickSoonTab(name) { // 'month$'
      let i = name.slice(5)
      this.$set('month.activeTab', Number(i))
    },

    /**
     * Возвращает месяц для вкладки №i
     */
    getSoonTabMonth(i = 0) {
      let d = new Date()
      d.setUTCMonth(d.getMonth() + i)
      return d.getUTCMonth()
    },

    /**
     * Возвращает год для вкладки №i
     */
    getSoonTabYear(i) {
      let d = new Date()
      d.setUTCMonth(d.getMonth() + i)
      return d.getUTCFullYear()
    }

  },

  ready() {
    this.initTabs()
  }

}
</script>
