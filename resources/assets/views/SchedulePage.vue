<style lang="sass" scoped>
.schedule-page .filters-line.mdl-grid {
  padding-bottom: 13px;
}
</style>
<template>
  <div class="wrap router-view schedule-page">
    <filters-line
      :filter-show.once="visibleFilters"
      :filter-lists.once="filterLists"
      :filter-values.sync="filterValues"
    ></filters-line>
    <list-grid
      :seances="seances"
      :limit.sync="limit"
      :increment-limit.once="incrementLimit"
      :cols.once="cols"
      :method.once="method"
      :filter-values.sync="filterValues"
      :filtered-count.sync="filteredCount"
    ></list-grid>
  </div>
</template>
<script>
import moment from 'moment'
moment.locale('ru')

export default {

  data() {
    return {
      visibleFilters: [
        'now_soon',
        // 'date_interval',
        'month',
        'event_type',
        'program_type',
        'place_type'
      ],
      limit: 5,
      incrementLimit: 5,
      cols: 12,
      method: 'same'
    }
  },

  props: {
    filteredCount: Number,
    seances: {
      type: Array,
      default () {
        return this.$root.seances
      }
    },
    filterValues: {
      default () {
        let d = new Date(),
          e = new Date(d.getFullYear(), d.getMonth() + 1, d.getDate()),
          interval = [this.$root.parse(d), this.$root.parse(e)]
        return {
          'now_soon': this.$root.getNowSoones()[1],
          'date_interval': interval,
          'month': 'Все месяцы',
          'event_type': 'Все события',
          'program_type': 'Все программы',
          'place_type': 'Все площадки'
        }
      },
      twoWay: true
    },
    filterLists: {
      type: Object,
      default () {
        return {
          now_soon: this.$root.getNowSoones(),
          month: ['Все месяцы', ...this.$root.getMonthNames()],
          event_type: this.$root.getEventTypes(),
          program_type: this.$root.programs.map((pr) => {
            return pr.title
          }).getUnique().addBefore('Все программы'),
          place_type: this.$root.places.map((pl) => {
            return pl.title
          }).getUnique().addBefore('Все площадки')
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
     * @TODO dates frop pickers
     */
    filterMethod(seances = [], filters) {
      let fromTime = moment(),
        y = fromTime.year(),
        m = fromTime.month(),
        d = fromTime.date(),
        endTime = new Date(y, m, d + 1, 23, 59, 59),
        filteredArray = seances.filter((seance) => {
          let seanceTime = new Date(seance.start_time),
            s_evt = seance.eventTypeName && seance.eventTypeName.toLowerCase(),
            s_prt = seance.program && seance.program.title.toLowerCase(),
            s_plt = seance.place && seance.place.title.toLowerCase(),
            s_m = seanceTime.getMonth(),
            f_et = filters.event_type.toLowerCase(),
            f_prt = filters.program_type.toLowerCase(),
            f_plt = filters.place_type.toLowerCase(),
            f_ns = filters.now_soon.toLowerCase(),
            f_m = filters.month - 1
          if (f_et != 'все события' && f_et != s_evt) {
            return false
          }
          if (f_prt != 'все программы' && f_prt != s_prt) {
            return false
          }
          if (f_plt != 'все площадки' && f_plt != s_plt) {
            return false
          }
          if (f_ns == 'скоро') {
            endTime = new Date(y, m, d + 300, 23, 59, 59)
          }
          if (seanceTime < fromTime || seanceTime > endTime) {
            return false
          }
          if (f_m != -1 && f_m != s_m) {
            return false
          }
          // case 'date_interval':
          //   fromTime = new Date(filters[f][0])
          //   endTime = new Date(filters[f][1])
          //   if (seanceTime < fromTime || seanceTime > endTime) {
          //     return false
          //   }
          //   break
          return true
        })
      this.filteredCount = filteredArray.length
      return filteredArray
    }
  }
}
</script>

