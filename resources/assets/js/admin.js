var FullCalendar = Vue.extend({
  name: 'full-calendar',
  template: '<div id="fullCalendar"></div>',

  data() {
    return {
      seances: seances.map((s) => {
        return {
          id: 's' + s.id,
          title: s.event.title,
          start: s.start_time,
          allDay: false
        }
      }),
      programs: programs.map((p) => {
        return {
          id: 'p' + p.id,
          title: p.title,
          start: p.seances[0].start_time,
          end: p.seances[p.seances.length - 1].start_time,
          allday: true
        }
      }),
      events: events.map((e) => {
        return {
          id: 'e' + e.id,
          title: e.title,
          start: e.seances[0].start_time,
          end: e.seances[e.seances.length - 1].start_time,
          allday: true
        }
      })
    }
  },

  ready() {
    $('#fullCalendar').fullCalendar({
      eventSources: [{
        events: this.seances,
        color: 'green',
        textColor: 'white',
        editable: true,
        startEditable: true
      }, {
        events: this.programs,
        color: 'black',
        textColor: 'yellow',
        rendering: 'background',
        editable: true,
        startEditable: true,
        durationEditable: true
      }, {
        events: this.events,
        color: 'black',
        textColor: 'yellow',
        rendering: 'background',
        editable: true,
        startEditable: true,
        durationEditable: true
      }]
    })
  }

})

var $vm = new Vue({
  el: 'body',

  data() {
    return {
      title: '',
      file: '',
      imagesJson: {},
    }
  },

  computed: {
    slug() {
      return this.toTranslit(this.title)
    }
  },

  methods: {
    toTranslit(rus) {
      var translit = { "а": "a", "б": "b", "в": "v", "г": "g", "д": "d", "е": "e", "ё": "yo", "ж": "zh", "з": "z", "и": "i", "й": "j", "к": "k", "л": "l", "м": "m", "н": "n", "о": "o", "п": "p", "р": "r", "с": "s", "т": "t", "у": "u", "ф": "f", "х": "h", "ц": "c", "ч": "ch", "ш": "sh", "щ": "shh", "ъ": "'", "ы": "y", "ь": "._", "э": "e-", "ю": "yu", "я": "ya", " ": "-" }
      return rus.toLowerCase().split('').map(function(lt) {
        return translit[lt] || lt
      }).join('')
    },
    doTranslitByLetters(val, event) {
      console.log(val);
    }
  },

  components: {
    FullCalendar,
  }

})
