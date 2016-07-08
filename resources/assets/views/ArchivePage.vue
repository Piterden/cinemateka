<style lang="css" scoped>
</style>

<template>
  <div class="wrap router-view archive-page">
    <filters-line
      :filter-show.once="visibleFilters"
      :filter-lists.once="filterLists"
      :filter-values.sync="filterValues"
    ></filters-line>
    <list-box
      :events.once="$root.events"
      :programs.once="$root.programs"
      :limit.sync="limit"
      :increment-limit.once="incrementLimit"
      :cols.once="cols"
      :method.once="method"
      :filter-values.sync="filterValues"
      :filtered-count.sync="filteredCount"
    ></list-box>
  </div>
</template>

<script>
export default {

  data() {
    return {
      visibleFilters: ['event_type', 'month', 'year'],
      limit: 9,
      incrementLimit: 9,
      cols: 4,
      method: 'same',
    }
  },

  props: {
    filteredCount: Number,
    /**
     * Значения фильтров
     */
    filterValues: {
      type: Object,
      default () {
        let d = new Date()
        return {
          event_type: 'Все события',
          month: d.getUTCMonth(),
          year: d.getFullYear()
        }
      },
      twoWay: true
    },

    /**
     * Списки фильтров
     */
    filterLists: {
      type: Object,
      default () {
        return {
          event_type: this.$root.getEventTypes(),
          month: this.$root.getMonthNames().addBefore('Все месяца'),
          year: this.$root.getExistedYears().addBefore('Все годы'),
        }
      }
    }
  },

  methods: {
    /**
     * Фильтрует события по заданным значениям, и кеширует их кол-во
     * @param  {Array}        events    Все события
     * @param  {Object}       filters   Фильтры со значениями
     * @return {Array} of Event Objects
     */
    filterMethod(events, filters) {
      let f_et = filters.event_type.toLowerCase(),
        f_y = filters.year,
        f_m = filters.month,
        filtered = events.filter((e) => {
          // Если не назначено сеансов - скрываем событие
          if (e.seances === undefined || !e.seances.length) {
            return false
          }
          // Если не совпадает категория - скрываем
          if (f_et != 'все события' && f_et != e.event_type.toLowerCase()) {
            return false
          }
          // Если выбраны не "все годы", но год не совпадает - скрываем
          if (typeof f_y != 'string' && !this.checkSeancesByYear(e, f_y)) {
            return false
          }
          // Если выбрано не "все месяца", но месяц не совпадает - скрываем
          if (f_m !== 0 && !this.checkSeancesByMonth(e, f_m - 1)) {
            return false
          }
          return true
        })
      this.filteredCount = filtered.length
      return filtered
    },

    /**
     * Проверям сеансы на соответствие году
     * @param  {Array}    e         событие
     * @param  {Number}   y         4-х значный год
     * @return {Boolean}
     */
    checkSeancesByYear(e, y) {
      return e.seances.find((s) => {
        let sd = new Date(s.start_time)
        return sd.getFullYear() == y
      })
    },

    /**
     * Проверям сеансы на соответствие месяцу
     * @param  {Array}    e         событие
     * @param  {Number}   y         номер месяца
     * @return {Boolean}
     */
    checkSeancesByMonth(e, m) {
      return e.seances.find((s) => {
        let sd = new Date(s.start_time)
        return sd.getMonth() == m
      })
    }
  }

};
</script>
