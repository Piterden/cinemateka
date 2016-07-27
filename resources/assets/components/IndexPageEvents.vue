<style lang="css" scoped>
</style>

<template>
  <div class="events-block">
    <blocks-header :title="title" v-show="0">
      <ul class="mdl-tabs__tab-bar">
        <li v-for="(index, tab) in tabs"
          class="mdl-tabs__tab">
          <a class="{{ this.activeTab == index ? 'active' : '' }}"
            @click.prevent="clickTab(tab.name)">
            {{ tab.title }}
          </a>
        </li>
      </ul>
    </blocks-header>
    <list-box
      :events="$root.events"
      :limit.sync="limit"
      :filter-values.sync="filterValues"
      :cols.once="cols"
      :method.once="calcSizesMethod">
    </list-box>
  </div>
</template>

<script>
export default {

  props: {
    title: String,
    limit: Number,
    cols: Number,
    calcSizesMethod: String,
    tabs: {
      type: Array,
      default () {
        return []
      }
    },
    activeTab: {
      type: Number,
      default () {
        return 0
      }
    }
  },

  computed: {
    filterValues() {
      let d = new Date(),
        n = new Date(d.getFullYear(), d.getMonth(), d.getDate() + 13, 23, 59, 59)
      return {
        date_interval: [d, n]
      }
    }
  },

  methods: {
    /**
     * Клик по вкладке недели
     * @param  {String} name Псевдоним вкладки
     */
    clickTab(name) {
      this.$parent.clickWeekTab(name)
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
    }
  }

}
</script>
