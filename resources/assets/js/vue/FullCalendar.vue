<style lang="css" scoped>
</style>
<template>
  <div id="fullCalendar">
  </div>
</template>
<script>
export default {

  data() {
    return {
      seances: this.$root.seances.map((s) => {
        return {
          id: 's' + s.id,
          title: s.event.title,
          start: s.start_time,
          allDay: false
        }
      }),
      programs: this.$root.programs.map((p) => {
        let pss = this.getSeancesByProgramId(p.id)
        return {
          id: 'p' + p.id,
          title: p.title,
          start: pss[0].start_time,
          end: pss[pss.length - 1].start_time,
          allday: true
        }
      }),
      events: this.$root.events.map((e) => {
        let ess = this.getSeancesByEventId(e.id)
        return {
          id: 'e' + e.id,
          title: e.title,
          start: ess[0].start_time,
          end: ess[ess.length - 1].start_time,
          allday: true
        }
      })
    }
  },

  methods: {
    /**
     *
     * @return {Array}
     */
    getSeancesByEventId(id) {
      return this.seances.filter((s) => {
        return s.event_id == id
      })
    },

    /**
     *
     * @return {Array}
     */
    getSeancesByProgramId(id) {
      return this.seances.filter((s) => {
        return s.program_id == id
      })
    },
  },

  ready() {
    // console.log($(document.getElementById('fullCalendar')))
    // .fullCalendar({
    //   eventSources: [{
    //     events: this.seances,
    //     color: 'green',
    //     textColor: 'white',
    //     editable: true,
    //     startEditable: true
    //   }, {
    //     events: this.programs,
    //     color: 'black',
    //     textColor: 'yellow',
    //     rendering: 'background',
    //     editable: true,
    //     startEditable: true,
    //     durationEditable: true
    //   }, {
    //     events: this.events,
    //     color: 'black',
    //     textColor: 'yellow',
    //     rendering: 'background',
    //     editable: true,
    //     startEditable: true,
    //     durationEditable: true
    //   }]
    // })
  }

}
</script>
