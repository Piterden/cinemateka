import _ from 'lodash'
/**
 * Vendor modules
 */
import VueMdl from 'vue-mdl'
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
Vue.use(VueMdl)

/**
 * Views files
 */
import IndexPage from '../views/IndexPage.vue'
import SchedulePage from '../views/SchedulePage.vue'
import ArchivePage from '../views/ArchivePage.vue'
import AboutPage from '../views/AboutPage.vue'
import ContactsPage from '../views/ContactsPage.vue'
import EventPage from '../views/EventPage.vue'
import ProgramPage from '../views/ProgramPage.vue'

/**
 * Partials files
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
 * Возвращает минимальное значение массива
 * @method min        Применяется к любому массиву JS
 * @return {Mixed}
 */
Array.prototype.min = function () {
  return Math.min.apply(null, this);
};

/**
 * Удаляет повторения из массива
 * @method getUnique  Применяется к любому массиву JS
 * @return {Array}
 */
Array.prototype.getUnique = function () {
  var u = {},
    a = [];
  for (var i = 0, l = this.length; i < l; ++i) {
    if (u.hasOwnProperty(this[i])) {
      continue;
    }
    a.push(this[i]);
    u[this[i]] = 1;
  }
  return a;
};

Array.prototype.collapse = function () {
  var a = [];
  for (var i = 0, l = this.length; i < l; ++i) {
    if (
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
 * Компоненты (html-элементы)
 */
Vue.component('swipe', Swipe);
Vue.component('swipe-item', SwipeItem);
Vue.component('index-page-events', IndexPageEvents);
Vue.component('index-page-soon', IndexPageSoon);
Vue.component('blocks-header', BlocksHeader);
Vue.component('list-box', ListBox);
Vue.component('list-box-item', ListBoxItem);
Vue.component('list-grid', ListGrid);
Vue.component('list-grid-item', ListGridItem);
Vue.component('filters-line', FiltersLine);
Vue.component('dropdown-list', DropdownList);
Vue.component('toggler', Toggler);
Vue.component('datepicker', Datepicker);
Vue.component('date-pickers', DatePickers);
// Vue.component('grid-loader', BlocksHeader);

/**
 * Главный ($root) vue-компонент
 * this.$root || this.$router.app - доступ к
 * App instance из любого места в файлах-компонентах *.vue
 */
var App = Vue.extend({
  /**
   * Здесь задаются данные, которые будут доступны
   * во всем приложении через App($root) объект
   * глобальные объекты удаляем по @ready.
   */
  data() {
    return {
      /**
       * Все события
       * Принимаются из Laravel JS Fasade
       * @type {Array} of EventObjects
       */
      events: events,
      /**
       * Все программы
       * Принимаются из Laravel JS Fasade
       * @type {Array} of ProgramObjects
       */
      programs: programs,
      /**
       * Все места
       * Принимаются из Laravel JS Fasade
       * @type {Array} of SeanceObjects
       */
      places: places
    }
  },

  computed: {
    /**
     * Все сеансы событий
     * @return {Array}    Seances
     */
    seances() {
      return this.events.map((e) => {
        let ss = e.seances
        delete e.seances
        return ss.map((s) => {
          s.event = e
          return s
        })
      })
    }
  },

  /**
   * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
   * ==================================================================
   * Глобальные Методы
   * ==================================================================
   * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
   */
  methods: {
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
        "Октябрь", "Ноябрь", "Декабрь"]
    },

    /**
     * Хранит список дней недели
     * @return {Array}
     */
    getWeekDaysNames() {
      return ["Пн","Вт","Ср","Чт","Пт","Сб","Вс"]
    },

    /**
     * Находит уникальные значения указанного свойства
     * и заворачивает в массив, где def - первый элемент
     * @param  {String} attr  Название свойства
     * @param  {String} def   Значение по-умолчанию
     * @return {Array}        Массив без повторов
     */
    getEventAttributeTypes(attr, def) {
      let t = typeof def == 'string' && [def] || []
      this.events.forEach((ev) => {
        if (t.indexOf(ev[attr]) < 0) t.push(ev[attr])
      })
      return t
    },

    /**
     * Значения переключателя "Сейчас/Скоро"
     * @method getNowSoones
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
     * @param  {Object} e     EventObject
     * @return {Array}        Places
     */
    getEventPlaces(e) {
      if (e === undefined) {
        return this.events.map((ev) => {
          ev.seances.map((s) => {
            return s.place
          }).getUnique()
        }).collapse().getUnique()
      }
      return e.seances.map((s) => {
        return s.place
      }).getUnique()
    },

    /**
     * Получает список мест проведения для программы
     * или для всех программ
     * @param  {Object} e     EventObject
     * @return {Array}        Places
     */
    getProgramPlaces(p) {
      if (p === undefined) {
        return this.programs.map((pr) => {
          return pr.seances.map((s) => {
            return s.place
          }).getUnique()
        }).collapse().getUnique()
      }
      return p.seances.map((s) => {
        return s.place;
      }).getUnique();
    },

    /**
     * Список из 12 месяцев начиная с
     * текущего для компонента "Скоро" (Главная)
     */
    getMonthTabsList() {
      let mn = this.getMonthNames(),
        d = new Date(),
        nn = mn.splice(d.getMonth()).concat(mn)
      return nn.map((m,i) => {
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
      return this.getPrograms(e)[0];
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

    parse (str) {
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

  ready() {
    /**
     * Удаляем глобальные коллекции
     */
    delete window['events']
    delete window['programs']
    delete window['places']


  },

});

/**
 * Совмещает 2 объекта в один, перезаписывая вторым первый
 * @private
 * @param {Object}    Умолчания (что заполнять)
 * @param {Object}    Новые свойства (чем заполнять)
 * @returns {Object}  Результат
 */
App.prototype.extend = function (defaults, options) {
  var extended = {}, prop;
  for (prop in defaults) {
    if (Object.prototype.hasOwnProperty.call(defaults, prop)) {
      extended[prop] = defaults[prop];
    }
  }
  for (prop in options) {
    if (Object.prototype.hasOwnProperty.call(options, prop)) {
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
var router = new VueRouter({
  hashbang: false,
  history: true,
  linkActiveClass: 'active',
  mode: 'html5',
  saveScrollPosition: true,
  transitionOnLoad: true,
});

Vue.config.debug = true;

/**
 * ================================================================
 * Назначение маршрутов роутера
 * ================================================================
 */
router.map({

  // Главная
  '/': {
    component(resolve) {
      resolve(Vue.component('index-page', IndexPage));
    }
  },

  // Расписание
  '/schedule': {
    component(resolve) {
      resolve(Vue.component('schedule-page', SchedulePage));
    },
    subRoutes: {
      '/:page': {
        component(resolve) {
          resolve(Vue.component('schedule-page', SchedulePage));
        }
      }
    }
  },

  // Архив
  '/archive': {
    component(resolve) {
      resolve(Vue.component('archive-page', ArchivePage));
    },
    subRoutes: {
      '/:page': {
        component(resolve) {
          resolve(Vue.component('archive-page', ArchivePage));
        }
      }
    }
  },

  // О проекте
  '/about': {
    component(resolve) {
      resolve(Vue.component('about-page', AboutPage));
    }
  },

  // Контакты
  '/contacts': {
    component(resolve) {
      resolve(Vue.component('contacts-page', ContactsPage));
    }
  },

  // Событие
  '/event/:slug': {
    component(resolve) {
      resolve(Vue.component('event-page', EventPage));
    }
  },

  // Программа
  '/program/:slug': {
    component(resolve) {
      resolve(Vue.component('program-page', ProgramPage));
    }
  }
});

/**
 * Init Vue Router instance
 * Запускаем роутер и приложение
 */
router.start(App, 'body#App');
