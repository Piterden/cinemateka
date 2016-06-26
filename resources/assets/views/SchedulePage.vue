<style lang="css" scoped>
</style>

<template>
	<div class="wrap router-view schedule-page">

		<filters-line
			:filter-show.once="visibleFilters"
			:filter-lists.once="filterLists"
			:filter-values.sync="filterValues"
		></filters-line>

		<list-grid
			:seances="$root.seances"
			:limit.sync="limit"
			:more-visible="moreVisible"
			:increment-limit.once="incrementLimit"
			:cols.once="cols"
			:method.once="method"
			:filter-values.sync="filterValues">
		></list-grid>

	</div>
</template>

<script>
export default {

	data() {
		return {
			visibleFilters: [
				'now_soon',
				'date_interval',
				'event_type',
				'program_type',
				'place_type'
			],
			limit: 20,
			incrementLimit: 20,
			cols: 12,
			method: 'same',
			moreVisible: true
		};
	},

	props: {
		filterValues: {
			type: Object,
			default() {
				let d = new Date(),
					e = new Date(d.getFullYear(), d.getUTCMonth() + 1, d.getUTCDate());
				return {
					'now_soon': this.$root.getNowSoones()[0],
					'date_interval': [d,e],
					'event_type': 'Все события',
					'program_type': 'Все программы',
					'place_type': 'Все места'
				};
			},
			twoWay: true
		},
		filterLists: {
			type: Object,
			default() {
				return {
					'now_soon': this.$root.getNowSoones(),
					// 'date_interval': [this.activeStartDate, this.activeEndDate],
					'event_type': this.$root.getEventAttributeTypes('event_type', 'Все события'),
					'program_type': this.$root.programs.getUnique(),
					'place_type': this.$root.getEventPlaces()
				};
			}
		}
	},

	methods: {
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
	// computed: {
	// 	activeDateInterval() {
	// 		return [this.activeStartDate, this.activeEndDate];
	// 	}
	// }
};
</script>
