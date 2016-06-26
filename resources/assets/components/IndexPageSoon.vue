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
      :limit.once="limit"
			:filter-values.sync="filterValues"
      :cols.once="cols"
      :method.once="calcSizesMethod"
		></list-box>

	</div>
</template>

<script>
export default {

  data() {
    return {
      events: this.$root.events || [],
      programs: this.$root.programs || []
    };
  },

  props: {
    title: String,
    limit: Number,
    cols: Number,
    calcSizesMethod: String,
    tabs: {
      type: Array,
      default() {
        return [];
      }
    },
    activeTab: {
      type: Number,
      twoWay: true
    },
		filterValues: {
      type: Object,
      twoWay: true,
      default() {
        return {};
      }
    }
  },

	computed: {
		/**
	   * Даты активной вкладки сброшенные на начало и конец месяца.
		 * @return {Array}
		 */
		date_interval() {
			return [this.dateToMonthStart(), this.dateToMonthEnd()];
		}
	},

	watch: {
    activeTab(v) {
      let fv = this.$root.extend(
        this.$get('filterValues'),
        {date_interval: this.date_interval}
      );
      this.$set('filterValues', fv);
    }
  },

	methods: {
		/**
		 * Устанавливает дату на 00:00 1 числа месяца
		 * @return {Date}
		 */
		dateToMonthStart() {
			let d = new Date();
			d.setUTCFullYear(this.$parent.getSoonTabYear(this.activeTab));
			d.setUTCMonth(this.$parent.getSoonTabMonth(this.activeTab));
			d.setUTCDate(1);
			d.setUTCHours(0,0,0,0);
			return d;
		},

		/**
		 * Устанавливает дату на 23:59 последнего числа месяца
		 * @return {Date}
		 */
		dateToMonthEnd() {
			let d = new Date();
			d.setUTCFullYear(this.$parent.getSoonTabYear(this.activeTab));
			d.setUTCMonth(this.$parent.getSoonTabMonth(this.activeTab) + 1);
			d.setUTCDate(0);
			d.setUTCHours(23,59,59,999);
			return d;
		},

		/**
		 * Клик по табу направляет родителю
		 */
		clickTab(name) {
			this.$parent.clickSoonTab(name);
		},

		/**
		 * Фильтрует события по заданным значениям
		 * @param  {Array}        events    Все события
		 * @param  {Object}       filters   Фильтры со значениями
		 * @return {Array} of Event Objects
		 */
		filterMethod(events, filters) {

		  return events;
		}
	}
};
</script>
