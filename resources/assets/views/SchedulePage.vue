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

  /**
   * Инициализация компонента. Добавляем значения к каждому сеансу.
   */
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
     * @TODO dates frop pickers
     */
    filterMethod(seances = [], filters) {
      let fromTime = new Date(),
        y = fromTime.getFullYear(),
        m = fromTime.getMonth(),
        d = fromTime.getDate(),
        endTime = new Date(y, m, d + 1, 23, 59, 59),
        filteredArray = seances.filter((seance) => {
          let seanceTime = new Date(seance.start_time),
            s_evt = seance.eventTypeName.toLowerCase(),
            s_prt = seance.program.title.toLowerCase(),
            s_plt = seance.place.title.toLowerCase(),
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
    },
    /**
     * Дата проведения сеанса
     * @param  {Object} seance Объект сеанса
     * @return {String}        Дата ДД.ММ
     */
    getStartDate(seance) {
      let d = new Date(seance.start_time)
      return this.$root.formatDateToStr(d, 'DD.MM')
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

