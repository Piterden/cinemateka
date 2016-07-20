/*****************************************************/
/****************** eslint config ********************/
/*****************************************************/
/*  global events programs places seances categories */
/*****************************************************/
'use strict'

import moment from 'moment'
import Vue from 'vue'
import VueDatetimePicker from 'vue-datetime-picker'

// import VueResource from 'vue-resource'
// import FullCalendar
//  from './vue/FullCalendar.vue'
// import Navbar from './vue/Navbar.vue'
import RepeaterImage from './RepeaterImage.vue'
import RepeaterVideo from './RepeaterVideo.vue'
import RepeaterText from './RepeaterText.vue'
import SelectSeance from './SelectSeance.vue'

// window[Vue] = Vue
  // Vue.use(VueResource)
Vue.debug = true

// Vue.component('vue-datetime-picker', VueDatetimePicker)
// Vue.component('navbar', Navbar)
Vue.component('vue-repeater-image', RepeaterImage)
Vue.component('vue-repeater-video', RepeaterVideo)
Vue.component('vue-repeater-text', RepeaterText)
Vue.component('vue-select-seance', SelectSeance)

new Vue({
  el: 'body',
  components: {
    'vue-datetime-picker': VueDatetimePicker
  },
  data: {
    events: events,
    programs: programs,
    seances: seances,
    categories: categories,
    places: places,
    result1: null,
    result2: null,
    result3: null,
    startDatetime: moment(),
    endDatetime: null
  },

  props: {
    title: String,
    file: String,
    slug: String,
    imagesJson: Object,
  },

  watch: {
    title(nv) {
      if(this.freezeSlug) return
      this.$set('slug', this.toTranslit(nv))
    }
  },

  methods: {
    /**
     * Транслит по буквам
     * @param  {String} rus Строка с русскими буквами
     * @return {String}     Транслитерированная строка
     */
    toTranslit(rus) {
      let translit = { 'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh', 'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'shh', 'ъ': '\'', 'ы': 'y', 'ь': '._', 'э': 'e-', 'ю': 'yu', 'я': 'ya', ' ': '-' }
      return rus.toLowerCase().split('').map(function(lt) {
        return translit[lt] || lt
      }).join('')
    },
    formatDatetime: function(datetime) {
      if(datetime === null) {
        return '[null]';
      } else {
        return datetime.format('YYYY-MM-DD HH:mm:ss');
      }
    },
    formatDate: function(date) {
      if(date === null) {
        return '[null]';
      } else {
        return date.format('YYYY-MM-DD');
      }
    },
    formatTime: function(time) {
      if(time === null) {
        return '[null]';
      } else {
        return time.format('HH:mm:ss');
      }
    },
    onStartDatetimeChanged: function(newStart) {
      var endPicker = this.$.endPicker.control;
      endPicker.minDate(newStart);
    },
    onEndDatetimeChanged: function(newEnd) {
      var startPicker = this.$.startPicker.control;
      startPicker.maxDate(newEnd);
    },

    /**
     * При вводе 'slug' с клавиатуры
     * @param  {Object} e DOM Event Object
     */
    doTranslit(e) {
      let input = e.target
      input.value = this.toTranslit(input.value)
    },

    // addSeance(e) {
    //   // let $this = $(this),
    //   //   event_id = $this.data('event_id')
    //   // $.colorbox({href:'/admin/seance/create'});
    //   return false;
    // }
    /**
     * Ctrl+S сохранение
     * @param  {Object} e DOM Event Obj
     */
    // doSaveEntry(e) {
    //   if (!e.metaKey && !e.ctrlKey) return
    //   this.save(document.getElementById('entry-form'))
    // },

    // submitEditForm(e) {
    //   this.save(e.target)
    // },

    // save(form) {
    //   this.$http.put(form.action, form.serialize())
    // }
  }

})

