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
			:filter-values.sync="filterValues"
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
					'place_type': 'Все площадки'
				};
			},
			twoWay: true
		},
		filterLists: {
			type: Object,
			default() {
				return {
					'now_soon': this.$root.getNowSoones(),
					'event_type': this.$root.getEventAttributeTypes('event_type', 'Все события'),
					'program_type': this.$root.programs.map((pr) => {
						return pr.title
					}).getUnique(),
					'place_type': this.$root.places.map((pl) => {
						return pl.title
					}).getUnique()
				}
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
		filterMethod(seances = [], filters) {
		  return seances.filter((s) => {
				let show = false

				for (let f in filters) {
					if (filters.hasOwnProperty(f)) {
						switch (f) {
							case 'now_soon':

								break;
							case 'event_type':
								if (filters[f] == 'Все события' || filters[f] == s.event.event_type) {
									show = true
								}
								break;
							case 'program_type':

								break;
							case 'place_type':

								break;
							case 'date_interval':

								break;
						}
					}
				}
			})
		}
	}
}
</script>
