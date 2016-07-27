<style lang="css" scoped>
</style>

<template lang="html">
	<div class="soon-block">
		<blocks-header :title="title">
      <ul class="mdl-tabs__tab-bar">
        <li v-for="(index, tab) in tabs"
          class="mdl-tabs__tab"
          v-show="1"
        >
          <a class="{{ this.activeTab == index ? 'active' : '' }}"
            @click.prevent="clickTab(tab.name)">
            {{ tab.title }}
          </a>
        </li>
      </ul>
    </blocks-header>
		<list-box
			:events="$root.events"
      :limit.once="limit"
			:filter-values.sync="filterValues"
      :cols.once="cols"
      :method.once="calcSizesMethod"
		></list-box>
	</div>
</template>

<script>
export default {

  props: {
    title: String,
    limit: Number,
    cols: Number,
    calcSizesMethod: String,
    tabs: {
      type: Array,
      default () {
        return []
      }
    },
    activeTab: {
      type: Number,
      twoWay: true
    }
  },

  computed: {
    /**
     * Даты активной вкладки сброшенные на начало и конец месяца.
     * @return {Array}
     */
    filterValues() {
      return {
        date_interval: [this.dateToMonthStart(), this.dateToMonthEnd()]
      }
    }
  },

  methods: {
    /**
     * Устанавливает дату на 00:00 1 числа месяца
     * @return {Date}
     */
    dateToMonthStart() {
      let y = this.$root.getSoonTabYear(this.activeTab),
        m = this.$root.getSoonTabMonth(this.activeTab),
        now = new Date(),
        d = this.activeTab == 0 ? now.getDate() + 14 : 1
      return new Date(y, m, d)
    },

    /**
     * Устанавливает дату на 23:59 последнего числа месяца
     * @return {Date}
     */
    dateToMonthEnd() {
      let y = this.$root.getSoonTabYear(this.activeTab),
        m = this.$root.getSoonTabMonth(this.activeTab) + 1
      return new Date(y, m, 0, 23, 59, 59)
    },

    /**
     * Клик по табу направляет псевдоним родителю
     */
    clickTab(name) {
      this.$parent.clickSoonTab(name)
    },

    /**
     * Фильтрует события по заданным значениям
     * @param  {Array}        events    Все события
     * @param  {Object}       filters   Фильтры со значениями
     * @return {Array} of Event Objects
     */
    filterMethod(events, filters) {
      return events.filter((e) => {
        return e.seances && e.seances.find((s) => {
          let d = new Date(s.start_time)
          return d > filters.date_interval[0] && d < filters.date_interval[1]
        })
      })
    }
  }
}
</script>
