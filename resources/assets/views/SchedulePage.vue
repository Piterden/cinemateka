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
      filteredCount: 5,
      /**
       * Значения фильтров
       * @type {Object}
       */
      filterValues: {
        month: 'Все месяцы',
        event_type: 'Все события',
        program_type: 'Все программы',
        place_type: 'Все площадки'
      },
      /**
       * Видимые фильтры
       * @type {Array}
       */
      visibleFilters: [
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
    /**
     * Видимые сеансы
     * @type {Object}
     */
    seances: {
      type: Array,
      default () {
        return this.$root.seances || []
      }
    },

    /**
     * Списки для фильтров
     * @type {Object}
     */
    filterLists: {
      type: Object,
      default () {
        return {
          // now_soon: this.$root.getNowSoones(),
          month: ['Все месяцы', ...moment.months()],
          event_type: this.$root.getEventTypes(),
          program_type: ['Все программы', ...this.$root.programs.map((pr) => {
            return pr.title
          }).getUnique()],
          place_type: ['Все площадки', ...this.$root.places.map((pl) => {
            return pl.title
          }).getUnique()]
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
      let fromTime = moment().startOf('day'),
        endTime = moment(fromTime).add(1, 'year'),
        filteredArray = seances.filter((seance) => {
          let seanceTime = moment(seance.start_time),
            s_evt = seance.eventTypeName && seance.eventTypeName.toLowerCase(),
            s_prt = seance.program && seance.program.title.toLowerCase(),
            s_plt = seance.place && seance.place.title.toLowerCase(),
            s_m = seanceTime.month(),
            f_et = filters.event_type.toLowerCase(),
            f_prt = filters.program_type.toLowerCase(),
            f_plt = filters.place_type.toLowerCase(),
            f_m = filters.month - 1
          if (seanceTime < fromTime || seanceTime > endTime) {
            return false
          }
          if (f_et != 'все события' && f_et != s_evt) {
            return false
          }
          if (f_prt != 'все программы' && f_prt != s_prt) {
            return false
          }
          if (f_plt != 'все площадки' && f_plt != s_plt) {
            return false
          }
          if (f_m != -1 && f_m != s_m) {
            return false
          }
          return true
        })
      this.filteredCount = filteredArray.length
      return filteredArray
    }
  },

  head: {
    title() {
      return {
        inner: 'Расписание',
        separator: '|',
        complement: this.$root.meta.app
      }
    },
    meta() {
      let description = '',
        title = 'Расписание - ' + this.$root.meta.app,
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

<style lang="sass" scoped>
.schedule-page .filters-line.mdl-grid {
  padding-bottom: 13px;
}
</style>
