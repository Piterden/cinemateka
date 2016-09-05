<template>
  <div class="wrap router-view archive-page">
    <filters-line
      :filter-show.once="visibleFilters"
      :filter-lists.once="filterLists"
      :filter-values.sync="filterValues"
    ></filters-line>
    <list-box
      :events.once="events"
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
import moment from 'moment'
moment.locale('ru_RU')

export default {

  data() {
    return {
      visibleFilters: ['event_type', 'month', 'year', 'program'],
      limit: 9,
      incrementLimit: 9,
      cols: 4,
      method: 'same'
    }
  },

  props: {
    events: {
      default() {
        return this.$root.events.filter((e) => {
          let ss = e.seances,
            now = moment(),
            futureSeance = false
          if (ss && ss != []) {
            futureSeance = ss.find((s) => {
              return moment(s.start_time) < now
            })
          }
          return Boolean(futureSeance)
        })
      }
    },
    filteredCount: Number,
    /**
     * Значения фильтров
     */
    filterValues: {
      type: Object,
      default () {
        let d = moment()
        return {
          event_type: 'Все события',
          month: d.month() + 1,
          year: d.year(),
          program: 'Все программы'
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
          month: ['Все месяца', ...moment.months()],
          year: ['Все годы', ...this.$root.getExistedYears()],
          program: ['Все программы', ...this.$root.getProgramNames()]
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
        f_p = filters.program.toLowerCase(),
        filtered = events.filter((e) => {
          // Если не назначено сеансов - скрываем событие
          if (e.seances === undefined || !e.seances || !e.seances.length) {
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
          // Если не совпадает программа - скрываем
          let programIds = this.$root.getEventProgramsIds(e),
            program = this.$root.getClosestSeanceProgram(this.item)
              || this.$root.getById(this.$root.programs, programIds[0])
          if (f_p != 'все программы' && program
            && f_p != program.title.toLowerCase()) {
            return false
          }
          return true
        })
      this.filteredCount = filtered.length
      // Сортируем в обратном порядке
      return filtered.sort((a, b) => {
        let a_s = this.$root.getClosestSeance(a),
          b_s = this.$root.getClosestSeance(b)
        return a_s.start_time < b_s.start_time
      })
    },

    /**
     * Проверям сеансы на соответствие году
     * @param  {Array}    e         событие
     * @param  {Number}   y         4-х значный год
     * @return {Boolean}
     */
    checkSeancesByYear(e, y) {
      return e.seances.find((s) => {
        let sd = moment(s.start_time)
        return sd.year() == y
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
        let sd = moment(s.start_time)
        return sd.month() == m
      })
    },

    /**
     * По загрузке страницы
     */
    onShow() {
      if (!this.filteredCount) {
        let m = this.filterValues.month
        this.filterValues.month = m - 1
      }
    }
  },

  route: {
    /**
     * По готовности роута. Равняет высоту квадратов и вешает обработчик.
     * @method ready
     */
    activate() {
      this.onShow()
      // $.trigger('fix.resize')
    },
    /**
     * По уходу со страницы - снимает обработчик.
     * @return {[type]} [description]
     */
    deactivate() {

    }
  },


  head: {
    title() {
      return {
        inner: 'Архив',
        separator: '|',
        complement: this.$root.meta.app
      }
    },
    meta() {
      let description = '',
        title = 'Архив - ' + this.$root.meta.app,
        image = ''
      return {
        name: {
          'application-name': this.$root.meta.app,
          description: description,
          'twitter:title': title,
          'twitter:description': description,
          'twitter:image': image
        }, //' comment to fix sublime highlighting
        itemprop: {
          name: title,
          description: description,
          image: image
        },
        property: {
          'fb:app_id': this.$root.meta.fbAppId,
          'og:url': window.location.href,
          'og:title': title,
          'og:description': description,
          'og:image': image
        } //' comment to fix sublime highlighting
      }
    }
  }

}
</script>

<style lang="css">
.filters-line.mdl-grid .month-filter {
  margin-left: .6%;
}
.filters-line.mdl-grid .year-filter {
  margin-left: -.5%;
  width: 16.9%;
}
.filters-line.mdl-grid .program-filter {
  margin-left: -2.5%;
}
.filter .dropdown {
  margin: 0;
}
.filter .dropdown ul {
  max-height: 448px;
}
</style>
