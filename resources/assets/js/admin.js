'use strict'

import Vue from 'vue'
import VueResource from 'vue-resource'
import FullCalendar from './vue/FullCalendar.vue'

Vue.use(VueResource)

Vue.component('full-calendar', FullCalendar)

let $vm = new Vue({
  el: 'body',

  data() {
    return {
      // Коллекции
      events: events,
      programs: programs,
      seances: seances,
      categories: categories,
      places: places,
    }
  },

  props: {
    title: String,
    file: String,
    slug: String,
    imagesJson: Object,
  },

  watch: {
    title(nv, ov) {
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
      let translit = { "а": "a", "б": "b", "в": "v", "г": "g", "д": "d", "е": "e", "ё": "yo", "ж": "zh", "з": "z", "и": "i", "й": "j", "к": "k", "л": "l", "м": "m", "н": "n", "о": "o", "п": "p", "р": "r", "с": "s", "т": "t", "у": "u", "ф": "f", "х": "h", "ц": "c", "ч": "ch", "ш": "sh", "щ": "shh", "ъ": "'", "ы": "y", "ь": "._", "э": "e-", "ю": "yu", "я": "ya", " ": "-" }
      return rus.toLowerCase().split('').map(function(lt) {
        return translit[lt] || lt
      }).join('')
    },

    /**
     * При вводе "slug" с клавиатуры
     * @param  {Object} e DOM Event Object
     */
    doTranslit(e) {
      let input = e.target
      input.value = this.toTranslit(input.value)
    },

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

