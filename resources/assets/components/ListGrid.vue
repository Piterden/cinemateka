<style lang="css">
.mdl-data-table {
  width: 100%;
  border: none;
  font-size: 16px;
}
.mdl-data-table th {
  letter-spacing: .02em;
  font-size: 16px;
  padding: 0 0 10px 5px;
  text-align: left;
  font-weight: bold;
  color: black;
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
tbody .date > div {
  width: 70px;
  margin-right: 15px;
}
tbody .date .seance-date {
  font-size: 23px;
  text-align: right;
}
tbody .date .seance-time {
  width: 68px;
  font-size: 16px;
  text-align: right;
}
tbody .event {
  width: 100%;
}
tbody .event > div {
  margin-left: 5px;
  padding-right: 30px;
}
tbody .event > div a {
  font-size: 23px;
  font-weight: bold;
}
tbody .type > div {
  padding-left: 5px;
  min-width: 150px;
}
tbody .type:after {
  position: absolute;
  right: 0;
  left: 0;
}

tbody .program > div {
  padding-left: 5px;
  min-width: 200px;
}
tbody .program > div a {
  text-decoration: underline;
}
tbody .place > div {
  padding-left: 5px;
  min-width: 160px;
}
tbody .price > div {
  padding-left: 5px;
  min-width: 47px;
}
</style>

<template lang="html">
  <div class="mdl-grid">
    <table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable">
      <thead>
        <tr>
          <th class="id hidden">ID</th>
          <th class="date">Дата</th>
          <th class="event">Событие</th>
          <th class="type">Тип события</th>
          <th class="program">Программа</th>
          <th class="place">Площадка</th>
          <th class="price">Билет</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="seance in seances
            | filterMethod filterValues
            | limitBy limit
            | orderBy 'start_time'"
          track-by="id"
        >
          <td class="id hidden">
            <div class="seance-id">{{ seance.id }}</div>
          </td>
          <td class="date">
            <div class="seance-date">{{ seance.startDate }}</div>
            <div class="seance-time">{{ seance.startTime }}</div>
          </td>
          <td class="event">
            <div>
              <a href="#" v-link="{ path: '/event/' + seance.event.slug }">
                {{ seance.event.title }}
              </a>
            </div>
          </td>
          <td class="type">
            <div>{{ seance.eventTypeName }}</div>
          </td>
          <td class="program">
            <div>
              <a href="#" v-link="{ path: '/program/' + seance.program.slug }">
                {{ seance.program.title }}
              </a>
            </div>
          </td>
          <td class="place">
            <div>
              <a href="#" v-link="{ path: '/contacts/' + seance.place_id }">
                {{ seance.place.title }}
              </a>
            </div>
          </td>
          <td class="price">
            <div>{{ seance.price }} {{{ roubleIcon }}}</div>
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
    filteredCount: Number,
    incrementLimit: {
      type: Number,
      default() {
        return this.limit
      }
    }
  },

  computed: {
    moreVisible() {
      return this.filteredCount > this.limit
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
