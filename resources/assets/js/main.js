/**
 * Подключаемые библиотеки
 */
import _ from 'lodash'
import VueMdl from 'vue-mdl'
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
Vue.use(VueMdl)

/**
 * Vue-компоненты страницы
 */
import IndexPage from '../views/IndexPage.vue'
import SchedulePage from '../views/SchedulePage.vue'
import ArchivePage from '../views/ArchivePage.vue'
import AboutPage from '../views/AboutPage.vue'
import ContactsPage from '../views/ContactsPage.vue'
import EventPage from '../views/EventPage.vue'
import ProgramPage from '../views/ProgramPage.vue'
import Error404 from '../views/Error-404.vue'

/**
 * Vue-компоненты блоки
 */
import Swipe from '../components/Swipe.vue'
import SwipeItem from '../components/SwipeItem.vue'
import IndexPageEvents from '../components/IndexPageEvents.vue'
import IndexPageSoon from '../components/IndexPageSoon.vue'
import BlocksHeader from '../components/BlocksHeader.vue'
import ListBox from '../components/ListBox.vue'
import ListBoxItem from '../components/ListBoxItem.vue'
import ListGrid from '../components/ListGrid.vue'
import ListGridItem from '../components/ListGridItem.vue'
import FiltersLine from '../components/FiltersLine.vue'
import DropdownList from '../components/DropdownList.vue'
import Toggler from '../components/Toggler.vue'
import Datepicker from '../components/Datepicker.vue'
import DatePickers from '../components/DatePickers.vue'
// import GridLoader from '../components/GridLoader.vue'

/**
 * !!!!!!!! Used EcmaScript5 inside !!!!!!!!!
 * Возвращает минимальное значение массива
 * @method min        Применяется к любому массиву JS
 * @return {Mixed}
 */
Array.prototype.min = function() {
  return Math.min.apply(null, this);
};

/**
 * !!!!!!!! Used EcmaScript5 inside !!!!!!!!!
 * Удаляет повторения из массива
 * @method getUnique  Применяется к любому массиву JS
 * @return {Array}
 */
Array.prototype.getUnique = function() {
  var u = {},
    a = [];
  for(var i = 0, l = this.length; i < l; ++i) {
    if(u.hasOwnProperty(this[i])) {
      continue;
    }
    a.push(this[i]);
    u[this[i]] = 1;
  }
  return a;
};

/**
 * !!!!!!!! Used EcmaScript5 inside !!!!!!!!!
 * Делает из массива вида:
 * [ [a, b, c], [d, e, f], [g, h, j] ]
 * Вот такой:
 * [ a, b, c, d, e, f, g, h, j ]
 * @method getUnique  Применяется к любому массиву JS
 * @return {Array}
 */
Array.prototype.collapse = function() {
  var a = [];
  for(var i = 0, l = this.length; i < l; ++i) {
    if(
      this[i] !== undefined &&
      this[i].hasOwnProperty('length') &&
      this[i].length > 0
    ) {
      this[i].forEach(function(el) {
        a.push(el);
      });
    }
  }
  return a;
};

/**
 * Регистрация компонентов - html-элементов
 */
Vue.component('swipe', Swipe)
Vue.component('swipe-item', SwipeItem)
Vue.component('index-page-events', IndexPageEvents)
Vue.component('index-page-soon', IndexPageSoon)
Vue.component('blocks-header', BlocksHeader)
Vue.component('list-box', ListBox)
Vue.component('list-box-item', ListBoxItem)
Vue.component('list-grid', ListGrid)
Vue.component('list-grid-item', ListGridItem)
Vue.component('filters-line', FiltersLine)
Vue.component('dropdown-list', DropdownList)
Vue.component('toggler', Toggler)
Vue.component('datepicker', Datepicker)
Vue.component('date-pickers', DatePickers)
  // Vue.component('grid-loader', BlocksHeader)

/**
 * Главный ($root) vue-компонент.
 * Доступ к App instance из любого места в файлах-компонентах *.vue
 * осуществляется через объекты "this.$root" или "this.$router.app"
 */
