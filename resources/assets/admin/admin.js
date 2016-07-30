/*****************************************************/
/****************** eslint config ********************/
/*****************************************************/
/*  global events programs places seances categories $ PNotify */
/*****************************************************/
'use strict'

import moment from 'moment'
import Vue from 'vue'
// import VueDatetimePicker from 'vue-datetime-picker'
import VueResource from 'vue-resource'

// import FullCalendar
//  from './vue/FullCalendar.vue'
import RepeaterImage from './RepeaterImage.vue'
import RepeaterVideo from './RepeaterVideo.vue'
import RepeaterText from './RepeaterText.vue'
import SelectSeance from './SelectSeance.vue'
import Modal from '../components/Modal.vue'
import DropdownAdmin from './DropdownAdmin.vue'
import Datepicker from './DatepickerAdmin.vue'

// window[Vue] = Vue
Vue.use(VueResource)
Vue.debug = true

// Vue.component('vue-datetime-picker', VueDatetimePicker)
Vue.component('vue-repeater-image', RepeaterImage)
Vue.component('vue-repeater-video', RepeaterVideo)
Vue.component('vue-repeater-text', RepeaterText)
Vue.component('vue-select-seance', SelectSeance)
Vue.component('modal', Modal)
Vue.component('dropdown-admin', DropdownAdmin)
Vue.component('date-picker', Datepicker)

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
      slug: ''
    }
  },

  http: {
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  },

  ready() {
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
      let translit = { 'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh', 'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'shh', 'ъ': '\'', 'ы': 'y', 'ь': '', 'э': 'ae', 'ю': 'yu', 'я': 'ya', ' ': '-' }
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

    submit(e) {
      if (!e.ctrlKey || e.code !== 'KeyS') return
      e.preventDefault()
      let f = document.getElementById('entry-form')
      if (f) {
        $(f).trigger('submit')
      }
    }
  }
})

