<template lang="html">
  <div class="index-wrapper">
    <div class="events-block">
      <list-box
        :cols.once="4"
        :events.once="evTop"
        :limit="20"
        :filter-values.sync="filterValuesTop"
      ></list-box>
    </div>
    <div class="soon-block">
      <blocks-header :title="title">
        <ul class="mdl-tabs__tab-bar">
          <li v-for="(index, tab) in tabs"
            class="mdl-tabs__tab"
            v-show="1"
          >
            <a class="{{ this.activeTab == index ? 'active' : '' }}"
              @click.prevent="clickTab(tab.name)">
              {{ tab.title }}
            </a>
          </li>
        </ul>
      </blocks-header>
      <list-box
        :events.sync="evBot"
        :limit.once="12"
        :cols.once="3"
        :filter-values.sync="filterValuesBottom"
      ></list-box>
    </div>
  </div>
</template>

<script>
import moment from 'moment'
moment.locale('ru-RU')

export default {

  data() {
    return {
      title: 'Скоро',
      tabs: this.getTabs(),
      activeTab: 0
    }
  },

  props: {
    evTop: Array,
    evBot: Array,
    filterValuesTop: {
      type: Object,
      default() {
        return {
          date_interval: [
            moment(this.fromTime).format('YYYY-MM-DD HH:mm:ss'),
            moment(this.topToTime).endOf('day').format('YYYY-MM-DD HH:mm:ss')
          ]
        }
      }
    }
  },

  computed: {
    filterValuesBottom() {
      let fv = {}
      if (this.activeTab == 0) {
        if (moment().format('MMM') == this.tabs[this.activeTab].title) {
          fv.date_interval = [
            this.topToTime.format('YYYY-MM-DD HH:mm:ss'),
            moment().endOf('month').format('YYYY-MM-DD HH:mm:ss')
          ]
        } else {
          fv.date_interval = [
            moment().add(1, 'month').startOf('month').format('YYYY-MM-DD HH:mm:ss'),
            moment().add(1, 'month').endOf('month').format('YYYY-MM-DD HH:mm:ss')
          ]
        }
      } else {
        let start = moment().set(
            'month', this.getTabMonth(this.activeTab)
          ).startOf('month').format('YYYY-MM-DD HH:mm:ss'),
          end = moment().set(
            'month', this.getTabMonth(this.activeTab)
          ).endOf('month').format('YYYY-MM-DD HH:mm:ss')
        fv.date_interval = [start, end]
      }
      return fv
    },
    fromTime() {
      return moment().startOf('day')
    },
    topToTime() {
      let d = moment(this.fromTime)
      return d.add(14, 'days')
    }
  },

  methods: {

    /**
     * Формирует список вкладок
     * @return {[type]} [description]
     */
    getTabs() {
      let mNum = moment(this.topToTime).month(),
        mArr = moment.monthsShort(),
        end = mArr.splice(0, mNum)
      return mArr.concat(end).map((m, i) => {
        return {
          name: 'month' + i,
          title: moment().month(this.getTabMonth(i)).format('MMM')
        }
      })
    },

    /**
     * Возвращает год для вкладки №i
     * @return {Number}
     */
    getTabYear(i = 0) {
      return moment().add(i, 'months').year()
    },

    /**
     * Возвращает месяц для вкладки №i
     * @return {Number}
     */
    getTabMonth(i = 0) {
      return moment().add(14, 'days').add(i, 'months').get('month')
    },

    /**
     * Сеансы верхнего блока в ближайшие 2 недели
     * @return {Array}
     */
    getTopSeances() {
      let events = this.$root.events,
        fromTime = moment(),
        toTime = fromTime.add(14, 'days'),
        ee = events.filter((e) => {
          let ss = e && e.seances && e.seances.length && e.seances.filter((s) => {
            let st = moment(s.start_time)
            return fromTime < st && toTime > st
          })
          return ss && ss.length > 0
        })
      return ee
    },

    /**
     * Клик по табу направляет псевдоним родителю
     */
    clickTab(name) {
      this.activeTab = Number(name.substr(5,1))
    },

    /**
     * Фильтрует события по заданным значениям
     * @param  {Array}        events    Все события
     * @param  {Object}       filters   Фильтры со значениями
     * @return {Array} of Event Objects
     */
    filterMethod(events, filters) {
      return events.filter((e) => {
        if (undefined === e) return false
        return e.seances && e.seances.find((s) => {
          let d = moment(s.start_time),
            start = moment(filters.date_interval[0]),
            end = moment(filters.date_interval[1])
          return d > start && d < end
        })
      })
    },

    /**
     * Callback to map seances to events
     * @param  {Object} s seance
     * @return {Object}   event
     */
    seancesToEvents(s) {
      if (s !== undefined || s.event_id !== undefined) {
        let e = this.$root.getById(this.$root.events, s.event_id)
        return e
      }
    }

  },

  /**
   * Mine the collections on load page
   */
  created() {
    this.evTop = this.getTopSeances().map(this.seancesToEvents).filter((e) => {
      return e !== undefined && e !== null
    })
    this.evBot = this.$root.seances.filter((s) => {
      return moment(s.start_time) > moment()
    }).map(this.seancesToEvents).filter((e) => {
      return e !== undefined && e !== null
    })
    let l = this.evTop.length
    if (l < 3) {
      this.filterValuesTop = {
        date_interval: [
          moment().format('YYYY-MM-DD HH:mm:ss'),
          moment().add(10, 'years').format('YYYY-MM-DD HH:mm:ss')
        ]
      }
      for (let i = l; i < 3; i++) {
        this.evTop.push(this.evBot.splice(0, 1)[0])
      }
    }
  }

}
</script>

<style lang="css" scoped>
</style>