let App = Vue.extend({
  /**
   * Здесь задаются данные, которые будут доступны, глобальные для всего
   * приложения через root-объект. Сюда подгружаются данные из PHP.
   */
  data() {
    return {
      /**
       * Все события
       * @type {Array} of EventObjects
       */
      events: events,
      /**
       * Все программы
       * @type {Array} of ProgramObjects
       */
      programs: programs,
      /**
       * Все места
       * @type {Array} of SeanceObjects
       */
      places: places,
      /**
       * Все типы событий и категории
       * @type {Array} of SeanceObjects
       */
      categories: categories,
      /**
       * Все сеансы
       * @type {Array} of SeanceObjects
       */
      seances: seances
    }
  },

  created() {
    this.events.map((elem) => {
      elem.seances = this.seances.reduce((prev, curr, idx, arr) => {
        if(elem.id == curr.event_id) {
          prev.push(curr)
        }
        return prev
      }, [])
      return elem
    })
  },

  ready() {
    /**
     * По готовности удаляем коллекции данных из глобальной области видимости.
     * Они закешированы в переменных компонента.
     */
    delete window['events']
    delete window['seances']
    delete window['programs']
    delete window['places']
    delete window['categories']
  },

  computed: {
    /**
     *
     * @return {Array}
     */

  },

  /**
   * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
   * ==================================================================
   *     Глобальные Методы
   * ==================================================================
   * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
   */
  methods: {
    /**
     *
     * @return {Array}
     */
    seancesByEventId(id) {
      return this.seances.filter((s) => {
        return s.event_id == id
      })
    },

    /**
     *
     * @return {Array}
     */
    seancesByProgramId(id) {
      return this.seances.filter((s) => {
        return s.program_id == id
      })
    },

    /**
     *
     * @return {Array}
     */
    categoryNameById(id) {
      return this.categories.filter((c) => {
        return c.id == id
      }).name
    },

    /**
     * Генерирует не повторяющийся список годов
     * соответствующих датам всех сеансов
     * @return {Array}
     */
    getExistedYears() {
      return this.events.map((ev) => {
        return ev.seances.map((s) => {
          let d = new Date(s.start_time)
          return String(d.getFullYear())
        }).getUnique()
      }).collapse().getUnique()
    },

    /**
     * Хранит список месяцев
     * @return {Array}
     */
    getMonthNames() {
      return ["Январь", "Февраль", "Март", "Апрель",
        "Май", "Июнь", "Июль", "Август", "Сентябрь",
        "Октябрь", "Ноябрь", "Декабрь"
      ]
    },

    /**
     * Хранит список дней недели
     * @return {Array}
     */
    getWeekDaysNames() {
      return ["Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"]
    },

    /**
     * Названия типов событий
     * @return {Array} Массив без повторов
     */
    getEventTypes() {
      let def = ['Все события'],
        cc = this.categories.map((c) => {
          return c.name
        })
      return def.concat(cc)
    },

    /**
     * Объект названий типов событий
     * @return {Object} {key: name}
     */
    getCatAssoc() {
      let assoc = {}
      this.categories.forEach((c) => {
        assoc[c.id] = c.name
      })
      return assoc
    },

    /**
     * Значения переключателя "Сейчас/Скоро"
     * @return {Array}
     */
    getNowSoones() {
      return ['сейчас', 'скоро']
    },

    /**
     * Получает массив ID программ для конкретного
     * события через связь Событие-Сеансы-Программа
     * @param   {Object}  e   Объект события
     * @return  {Array}       Массив ID программ
     */
    getPrograms(e) {
      // Возвращаем измененный массив сеансов
      return e.seances.map((seance) => {
          // Ищем программу для каждого сеанса по ID
          let progInArray = this.programs.filter((prog) => {
              return prog.id == seance.program_id
            })
            // Возвращаем ID программы вместо объекта сеанса
          return progInArray[0].id
        }).getUnique() // Исключаем повторения
    },

    /**
     * Получает список мест проведения для события
     * или для всех событий
     * @param  {Object} eventObject   EventObject
     * @return {Array}                Places
     */
    getEventPlaces(eventObject) {
      if(eventObject === undefined) {
        return this.events.map((ev) => {
          ev.seances.map((s) => {
            return s.place
          }).getUnique()
        }).collapse().getUnique()
      }
      return eventObject.seances.map((s) => {
        return s.place
      }).getUnique()
    },

    /**
     * Получает список мест проведения для программы
     * или для всех программ
     * @param  {Object} e     EventObject
     * @return {Array}        Places
     */
    // getProgramPlaces(p) {
    //   if (p === undefined) {
    //     return this.programs.map((pr) => {
    //       return pr.seances.map((s) => {
    //         return s.place
    //       }).getUnique()
    //     }).collapse().getUnique()
    //   }
    //   return p.seances.map((s) => {
    //     return s.place
    //   }).getUnique()
    // },

    /**
     * Список из 12 месяцев начиная с
     * текущего для компонента "Скоро" (Главная)
     */
    getMonthTabsList() {
      let mn = this.getMonthNames(),
        d = new Date(),
        nn = mn.splice(d.getMonth()).concat(mn)
      return nn.map((m, i) => {
        let num = this.$children[0].getSoonTabMonth(i)
        return {
          name: 'month' + i,
          year: this.$children[0].getSoonTabYear(i),
          title: this.getMonthNames()[num].slice(0, 3)
        }
      })
    },

    /**
     * Возвращает наиболее подходящую программу
     * если их несколько у события
     * @param  {EventObject}   e    Объект события
     * @return {ProgramObject}      Объект программы
     */
    getRecentProgram(e) {
      // @TODO
      return this.getPrograms(e)[0]
    },

    /**
     * ================================================================
     * Форматирование данных
     * ================================================================
     */
    /**
     * Возвращает объект даты конца недели по
     * строке даты понедельника этой недели
     */
    getSunday(d) {
      let s = new Date(d)

      s.setDate(s.getDate() + 6)
      s.setHours(23, 59, 59, 999)

      return s
    },

    /**
     * Возвращает объект даты начала недели по
     * любой дате внутри этой недели
     */
    getMonday(d) {
      let day = d.getDay(),
        diff = d.getDate() - day + (day == 0 ? -6 : 1)

      d.setDate(diff)
      d.setHours(0, 0, 0, 0)

      return d
    },

    parse(str) {
      let time = new Date(str)

      return isNaN(time.getTime()) ? null : time
    },

    /**
     * Форматирует дату в строку
     * @param  {Date}   time    Объект даты
     * @param  {Date}   format  Маска формата
     * @return {String}
     */
    stringify(time = new Date(), format = 'YYYY-MM-DD') {
      let year = time.getFullYear(),
        month = time.getMonth() + 1,
        date = time.getDate(),
        monthName = this.getMonthNames()[time.getMonth()],
        map = {
          YYYY: year,
          YY: String(year).slice(2),
          MMM: monthName,
          MM: ('0' + month).slice(-2),
          M: month,
          DD: ('0' + date).slice(-2),
          D: date
        }

      return format.replace(/Y+|M+|D+/g, (str) => {
        return map[str]
      })
    }
  },


});

