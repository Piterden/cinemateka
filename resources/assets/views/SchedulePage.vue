<style lang="css" scoped>
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
      limit: 5,
      incrementLimit: 5,
      filteredCount: 5,
      cols: 12,
      method: 'same'
    }
  },

  props: {
    seances: {
      type: Array,
      default() {
        return this.$root.seances
      }
    },
    filterValues: {
      type: Object,
      default () {
        let d = new Date(),
          e = new Date(d.getFullYear(), d.getUTCMonth() + 1, d.getUTCDate())
        return {
          'now_soon': this.$root.getNowSoones()[0],
          'date_interval': [d, e],
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
          event_type: this.$root.getEventTypes(),
          program_type: this.$root.programs.map((pr) => {
            return pr.title
          }).getUnique(),
          place_type: this.$root.places.map((pl) => {
            return pl.title
          }).getUnique()
        }
      }
    }
  },

  created() {
    this.seances = this.seances.map((s) => {
      s.startDate = this.getStartDate(s)
      s.startTime = this.getStartTime(s)
      s.event = this.getEvent(s)
      s.program = this.getProgram(s)
      s.place = this.getPlace(s)
      s.eventTypeName = this.getEventTypeName(s.event)
      return s
    })
  },

  methods: {
    /**
     * Фильтрует события по заданным значениям
     * @param  {Array}        events    Все события
     * @param  {Object}       filters   Фильтры со значениями
     * @return {Array} of Event Objects
     */
    filterMethod(seances = [], filters) {
      let fromTime = new Date(),
        y = fromTime.getFullYear(),
        m = fromTime.getMonth(),
        d = fromTime.getDate(),
        endTime = new Date(y, m, d + 1, 23, 59, 59),
        filteredArray = seances.filter((seance) => {
          let seanceTime = new Date(seance.start_time)
          if (filters.event_type.toLowerCase() != 'все события' && filters.event_type.toLowerCase() != seance.eventTypeName.toLowerCase()) {
              return false
          }
          if (filters.program_type.toLowerCase() != 'все программы' && filters.program_type.toLowerCase() != seance.eventTypeName.toLowerCase()) {
              return false
          }
          if (filters.place_type.toLowerCase() != 'все площадки' && filters.place_type.toLowerCase() != seance.eventTypeName.toLowerCase()) {
              return false
          }
          if (filters.now_soon.toLowerCase() == 'скоро') {
            endTime = new Date(y, m, d + 7, 23, 59, 59)
          }
          if (seanceTime < fromTime || seanceTime > endTime) {
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
    },
    /**
     * Дата проведения сеанса
     * @param  {Object} seance Объект сеанса
     * @return {String}        Дата ДД.ММ
     */
    getStartDate(seance) {
      let d = new Date(seance.start_time)
      return this.$root.dateStrFromDateObj(d, 'DD.MM')
    },
    /**
     * Время проведения сеанса
     * @param  {Object} seance Объект сеанса
     * @return {String}        Время ЧЧ:ММ
     */
    getStartTime(seance) {
      let d = new Date(seance.start_time)
      return this.$root.timeStrFromDateObj(d, 'hh:mm')
    },
    /**
     * Событие сеанса
     * @param  {Object} seance Объект сеанса
     * @return {Object}        Объект события
     */
    getEvent(seance) {
      return this.$root.getEventById(seance.event_id)
    },
    /**
     * Программа сеанса
     * @param  {Object} seance Объект сеанса
     * @return {Object}        Объект программы
     */
    getProgram(seance) {
      return this.$root.getProgramById(seance.program_id)
    },
    /**
     * Место проведения сеанса
     * @param  {Object} seance Объект сеанса
     * @return {Object}        Объект места
     */
    getPlace(seance) {
      return this.$root.getPlaceById(seance.place_id)
    },
    /**
     * Название категории (типа события)
     * @param  {Object} evObj Объект события
     * @return {String}       Name
     */
    getEventTypeName(evObj) {
      let cat = this.$root.getCategoryById(evObj.category_id)
      return cat !== undefined ? cat.name : ''
    }
  }
}
</script>
