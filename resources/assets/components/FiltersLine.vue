<style lang="css">

</style>

<template lang="html">
  <ul class="filters-line mdl-grid">
    <li v-for="key in filterShow"
      class="filter {{ key.replace('_','-') }}-filter">
      <!-- <div v-if="key == 'event_type'" class="label">Показать</div>
      <div v-if="key == 'month'" class="label">за</div> -->
      <dropdown-list
        :input-id="key.replace('_','-')"
        :value.sync="filterValues[key]"
        :list.once="filterLists[key]">
      </dropdown-list>
    </li>
  </ul>
</template>

<script>
export default {
  props: {
    // Список показываемых фильтров
    filterShow: {
      type: Array,
      default() {
        return [];
      }
    },

    // Значения фильтров
    filterValues: {
      type: Object,
      default() {
        return {};
      },
      twoWay: true
    },

    // Списки фильтров
    filterLists: {
      type: Object,
      default() {
        return {};
      }
    }
  }
};
</script>
