<style lang="css" scoped>
</style>

<template lang="html">
  <div class="index-wrapper">
    <div class="events-block">
      <list-box
        :events="getTopEvents()"
        :limit="20"
        :cols.once="4"
        :method.once="'same'">
      </list-box>
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
  			:events="getBottomEvents()"
        :limit.once="12"
        :cols.once="3"
        :method.once="'same'"
  			:filter-values.sync="filterValuesBottom"
  		></list-box>
  	</div>
  </div>
</template>

<script>
import moment from 'moment'
moment.locale('ru')

export default {

  data() {
    return {
      title: 'Скоро',
      tabs: this.getTabs(),
      limit: 12,
      cols: 3,
      calcSizesMethod: 'same',
      activeTab: 0
    }
  },

  computed: {
    filterValuesTop() {
      let d = moment(),
        n = d.add(14, 'days')
      return {
        date_interval: [d, n]
      }
    },
    filterValuesBottom() {
      return {
        date_interval: [this.topToTime, this.getTabMonth(this.activeTab)]
      }
    },
    fromTime() {
      return moment().startOf('day')
    },
    topToTime() {
      return this.fromTime.add(14, 'days')
    }
  },

  methods: {

    getTabs() {
      let mNum = moment(this.topToTime).month(),
        mArr = moment.monthsShort(),
        end = mArr.splice(0, mNum)
      return mArr.concat(end).map((m, i) => {
        return {
          name: 'month' + i,
          title: moment().month(m).format('MMM')
        }
      })
    },

    /**
     * Возвращает год для вкладки №i
     */
    getTabYear(i) {
      let d = moment()
      d.add(i, 'months')
      return d.year()
    },

    /**
     * Возвращает месяц для вкладки №i
     */
    getTabMonth(i = 0) {
      let d = moment(),
        nowMonth = d.month()
      d.add(14, 'days')
      if (d.month() != nowMonth) {
        i++
      }
      d.add(i, 'months')
      return d.month()
    },

    /**
     * Устанавливает дату на 23:59 последнего числа месяца
     * @return {Date}
     */
    dateToMonthEnd() {
      let y = this.getTabYear(this.activeTab),
        m = this.getTabMonth(this.activeTab) + 1
      return moment([y, m, 0])
    },

    getTopEvents() {
      let events = this.$root.events,
        fromTime = moment(),
        toTime = fromTime.add(14, 'days'),
        ee = events.filter((e) => {
          let ss = e.seances.filter((s) => {
            let st = moment(s.start_time)
            return fromTime < st && toTime > st
          })
          return ss && ss.length > 0
        })
      // if (ee.length < 3) {

      // }
      return ee
    },

    getBottomEvents() {
      return this.$root.events
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
        return e.seances && e.seances.find((s) => {
          let d = new Date(s.start_time)
          return d > filters.date_interval[0] && d < filters.date_interval[1]
        })
      })
    },

    /**
     * Фильтрует события по заданным значениям
     * @param  {Array}        events    Все события
     * @param  {Object}       filters   Фильтры со значениями
     * @return {Array} of Event Objects
     */
    filterFirstMethod(events, filters) {
      return events.filter((e) => {
        return e.seances && e.seances.find((s) => {
          let d = new Date(s.start_time)
          return d > filters.date_interval[0] && d < filters.date_interval[1]
        })
      })
    }
  }
}
</script>
