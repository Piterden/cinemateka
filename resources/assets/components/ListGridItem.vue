<style lang="css">

</style>

<template lang="html">
  <div class="mdl-cell mdl-cell--{{ getCols(method) }}-col"
    v-bind:style="styleObject"
    @click.stop.prevent="$router.go( 'event/' )"
  >
    <div class="date">{{ dateStart }}<br>{{ timeStart }}</div>
    <div class="event">{{ eventName }}</div>
    <div class="type">{{ eventType }}</div>
    <div class="program">{{ programName }}</div>
    <!-- <div class="place">{{ placeName }}</div> -->
    <div class="price">
      {{ item.price | currency '' 0 }} {{{ roubleIcon }}}
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
    item: Object,
    index: Number,
    cols: Number,
    method: String,
    limit: Number,
    height: Number,
    styleObject: {
      type: Object,
      default() {
        return { height: '45px' }
      }
    }
  },

  methods: {
    getCols(m) {
      return this[m]
    }
  },

  computed: {
    dateStart() {
      let d = new Date(this.item.start_time)
      return this.$root.dateStrFromDateObj(d, 'DD.MM')
    },
    timeStart() {
      let d = new Date(this.item.start_time)
      return d.getHours() + ':' + d.getMinutes()
    },
    eventName() {
      this.item.eventItem = this.$root.events.find((e) => {
        return this.item.event_id == e.id
      })
      return this.item.eventItem.title
    },
    eventType() {
      return this.item.eventItem.event_type
    },
    programName() {
      this.item.program = this.$root.programs.find((p) => {
        return this.item.program_id == p.id
      })
      return this.item.program.title
    },
    // placeName() {
    //   this.item.place = this.$root.places.find((pl) => {
    //     return this.item.place_id == pl.id
    //   })
    //   return this.item.place.title
    // },
    /**
     * Получает одинаковые по размерам элементы списка
     * @return {Number} Grid Width
     */
    same() {
      return this.cols
    }
  }
}
</script>
