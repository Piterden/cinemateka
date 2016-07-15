<style lang="css">

</style>

<template lang="html">
  <div class="wrap router-view {{ $options.name }}">
    <swipe
      :speed="600"
      :auto="0"
      :continuous="true"
      :show-indicators="true"
      :show-nav="true"
      :no-drag-when-single="false"
      :prevent="false"
    ><swipe-item
        v-for="slide in slides"
        class="slide"
        style="background-image: url('/{{ slide.src }}')"
      >
        <a href="{{ slide.link }}">
          <div v-if="slide.caption" class="caption-wrapper">
            <div v-if="slide.caption.caption_title" class="caption-title">
              {{ slide.caption.caption_title }}
            </div>
            <div v-if="slide.caption.caption_content" class="caption-content">
              {{ slide.caption.caption_content }}
            </div>
          </div>
        </a>
      </swipe-item>
    </swipe>
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
        tabs: [{
          name: 'week0',
          title: 'На этой неделе'
        }, {
          name: 'week1',
          title: 'На следующей'
        }, {
          name: 'week2',
          title: ''
        }, {
          name: 'week3',
          title: ''
        }, ],
        limit: 7,
        cols: 4,
        activeTab: 0,
      },

      /**
       * Нижний блок главной страницы "Скоро"
       */
      month: {
        title: 'Скоро',
        tabs: this.getMonthTabsList(),
        limit: 12,
        cols: 3,
        calcSizesMethod: 'same',
        activeTab: 0,
      }
    }
  },

  computed: {
    slides() {
      return this.$root.getPublished(this.$root.slides)
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
          tab.title = this.$root.formatDateToStr(start, 'DD.MM') +
            '-' + this.$root.formatDateToStr(end, 'DD.MM')
        }
      })
    },

    /**
     * Возвращает объект даты для заданной недели вкладки
     * @param {Number}  i   Номер вкладки с 0
     */
    getTabDate(i) {
      let d = new Date(),
        t = 60 * 60 * 24 * 14 * 1000 * i + d.getTime()
      d.setTime(t)
      return d
    },

    /**
     * Срабатывает при нажатии на таб недели
     */
    clickWeekTab(name) { // 'week$'
      let i = name.slice(4);
        // d = this.getTabDate(i);
        //mon = this.$root.getMonday(d)
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
     * Список из 12 месяцев начиная с
     * текущего для компонента "Скоро"
     */
    getMonthTabsList() {
      let mn = this.$root.getMonthNames(),
        d = new Date()
      d.setDate(d.getDate() + 14)
      let nn = mn.splice(d.getMonth()).concat(mn)
      return nn.map((m, i) => {
        let num = this.$root.getSoonTabMonth(i)
        return {
          name: 'month' + i,
          year: this.$root.getSoonTabYear(i),
          title: this.$root.getMonthNames()[num].slice(0, 3)
        }
      })
    },
  },

  ready() {
    this.initTabs()
  }

}
</script>

