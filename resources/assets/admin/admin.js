/*****************************************************/
/****************** eslint config ********************/
/*****************************************************/
/*  global events programs places seances categories $ PNotify */
/*****************************************************/
'use strict'

import moment from 'moment'
import Vue from 'vue'
import VueResource from 'vue-resource'
import fullcalendar from 'vue-fullcalendar'

import RepeaterImage from './RepeaterImage.vue'
import RepeaterVideo from './RepeaterVideo.vue'
import RepeaterText from './RepeaterText.vue'
import SelectSeance from './SelectSeance.vue'
import Modal from '../components/Modal.vue'
import DropdownAdmin from './DropdownAdmin.vue'
import Datepicker from './DatepickerAdmin.vue'

// window[Vue] = Vue
Vue.use(VueResource)
Vue.debug = false

// Vue.component('vue-datetime-picker', VueDatetimePicker)
Vue.component('vue-repeater-image', RepeaterImage)
Vue.component('vue-repeater-video', RepeaterVideo)
Vue.component('vue-repeater-text', RepeaterText)
Vue.component('vue-select-seance', SelectSeance)
Vue.component('modal', Modal)
Vue.component('dropdown-admin', DropdownAdmin)
Vue.component('date-picker', Datepicker)
Vue.component('vue-full-calendar', fullcalendar)

new Vue({

  el: 'body#App',

  data() {
    return {
      events: events,
      programs: programs,
      seances: seances,
      categories: categories,
      places: places,
      title: '',
      slug: '',
      fcEvents: [],
      langSets: {
        zh: {
          weekNames: moment.weekdays(),
          monthNames: moment.months(),
          titleFormat: 'MM-yyyy'
        },
      }
    }
  },

  http: {
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  },

  ready() {
    // this.$set('events', this.events.map((event) => {
    //   let seances = this.getSeancesByEventId(event.id),
    //     l = seances.length
    //   event.start = seances && seances[0].start_time
    //   event.end = seances && seances[l - 1].start_time
    //   event.type = 'event'
    //   return event
    // }))
    // this.$set('programs', this.programs.map((program) => {
    //   program.start = program.start_date
    //   program.end = program.end_date
    //   program.type = 'program'
    //   return program
    // }))
    this.$set('seances', this.seances.map((seance) => {
      let event = this.getById(this.events, seance.event_id)
      seance.title = event && event.title + ' '
        + moment(seance.start_time).format('HH-mm')
      seance.start = seance.start_time
      seance.end = seance.start_time
      seance.type = 'seance'
      return seance
    }))
    this.$set('fcEvents', this.seances)
    document.addEventListener('keydown', this.submit)
    this.$watch('title', (nv) => {
      this.$set('slug', this.toTranslit(nv))
    })
  },

  methods: {
    /**
     * Транслит по буквам
     * @param  {String} rus Строка с русскими буквами
     * @return {String}     Транслитерированная строка
     */
    toTranslit(rus) {
      let translit = { 'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh', 'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'shh', 'ъ': '\'', 'ы': 'y', 'ь': '\'', 'э': 'ae', 'ю': 'yu', 'я': 'ya', ' ': '-', '»': '', '«': '' }
      return rus.toLowerCase().split('').map(function(lt) {
        return translit[lt] || lt
      }).join('')
    },

    /**
     * При вводе 'slug' с клавиатуры
     * @param  {Object} e DOM Event Object
     */
    doTranslit(e) {
      let input = e.target
      input.value = this.toTranslit(input.value)
    },

    /**
     * Сеансы для события в хронологическом порядке
     * @param  {Mixed} id
     * @return {Array}
     */
    getSeancesByEventId(id) {
      let a = this.seances.filter((s) => {
        return Number(s.event_id) == Number(id)
      })
      if(a.length > 0) {
        a.sort((a, b) => {
          return moment(a.start_time) > moment(b.start_time)
        })
        return a
      }
      return false
    },

    /**
     * Объект по id
     * @param  {Mixed} id
     * @return {Object} Событие
     */
    getById(arr, id) {
      return arr.find((i) => {
        return Number(i.id) == Number(id)
      })
    },

    /**
     * Уведомления
     * @param  {String} title
     * @param  {String} text
     * @param  {String} type
     */
    fireNotify(title, text, type) {
      new PNotify({
        title: title,
        text: text,
        type: type || 'notice'
      })
    },

    /**
     * Отправка формы
     * @param  {Event} e  DOM event
     */
    submit(e) {
      if(!e.ctrlKey || e.code !== 'KeyS') return
      e.preventDefault()
      let f = document.getElementById('entry-form')
      if(f) {
        $(f).trigger('submit')
      }
    }
  }
})

