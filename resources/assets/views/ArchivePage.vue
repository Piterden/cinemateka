<style lang="css" scoped>
</style>

<template>
	<div class="wrap router-view archive-page">
		<filters-line
			:filter-show.once="visibleFilters"
			:filter-lists.once="filterLists"
			:filter-values.sync="filterValues">
		</filters-line>
		<list-box
			:events.once="$root.events"
			:programs.once="$root.programs"
			:limit.sync="limit"
			:more-visible="moreVisible"
			:increment-limit.once="incrementLimit"
			:cols.once="cols"
			:method.once="method"
			:filter-values.sync="filterValues">
		</list-box>
	</div>
</template>

<script>
export default {

	data() {
		return {
			visibleFilters: [
				'event_type',
				'month',
				'year'
			],
			limit: 9,
			incrementLimit: 9,
			cols: 4,
			method: 'same',
			moreVisible: true
		};
	},

	props: {
		/**
		 * Значения фильтров
		 */
		filterValues: {
			type: Object,
			default() {
				let d = new Date();
				return {
					'event_type': 'Все события',
					'month': d.getUTCMonth(),
					'year': d.getFullYear()
				};
			},
			twoWay: true
		},

		/**
		 * Списки фильтров
		 */
		filterLists: {
			type: Object,
			default() {
				return {
					'event_type': this.$root.getEventAttributeTypes('event_type', 'Все события'),
	        'month': this.$root.getMonthNames(),
	        'year': this.$root.getExistedYears(),
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
		  return events.filter((eventItem) => {

				if (eventItem.seances === undefined || !eventItem.seances.length)
				{ // Если не назначено сеансов - скрываем событие
		      return false;
		    }

				if (filters.event_type != 'Все события' &&
					filters.event_type != eventItem.event_type)
				{ // Если не совпадает категория - скрываем
					return false;
				}

				let show = false;
				eventItem.seances.forEach((s) => {
					let sd = new Date(s.start_time);
					if (sd.getUTCMonth() == filters.month &&
						sd.getFullYear() == filters.year)
					{
						show = true;
					}
				});

				return show;
		  });
		}
	}

};
</script>
