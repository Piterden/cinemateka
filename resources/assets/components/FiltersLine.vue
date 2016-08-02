<style lang="css">

</style>

<template lang="html">
  <ul class="filters-line mdl-grid">
    <li v-for="key in filterShow"
      class="filter {{ key.replace('_','-') }}-filter">
      <toggler
        v-if="isToggler(key)"
        v-show="0"
        :value.sync="filterValues[key]"
        :list.once="filterLists[key]"
      ></toggler>
      <dropdown-list
        v-if="!(isToggler(key) || isDatePicker(key))"
        :input-id="key.replace('_','-')"
        :value.sync="filterValues[key]"
        :list.once="filterLists[key]"
      ></dropdown-list>
    </li>
  </ul>
</template>

<script>
export default {
  props: {
    // Список показываемых фильтров
    filterShow: {
      type: Array,
      default () {
        return []
      }
    },

    // Значения фильтров
    filterValues: {
      type: Object,
      default () {
        return {}
      },
      twoWay: true
    },

    // Списки фильтров
    filterLists: {
      type: Object,
      default () {
        return {}
      }
    }
  },

  methods: {
    isToggler(key) {
      return key == 'now_soon'
    },
    isDatePicker(key) {
      return key == 'date_interval'
    }
  }
}
</script>

