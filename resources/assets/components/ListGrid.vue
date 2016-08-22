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
            | orderBy 'start_time'
            | filterMethod filterValues
            | limitBy limit"
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
            <div class="placeWrapper">
              <a href="#" @click.prevent="toggleTooltip(seance.id)">
                {{ seance.place.title }}
                 <i class="fa fa-info-circle" aria-hidden="true"></i>
              </a>
              <div class="hidden" id="tt{{ seance.id }}">
                <div class="place-address" v-if="seance.place.address">
                  <i class="fa fa-map-marker" aria-hidden="true"></i>
                  {{ seance.place.address }}
                </div>
                <div class="place-metro" v-if="seance.place.metro">
                  {{ seance.place.metro }}
                </div>
                <div class="place-site" v-if="seance.place.place_site">
                  <i class="fa fa-globe" aria-hidden="true"></i>
                  <a href="http://{{ seance.place.place_site }}" target="_blank">{{ seance.place.place_site }}</a>
                </div>
                <div class="place-email" v-if="seance.place.place_email">
                  <i class="fa fa-envelope-o" aria-hidden="true"></i>
                  <a href="mailto:{{ seance.place.place_email }}">{{ seance.place.place_email }}</a>
                </div>
                <div class="place-tel" v-if="seance.place.place_phone">
                  <i class="fa fa-mobile" aria-hidden="true"></i>
                  <a href="tel:{{ seance.place.place_phone }}">{{ seance.place.place_phone }}</a>
                </div>
              </div>
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
      default () {
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

    toggleTooltip(sId) {
      let tt = document.getElementById('tt' + sId)
      if (tt.className == 'hidden') {
        tt.className = 'visible'
        setTimeout(() => {
          this.$root.$el.addEventListener('click', this.handleClick)
        }, 0)
      } else {
        tt.className = 'hidden'
        setTimeout(() => {
          this.$root.$el.removeEventListener('click', this.handleClick)
        }, 0)
      }
    },

    handleClick() {
      document.querySelectorAll('[id^="tt"]').forEach((el) => {
        el.className = 'hidden'
      })
      setTimeout(() => {
        this.$root.$el.removeEventListener('click', this.handleClick)
      }, 0)
    }

  },

  filters: {
    filterMethod(seances, method) {
      return this.$parent.filterMethod(seances, method)
    }
  },

  ready() {
  }

}
</script>

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
  color: #000;
}
.mdl-data-table thead th:nth-child(1) {
  display: none;
}
.mdl-data-table tbody {
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
.mdl-data-table tbody tr td:nth-child(1) {
  display: none;
}
.mdl-data-table tbody tr:first-child td {
  border-top-width: 3px;
}
.mdl-data-table tbody .date {
}
.mdl-data-table tbody .date > div {
  width: 70px;
  margin-right: 15px;
}
.mdl-data-table tbody .date .seance-date {
  font-size: 23px;
  text-align: right;
}
.mdl-data-table tbody .date .seance-time {
  width: 68px;
  font-size: 16px;
  text-align: right;
}
.mdl-data-table tbody .event {
  width: 100%;
}
.mdl-data-table tbody .event > div {
  margin-left: 5px;
  padding-right: 30px;
}
.mdl-data-table tbody .event > div a {
  font-size: 23px;
  font-weight: bold;
}
.mdl-data-table tbody .type > div {
  padding-left: 5px;
  min-width: 150px;
}
.mdl-data-table tbody .program > div {
  padding-left: 5px;
  min-width: 200px;
}
.mdl-data-table tbody .program > div a {
  text-decoration: underline;
}
.mdl-data-table tbody .place > div {
  padding-left: 5px;
  min-width: 160px;
}
.mdl-data-table tbody .place > div > div {
  display: inline;
}
.mdl-data-table tbody .price > div {
  padding-left: 5px;
  min-width: 47px;
}
.mdl-tooltip.is-active {
  border: 2px solid #000;
  background-color: white;
  text-align: left;
  border-radius: 0;
  width: 250px;
}
.s-place, .s-place a {
  font-size: 14px;
  color: #000;
}
.s-place-address i {
  font-size: 18px;
}
.s-place-metro {
  margin-left: 15px;
  font-size: 11px;
  margin-top: 5px;
}
.s-place-site  {
  margin-top: 8px;
}
.s-place-email {
  margin-top: 6px;
}
.s-place-tel {
  margin-top: 6px;
}
.s-place-tel i {
  font-size: 22px;
  margin-left: 2px;
  margin-right: 3px;
  vertical-align: middle;
}
.placeWrapper {
  position: relative;
}
.placeWrapper > div {
  position: absolute;
  top: 38px;
  width: 250px;
  left: -120px;
  text-align: left;
  background: #fff;
  border: 3px solid;
  padding: 0 0 15px 0;
  z-index: 1;
}
.placeWrapper > div:after {
  content: '';
  position: absolute;
  width: 15px;
  height: 15px;
  background: #fff;
  border-top: 3px solid;
  border-left: 3px solid;
  transform: rotate(45deg);
  top: -11px;
  left: 181px;
}
</style>
