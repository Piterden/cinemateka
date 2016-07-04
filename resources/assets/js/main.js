/**
 * Подключаемые библиотеки
 */
import _ from 'lodash'
import VueMdl from 'vue-mdl'
import Vue from 'vue'
import VueRouter from 'vue-router'

/**
 * Google Maps Components
 */
import {load, loaded, Map, Marker} from 'vue-google-maps'
load('AIzaSyCrukK_xKPenGQkn9okGUjoBfECOeiOvSc', '3.25.7')

/**
 * Плагины Vue
 */
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
 * Vue-компоненты элементы
 */
import Swipe from '../components/Swipe.vue'
import SwipeItem from '../components/SwipeItem.vue'
import IndexPageEvents from '../components/IndexPageEvents.vue'
import IndexPageSoon from '../components/IndexPageSoon.vue'
import BlocksHeader from '../components/BlocksHeader.vue'
import ListBox from '../components/ListBox.vue'
import ListBoxItem from '../components/ListBoxItem.vue'
import ListGrid from '../components/ListGrid.vue'
import GridLoader from '../components/GridLoader.vue'
import ListPlaces from '../components/ListPlaces.vue'
import ListPlacesItem from '../components/ListPlacesItem.vue'
import FiltersLine from '../components/FiltersLine.vue'
import DropdownList from '../components/DropdownList.vue'
import Toggler from '../components/Toggler.vue'
import Datepicker from '../components/Datepicker.vue'
import DatePickers from '../components/DatePickers.vue'

// Dev ops.
Vue.config.debug = true
// console.log(Vue.config);

// Расширение объекта Array
import Array from './inc.js'

/**
 * Регистрация vue-компонентов === html-элементов
 */
Vue.component('swipe', Swipe)
Vue.component('swipe-item', SwipeItem)
Vue.component('index-page-events', IndexPageEvents)
Vue.component('index-page-soon', IndexPageSoon)
Vue.component('blocks-header', BlocksHeader)
Vue.component('list-box', ListBox)
Vue.component('list-box-item', ListBoxItem)
Vue.component('list-grid', ListGrid)
Vue.component('grid-loader', GridLoader)
Vue.component('list-places', ListPlaces)
Vue.component('list-places-item', ListPlacesItem)
Vue.component('filters-line', FiltersLine)
Vue.component('dropdown-list', DropdownList)
Vue.component('toggler', Toggler)
Vue.component('datepicker', Datepicker)
Vue.component('date-pickers', DatePickers)

// Google Maps Components Registration
Vue.component('map', Map)
Vue.component('marker', Marker)
// Vue.component('place-input', PlaceInput)

/**
 * Главный ($root) vue-компонент.
 * Доступ к App instance из любого места в файлах-компонентах *.vue
 * осуществляется через объекты "this.$root" или "this.$router.app"
 */
