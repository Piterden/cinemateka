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
    /**
     * Записываем связанные объекты
     */
    this.events.forEach((e, i) => {
      this.events[i].seances = this.getSeancesByEventId(e.id)
      this.events[i].event_type = this.getCategoryNameById(e.category_id)
    })
    this.programs.forEach((p, i) => {
      this.programs[i].seances = this.getSeancesByProgramId(p.id)
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
      return e.seances.filter((s) => {
        return new Date(s.start_time) > new Date()
      })[0]
    },

    /**
     * Возвращает программу ближайшего сеанса
     * @param  {EventObject}   e    Объект события
     * @return {ProgramObject}      Объект программы
     */
    getClosestSeanceProgram(e) {
      return this.programs.filter((p) => {
        return p.id == this.getClosestSeance(e).program_id
      })[0]
    },

    getClosestSeancePlace() {
      return this.places.filter((p) => {
        return p.id == this.getClosestSeance(e).place_id
      })
    },

    // let ppIds = this.getProgramsIds(e),
    //   ss = this.seances.filter((s) => {
    //     return ppIds.indexOf(Number(s.program_id)) >= 0 && new Date(s.start_time) > new Date()
    //   }),
    //   pId = ss.sort((a, b) => {
    //     return a.start_time > b.start_time
    //   })[0].program_id
    // return this.getProgramById(pId)
    /**
     * Объект программы по id
     * @param  {Mixed} id
     * @return {Object} Программа
     */
    getProgramById(id) {
      return this.programs.filter((p) => {
        return p.id == id
      })[0]
    },

    /**
     * Объект события по id
     * @param  {Mixed} id
     * @return {Object} Событие
     */
    getEventById(id) {
      return this.events.filter((e) => {
        return e.id == id
      })[0]
    },

    /**
     * Сеансы для события в хронологическом порядке
     * @param  {Mixed} id
     * @return {Array}
     */
    getSeancesByEventId(id) {
      return this.seances.filter((s) => {
        return s.event_id == id
      }).sort((a, b) => {
        return a.start_time > b.start_time
      })
    },

    /**
     * Сеансы для программы в хронологическом порядке
     * @param  {Mixed} id
     * @return {Array}
     */
    getSeancesByProgramId(id) {
      return this.seances.filter((s) => {
        return s.program_id == id
      }).sort((a, b) => {
        return a.start_time > b.start_time
      })
    },

    /**
     * Имя типа (категории) события
     * @param  {Mixed} id
     * @return {String}
     */
    getCategoryNameById(id) {
      return this.categories.filter((c) => {
        return c.id == id
      }).name
    },

    /**
     * Получает массив ID программ для конкретного
     * события через связь Событие-Сеансы-Программа
     * @param   {Object}  e   Объект события
     * @return  {Array}       Массив ID программ
     */
    getProgramsIds(e) {
      let a = []
      e.seances.forEach((s) => {
        return a.push(Number(s.program_id))
      })
      return a
    },

    /**
     * Получает список id мест проведения для события или программы,
     * а если не указан объект, то для всех событий и программ.
     * @param  {Object} eventObj|programObj
     * @return {Array}
     */
    getEventPlacesId(o) {
      if(o === undefined) {
        return this.seances.map((s) => {
          return s.place_id
        }).getUnique()
      }
      if(!o.seances ||
        o.seances.length === undefined ||
        o.seances.length < 1
      ) return []
      return o.seances.map((s) => {
        return s.place_id
      }).getUnique()
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
     * Названия типов событий для фильтра
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
        let num = this.$children[0].getSoonTabMonth(i)
        return {
          name: 'month' + i,
          year: this.$children[0].getSoonTabYear(i),
          title: this.getMonthNames()[num].slice(0, 3)
        }
      })
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
    dateStrFromDateObj(time = new Date(), format = 'YYYY-MM-DD') {
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

Vue.config.debug = true

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

