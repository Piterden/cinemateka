<style lang="css" scoped>
</style>

<template>
	<div class="soon-block">
		<blocks-header :title="title">
      <ul class="mdl-tabs__tab-bar">
        <li v-for="(index, tab) in tabs"
          class="mdl-tabs__tab">
          <a class="{{ this.activeTab == index ? 'active' : '' }}"
            @click.prevent="clickTab(tab.name)">
            {{ tab.title }}
          </a>
        </li>
      </ul>
    </blocks-header>
		<list-box
			:events="$root.events"
			:programs="$root.programs"
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
      default() {
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
			let d = new Date()
			d.setFullYear(this.$parent.getSoonTabYear(this.activeTab))
			d.setMonth(this.$parent.getSoonTabMonth(this.activeTab))
			d.setDate(1)
			d.setHours(0,0,0,0)
			return d
		},

		/**
		 * Устанавливает дату на 23:59 последнего числа месяца
		 * @return {Date}
		 */
		dateToMonthEnd() {
			let d = new Date()
			d.setFullYear(this.$parent.getSoonTabYear(this.activeTab))
			d.setMonth(this.$parent.getSoonTabMonth(this.activeTab) + 1)
			d.setDate(0)
			d.setHours(23,59,59,999)
			return d
		},

		/**
		 * Клик по табу направляет родителю
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
			console.log(filters);
		  return events.filter((e) => {
        let ss = e.seances.filter((s) => {
          let d = new Date(s.start_time)
          return d > filters.date_interval[0]
            && d < filters.date_interval[1]
        })
        return ss.length
      })
		}
	}
}
</script>