let App = Vue.extend({
  /**
   * Здесь задаются коллекции, которые будут доступны, глобальные для всего
   * приложения через root-объект. Сюда подгружаются данные из PHP.
   */
  props: {
     // Все события         // @type {Array} of EventObjects
    events: { type: Array, default() { return events } },

     // Все программы       // @type {Array} of ProgramObjects
    programs: { type: Array, default() { return programs } },

     // Все места           // @type {Array} of SeanceObjects
    places: { type: Array, default() { return places } },

     // Все типы событий    // @type {Array} of SeanceObjects
    categories: { type: Array, default() { return categories } },

     // Все сеансы          // @type {Array} of SeanceObjects
    seances: { type: Array, default() { return seances } },
  },

  created() {
    /**
     * Записываем связи в объекты событий и программ
     */
    this.events = events.map((e) => {
      let cat = this.getCategoryById(e.category_id)
      e.seances = this.getSeancesByEventId(e.id)
      e.event_type = cat && cat.name
      return e
    })
    this.programs = programs.map((p) => {
      p.seances = this.getSeancesByProgramId(p.id)
      return p
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

  /**
   * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
   * ==================================================================
   *  ГЛОБАЛЬНЫЕ МЕТОДЫ
   * ==================================================================
   * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
   */
  methods: {
    /**!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * ================================================================
     *  МЕТОДЫ СВЯЗАННЫХ ОБЪЕКТОВ
     * ================================================================
     *!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
    /**
     * Возвращает ближайший сеанс
     * @param  {EventObject}   e    Объект события
     * @return {ProgramObject}      Объект программы
     */
    getClosestSeance(e) {
      return e && e.seances.find((s) => {
        return new Date(s.start_time) > new Date()
      })
    },

    /**
     * Возвращает программу ближайшего сеанса
     * @param  {EventObject}   e    Объект события
     * @return {ProgramObject}      Объект программы
     */
    getClosestSeanceProgram(e) {
      let cs = this.getClosestSeance(e)
      return cs && cs !== -1 && this.programs.find((p) => {
        return Number(p.id) == Number(cs.program_id)
      })
    },

    /**
     * Возвращает площадку ближайшего сеанса
     * @param  {EventObject}   e    Объект события
     * @return {ProgramObject}      Объект программы
     */
    getClosestSeancePlace(e) {
      let cs = this.getClosestSeance(e)
      return cs && this.places.find((p) => {
        return Number(p.id) == Number(cs.place_id)
      })
    },

    /**
     * Возвращает индекс элемента в коллекции по
     * @param  {EventObject}   e    Объект события
     * @return {ProgramObject}      Объект программы
     */
    getIndexById(arr = [], id = 0) {
      return arr.findIndex((el) => {
        return Number(el.id) == Number(id)
      })
    },

    /**
     * Объект программы по id
     * @param  {Number} id
     * @return {Object} Программа
     */
    getProgramById(id = 0) {
      return id && this.programs.find((p) => {
        return Number(p.id) == Number(id)
      })
    },

    /**
     * Объект события по id
     * @param  {Mixed} id
     * @return {Object} Событие
     */
    getEventById(id) {
      return this.events.find((e) => {
        return Number(e.id) == Number(id)
      })
    },

    /**
     * Объект события по id
     * @param  {Mixed} id
     * @return {Object} Событие
     */
    getPlaceById(id) {
      return this.places.find((e) => {
        return Number(e.id) == Number(id)
      })
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
          return new Date(a.start_time) > new Date(b.start_time)
        })
        return a
      }
      return false
    },

    /**
     * Сеансы для программы в хронологическом порядке
     * @param  {Mixed} id
     * @return {Array}
     */
    getSeancesByProgramId(id) {
      let a = this.seances.filter((s) => {
        return Number(s.program_id) === Number(id)
      })
      if (a.length > 0) {
        a.sort((a, b) => {
          return new Date(a.start_time) > new Date(b.start_time)
        })
        return a
      }
      return false
    },

    /**
     * Имя типа (категории) события
     * @param  {Mixed} id
     * @return {String}
     */
    getCategoryById(id) {
      return this.categories.find((c) => {
        return Number(c.id) === Number(id)
      })
    },

    /**
     * Получает массив ID программ для конкретного
     * события через связь Событие-Сеансы-Программа
     * @param   {Object}  e   Объект события
     * @return  {Array}       Массив ID программ
     */
    getEventProgramsIds(e) {
      return e.seances.map((s) => {
        return Number(s.program_id)
      }).getUnique()
    },

    /**
     * Получает список id мест проведения для события или программы,
     * а если не указан объект, то для всех событий и программ.
     * @param  {Object} eventObj|programObj
     * @return {Array}
     */
    getEventPlacesIds(o) {
      if(o === undefined) {
        return this.seances.map((s) => {
          return Number(s.place_id)
        }).getUnique()
      }
      if(!o.seances ||
        o.seances.length === undefined ||
        o.seances.length < 1
      ) return []
      return o.seances.map((s) => {
        return Number(s.place_id)
      }).getUnique()
    },

    getProgramEvents(p) {
      let eIds = p.seances.map((s) => {
        return s.event_id
      }).getUnique()
      return eIds.map((id) => {
        return this.getEventById(id)
      })
    },

    /**
     * Получает событие по псевдониму
     * @param  {String} slug          Псевдоним события из url
     * @return {Boolean}
     */
    getEventBySlug(slug) {
      return this.events.find((e) => {
        return e.slug == slug
      })
    },

    /**
     * Получает программу по псевдониму
     * @param  {String} slug          Псевдоним программы из url
     * @return {Boolean}
     */
    getProgramBySlug(slug) {
      return this.programs.find((p) => {
        return p.slug == slug
      })
    },

    /**!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * ==================================================================
     *  ГЕНЕРАЦИЯ СПИСКОВ ДЛЯ ФИЛЬТРОВ
     * ==================================================================
     *!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
    /**
     * Генерирует не повторяющийся список годов
     * соответствующих датам всех сеансов
     * @return {Array}
     */
    getExistedYears() {
      return this.events.map((ev) => {
        return ev.seances.map((s) => {
          let d = new Date(s.start_time)
          return Number(d.getFullYear())
        }).getUnique()
      }).collapse().getUnique().sort((a, b) => {
        return a > b
      })
    },

    /**
     * Хранит список месяцев
     * @return {Array}
     */
    getMonthNames() {
      return [
        'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль',
        'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
      ]
    },

    /**
     * Хранит список дней недели
     * @return {Array}
     */
    getWeekDaysNames() {
      return ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс']
    },

    /**
     * Названия типов событий для фильтра
     * @return {Array} Массив без повторов
     */
    getEventTypes() {
      return this.categories.map((c) => {
        return c.name
      }).addBefore('Все события')
    },

    /**
     * Значения переключателя "Сейчас/Скоро"
     * @return {Array}
     */
    getNowSoones() {
      return ['сейчас', 'скоро']
    },

    /**
     * Список из 12 месяцев начиная с
     * текущего для компонента "Скоро" (Главная)
     */
    getMonthTabsList() {
      let mn = this.getMonthNames(),
        d = new Date(),
        nn = mn.splice(d.getMonth()).concat(mn)
      return nn.map((m, i) => {
        let num = this.getSoonTabMonth(i)
        return {
          name: 'month' + i,
          year: this.getSoonTabYear(i),
          title: this.getMonthNames()[num].slice(0, 3)
        }
      })
    },

    /**
     * Возвращает месяц для вкладки №i
     */
    getSoonTabMonth(i = 0) {
      let d = new Date()
      d.setUTCMonth(d.getMonth() + i)
      return d.getUTCMonth()
    },

    /**
     * Возвращает год для вкладки №i
     */
    getSoonTabYear(i) {
      let d = new Date()
      d.setUTCMonth(d.getMonth() + i)
      return d.getUTCFullYear()
    },

    /**!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * ================================================================
     *  ФОРМАТИРОВАНИЕ И ПРЕОБРАЗОВАНИЕ ДАТ
     * ================================================================
     *!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
    /**
     * Возвращает объект даты конца недели по
     * строке даты понедельника этой недели
     */
    getSunday(d) {
      let y = d.getFullYear(),
        m = d.getMonth(),
        day = d.getDate()
      return new Date(y, m, day + 6, 23, 59, 59)
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

    /**
     * Парсит строку с датой, возвращает объект даты
     * @param  {String} str
     * @return {Date}
     */
    parse(str) {
      let time = new Date(str)
      return isNaN(time.getTime()) ? null : time
    },

    /**
     * Форматирует дату в строку даты
     * @param  {Date}   time    Объект даты
     * @param  {String}   format  Маска формата
     * @return {String}
     */
    formatDateToStr(time = new Date(), format = 'YYYY-MM-DD') {
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
    },

    /**
     * Форматирует дату в строку времени
     * @param  {Date}   time    Объект даты
     * @param  {String}   format  Маска формата
     * @return {String}
     */
    timeStrFromDateObj(time = new Date(), format = 'hh:mm') {
      let hour = time.getHours(),
        minute = time.getMinutes(),
        second = time.getSeconds(),
        map = {
          hh: ('0' + hour).slice(-2),
          h: hour,
          mm: ('0' + minute).slice(-2),
          m: minute,
          ss: ('0' + second).slice(-2),
          s: second
        }
      return format.replace(/h+|m+|s+/g, (str) => {
        return map[str]
      })
    }
  }
})

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
  saveScrollPosition: false,
  transitionOnLoad: true,
})



