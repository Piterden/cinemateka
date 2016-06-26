<style lang="css" scoped>
</style>

<template>
  <div class="events-block">
    <blocks-header :title="title">
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
      :limit.sync="limit"
      :filter-values.sync="filterValues"
      :cols.once="cols"
      :method.once="calcSizesMethod">
    </list-box>
  </div>
</template>

<script>
export default {

  data() {
    return {
      events: this.$root.events || [],
      programs: this.$root.programs || []
    };
  },

  props: {
    title: String,
    limit: Number,
    cols: Number,
    calcSizesMethod: String,
    tabs: {
      type: Array,
      default() {
        return [];
      }
    },
    activeTab: {
      type: Number,
      twoWay: true
    },
    filterValues: {
      type: Object,
      twoWay: true,
      default() {
        return {};
      }
    }
  },

  methods: {
    
    clickTab(name) {
      this.$parent.clickWeekTab(name);
    },

    /**
		 * Фильтрует события по заданным значениям
		 * @param  {Array}        events    Все события
		 * @param  {Object}       filters   Фильтры со значениями
		 * @return {Array} of Event Objects
		 */
		filterMethod(events, filters) {

		  return events;
		}
  },

  watch: {
    activeTab(v) {
      let fv = this.$root.extend(
        this.$get('filterValues'),
        {date_interval: this.date_interval}
      );
      this.$set('filterValues', fv);
    }
  },

  computed: {
    date_interval() {
      return [
        this.$root.getMonday(this.$parent.getTabDate(this.activeTab)),
        this.$root.getSunday(this.$parent.getTabDate(this.activeTab))
      ];
    }
  }

};

</script>
