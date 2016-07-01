<style lang="css">
.mdl-data-table {
  width: 100%;
  border: none;
}
.mdl-data-table th {
  letter-spacing: .02em;
  font-size: 14px;
  padding: 0 0 10px 5px;
  text-align: left;
}
.mdl-data-table tbody tr {
  height: 100px;
}
.mdl-data-table tbody tr td {
  padding-right: 0;
  padding-left: 0;
  padding-top: 0;
  padding-bottom: 0;
  border-top-width: 0;
  border-bottom: none;
  white-space: normal;
  text-align: left;
}
.mdl-data-table tbody tr:first-child td {
  border-top-width: 3px;
}
.seance-date {

}
.seance-time {

}
tbody .event > div {

}
tbody .type > div {

}
tbody .program > div {

}
tbody .place > div {

}
tbody .price > div {

}

</style>

<template lang="html">
  <div class="mdl-grid">
    <table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable">
      <thead>
        <tr>
          <th class="date">
            Дата
          </th>
          <th class="event">
            Событие
          </th>
          <th class="type">
            Тип события
          </th>
          <th class="program">
            Программа
          </th>
          <th class="place">
            Площадка
          </th>
          <th class="price">
            Билет
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="seance in seances
            | filterMethod filterValues
            | limitBy limit
            | orderBy 'start_time'"
        >
          <td class="date">
            <div class="seance-date">
              {{ seance.startDate }}
            </div>
            <div class="seance-time">
              {{ seance.startTime }}
            </div>
          </td>
          <td class="event">
            <div>
              {{ seance.event.title }}
            </div>
          </td>
          <td class="type">
            <div>
              {{ seance.eventTypeName }}
            </div>
          </td>
          <td class="program">
            <div>
              {{ seance.program.title }}
            </div>
          </td>
          <td class="place">
            <div>
              {{ seance.place.title }}
            </div>
          </td>
          <td class="price">
            <div>
              {{ seance.price }} {{{ roubleIcon }}}
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="show-more-block mdl-cell mdl-cell--12-col"
      v-show="moreVisible"
    >
      <a class="show-more-btn"
        @click="showMore"
      >Показать еще</a>
    </div>
  </div>
</template>

<script>
export default {

  data() {
    return {
      roubleIcon: '<i class="fa fa-rub"></i>'
    }
  },

  props: {
    seances: Array,
    limit: Number,
    cols: Number,
    method: String,
    filterValues: Object,
    incrementLimit: {
      type: Number,
      default() {
        return this.limit
      }
    }
  },

  computed: {
    moreVisible() {
      return true
    }
  },

  methods: {
    /**
     * Добавляет элементы к таблице
     */
    showMore() {
      this.limit += this.incrementLimit
    },

  },

  filters: {
    filterMethod(seances, method) {
      return this.$parent.filterMethod(seances, method)
    }
  }

}
</script>