/**!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * ================================================================
 * Назначение маршрутов роутеру
 * ================================================================
 *!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
router.map({

  // Ошибка 404
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
    // subRoutes: {
    //   '/:page': {
    //     component(resolve) {
    //       resolve(Vue.component('schedule-page', SchedulePage))
    //     }
    //   }
    // }
  },

  // Архив
  '/archive': {
    component(resolve) {
      resolve(Vue.component('archive-page', ArchivePage))
    },
    // subRoutes: {
    //   '/:page': {
    //     component(resolve) {
    //       resolve(Vue.component('archive-page', ArchivePage))
    //     }
    //   }
    // }
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
    },
    subRoutes: {
      '/:placeId': {
        component(resolve) {
          resolve(Vue.component('contacts-page', ContactsPage))
          // console.log(router.app.getPlaceById(router.app.$route.params.placeId));
          // if (router.app.getPlaceById(router.app.$route.params.placeId)) {
          // } else {
          //   resolve(Vue.component('error-404', Error404))
          // }
        }
      }
    }
  },

  // Событие
  '/event/:slug': {
    component(resolve) {
      resolve(Vue.component('event-page', EventPage))
      // console.log(router.app.getEventBySlug(router.app.$route.params.slug));
      // if (router.app.getEventBySlug(router.app.$route.params.slug)) {
      // } else {
      //   resolve(Vue.component('error-404', Error404))
      // }
    }
  },

  // Программа
  '/program/:slug': {
    component(resolve) {
      resolve(Vue.component('program-page', ProgramPage))
      // console.log(router.app.getProgramBySlug(router.app.$route.params.slug));
      // if (router.app.getProgramBySlug(router.app.$route.params.slug)) {
      // } else {
      //   resolve(Vue.component('error-404', Error404))
      // }

    }
  }
})

router.beforeEach((trans) => {
  // console.log()
  // trans.abort()
  let fPath = trans.from && trans.from.path,
    tPath = trans.to && trans.to.path,
    fSlug = trans.from && trans.from.params && trans.from.params.slug,
    tSlug = trans.to && trans.to.params && trans.to.params.slug,
    tId = trans.to && trans.to.params && trans.to.params.placeId,
    app = router.app

  if (tPath.startsWith('/event/') && !app.getEventBySlug(tSlug)) {
    trans.redirect('/404')
  }
  if (tPath.startsWith('/program/') && !app.getProgramBySlug(tSlug)) {
    trans.redirect('/404')
  }
  if (tPath.startsWith('/contacts/') && !app.getPlaceById(tId)) {
    trans.redirect('/404')
  }
  // if (fPath && (fPath.startsWith('/event/') || fPath.startsWith('/program/') ||
  //   fPath.startsWith('/contacts/'))) {
  // }
  trans.next()
})

/**
 * Init Vue Router instance
 * Запускаем роутер и приложение
 */
router.start(App, 'body#App')

