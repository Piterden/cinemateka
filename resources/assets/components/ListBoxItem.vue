<style lang="css">
.fade-transition {
  transition: opacity .3s ease;
}
.fade-enter, .fade-leave {
  opacity: 0;
}
</style>
<template lang="html">
  <div class="mdl-cell mdl-cell--{{ getCols(method) }}-col"
    :style="styleObject"
    transition="fade"
    transition-mode="out-in"
  >
    <div class="event-item-card" :style="bgStyleObject" v-if="item.slug">
      <a href="#" v-link="{ path: '/event/' + item.slug }">
        <div class="category">{{ eventTypeName }}</div>
      </a>
      <a href="#" v-link="{ path: '/event/' + item.slug }">
        <div class="bluncardy"></div>
      </a>
      <div class="bottom-block">
        <a href="#" v-link="{ path: '/event/' + item.slug }">
          <div class="dates">
            {{{ getSpendingRange() }}}
          </div>
          <div class="title">
              <h3>{{ item.title }}</h3>
          </div>
        </a>
        <div class="program" v-if="entity === 'event'">
          <div v-if="closestProgram">
            <a href="#" v-link="{ path:'/program/' + closestProgram.slug }">
              {{ closestProgram.title }}
            </a>
          </div>
        </div>
        <div v-else>
          <div v-if="closestEvent">
            <a href="#" v-link="{ path:'/event/' + closestEvent.slug }">
              {{ closestEvent.title }}
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from 'moment'
moment.locale('ru-RU')

export default {

  data() {
    let catId = this.item ? this.item.category_id : 0,
      cat = this.$root.getCategoryById(catId)
    return {
      eventTypeName: cat && cat.name
    }
  },

  props: {
    item: Object,
    index: Number,
    cols: Number,
    method: String,
    limit: Number,
    height: Number,
    separator: { type: String, default: '&ndash;' },
    styleObject: { type: Object, default: 'inherit' },
    entity: { type: String, default: 'event' }
  },

  computed: {
    closestProgram() {
      let programIds = this.$root.getEventProgramsIds(this.item)
      return this.$root.getClosestSeanceProgram(this.item)
        || this.$root.getById(this.$root.programs, programIds[0])
    },
    closestEvent() {
      return this.$root.getClosestSeanceEvent(this.item)
    },
    bgStyleObject() {
      return this.thumb ? {
        backgroundImage: 'url("/' + this.thumb + '")'
      } : {}
    },
    /**
     * Изображение плитки
     */
    thumb() {
      return this.item && this.item.images && JSON.parse(this.item.images).mainimage
    },
    /**
     * Вычисляет ширину элемента списка в кол-ве колонок
     * Одинаковая ширина для всех элементов кроме отмеченных в админке
     * @return {Number}
     */
    same() {
      let wide = this.item && this.item.wide || '0'
      return wide != '1' ? this.cols : this.cols * 2
    }
  },

  methods: {
    /**
     * Получает строку из 2 дат - первого и последнего сеанса события, через '-'
     */
    getSpendingRange() {
      if (this.item === undefined) return ''
      let seances = this.item.seances || [],
        start, end, formatted_start, formatted_end
      if (!seances.length) {
        return ''
      }
      start = moment(seances[0].start_time)
      if (seances.length > 1) {
        end = moment(seances[seances.length - 1].start_time)
      } else {
        end = start.clone()
      }
      if (end.diff(start, 'year') >= 1) {
        formatted_start = moment(start).format('DD.MM.YY')
        formatted_end = moment(end).format('DD.MM.YY')
      } else {
        formatted_start = moment(start).format('DD.MM')
        formatted_end = moment(end).format('DD.MM')
      }
      return (formatted_start == formatted_end)
        ? formatted_start
        : formatted_start + this.separator + formatted_end
    },

    getCols(method) {
      return this[method]
    }
  }

}
</script>