/**
 * Совмещает 2 объекта в один, перезаписывая вторым первый
 * @private
 * @param {Object}    Умолчания (что заполнять)
 * @param {Object}    Новые свойства (чем заполнять)
 * @returns {Object}  Результат
 */
App.prototype.extend = function(defaults, options) {
  var extended = {},
    prop;
  for(prop in defaults) {
    if(Object.prototype.hasOwnProperty.call(defaults, prop)) {
      extended[prop] = defaults[prop];
    }
  }
  for(prop in options) {
    if(Object.prototype.hasOwnProperty.call(options, prop)) {
      extended[prop] = options[prop];
    }
  }
  return extended;
};

/**
 * Конфигурация роутера
 * @param  {Boolean}  hashbang
 * @param  {Boolean}  history
 * @param  {String}   linkActiveClass
 * @param  {String}   mode
 * @param  {Boolean}  saveScrollPosition
 * @param  {Boolean}  transitionOnLoad
 */
let router = new VueRouter({
  hashbang: false,
  history: true,
  linkActiveClass: 'active',
  mode: 'html5',
  saveScrollPosition: true,
  transitionOnLoad: true,
})

Vue.config.debug = true

/**
 * ================================================================
 * Назначение маршрутов роутеру
 * ================================================================
 */
router.map({

  '*': {
    component(resolve) {
      resolve(Vue.component('error-404', Error404))
    }
  },

  // Главная
  '/': {
    component(resolve) {
      resolve(Vue.component('index-page', IndexPage))
    }
  },

  // Расписание
  '/schedule': {
    component(resolve) {
      resolve(Vue.component('schedule-page', SchedulePage))
    },
    subRoutes: {
      '/:page': {
        component(resolve) {
          resolve(Vue.component('schedule-page', SchedulePage))
        }
      }
    }
  },

  // Архив
  '/archive': {
    component(resolve) {
      resolve(Vue.component('archive-page', ArchivePage))
    },
    subRoutes: {
      '/:page': {
        component(resolve) {
          resolve(Vue.component('archive-page', ArchivePage))
        }
      }
    }
  },

  // О проекте
  '/about': {
    component(resolve) {
      resolve(Vue.component('about-page', AboutPage))
    }
  },

  // Контакты
  '/contacts': {
    component(resolve) {
      resolve(Vue.component('contacts-page', ContactsPage))
    }
  },

  // Событие
  '/event/:slug': {
    component(resolve) {
      resolve(Vue.component('event-page', EventPage))
    }
  },

  // Программа
  '/program/:slug': {
    component(resolve) {
      resolve(Vue.component('program-page', ProgramPage))
    }
  }
})

/**
 * Init Vue Router instance
 * Запускаем роутер и приложение
 */
router.start(App, 'body#App')

