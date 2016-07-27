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
      :no-drag-when-single="true"
      :prevent="false"
    ><swipe-item
        v-for="slide in slides"
        class="slide"
        :style="{ backgroundImage: 'url(/' + slide.src + ')'}"
      >
        <a v-link="slide.link">
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
    <index-page-soon></index-page-soon>
  </div>
</template>
<script>
export default {

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
     * Срабатывает при нажатии на таб месяца
     */
    clickSoonTab(name) { // 'month$'
      let i = name.slice(5)
      this.$set('month.activeTab', Number(i))
    }
  }
}
</script>

