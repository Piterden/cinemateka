/*****************************************************/
/****************** eslint config ********************/
/*****************************************************/
/*  global events programs places seances categories slides */
/*****************************************************/

import moment from 'moment'
import Vue from 'vue'

/**
 * Главный ($root) vue-компонент.
 * Доступ к App instance из любого места в файлах-компонентах *.vue
 * осуществляется через объекты "this.$root" или "this.$router.app"
 */
let App = Vue.extend({
  data() {
    return {
      meta: {
        app: 'Кино в городе',
        fbAppId: '',

      }
    }
  },
  /**
   * Здесь задаются коллекции, которые будут доступны, глобальные для всего
   * приложения через root-объект. Сюда подгружаются данные из PHP.
   */
  props: {
    // События         // @type {Array} of EventObjects
    events: {
      type: Array,
      default() {
        return events
      }
    },

    // Программы       // @type {Array} of ProgramObjects
    programs: {
      type: Array,
      default() {
        return programs
      }
    },

    // Места           // @type {Array} of SeanceObjects
    places: {
      type: Array,
      default() {
        return places
      }
    },

    // Типы событий    // @type {Array} of SeanceObjects
    categories: {
      type: Array,
      default() {
        return categories
      }
    },

    // Сеансы          // @type {Array} of SeanceObjects
    seances: {
      type: Array,
      default() {
        return seances
      }
    },

    // Слайды          // @type {Array} of SlideObjects
    slides: {
      type: Array,
      default() {
        return slides
      }
    }
  },

  created() { // Root-comp created
    /**
     * Записываем связанные объекты в события
     */
    this.events = events.map((e) => {
      let cat = this.getCategoryById(e.category_id)
      e.seances = this.getSeancesByEventId(e.id)
      e.event_type = cat && cat.name
      return e
    }).sort((a, b) => {
      let cloA = this.getClosestSeance(a) || { start_time: moment().format() },
        cloB = this.getClosestSeance(b) || { start_time: moment().format() }
      return cloA.start_time > cloB.start_time
    })

    /**
     * Записываем связанные объекты в события
     */
    this.programs = programs.map((p) => {
      p.seances = this.getSeancesByProgramId(p.id)
      return p
    })

    /**
     * Записываем связанные объекты в места
     */
    this.places = places.map((p) => {
      if(typeof p.position == 'string') {
        p.position = JSON.parse(p.position)
      }
      if(typeof p.position == 'string') {
        p.position = JSON.parse(p.position)
      }
      for(var k in p.position) {
        if(p.position.hasOwnProperty(k)) {
          p.position[k] = Number(p.position[k])
        }
      }
      p.properties = JSON.parse(p.properties)
      return p
    })

    /**
     * Записываем связанные объекты в слайды
     */
    this.slides = slides.map((s) => {
      if(typeof s.caption == 'string') {
        s.caption = JSON.parse(s.caption)
      }
      return s
    })

    /**
     * Записываем связанные объекты в сеансы
     */
    this.seances = this.seances.map((s) => {
      s.startDate = this.getStartDate(s)
      s.startTime = this.getStartTime(s)
      s.event = this.getEvent(s)
      s.program = this.getProgram(s)
      s.place = this.getPlace(s)
      s.eventTypeName = this.getEventTypeName(s.event)
      return s
    }).filter((s) => {
      return s.event && !s.event.deleted_at
    })
  },

  ready() {
    /**
     * По готовности удаляем коллекции данных из глобальной области видимости.
     * Они закешированы в переменных root-компонента.
     */
    delete window['events']
    delete window['seances']
    delete window['programs']
    delete window['places']
    delete window['categories']
    delete window['slides']
  },

  /**
   *  МЕТОДЫ
   */
  methods: {
    /**
     *  СВЯЗАННЫЕ ОБЪЕКТЫ
     */
    /**
     * Получает объект по id
     * @param  {Mixed} id
     * @return {Object} Событие
     */
    getById(arr = [], id = 0) {
      return arr.find((i) => {
        return Number(i.id) == Number(id)
      })
    },

    /**
     * Получает только опубликованные материалы из коллекции
     * @param  {Array}  a     Коллекция объектов [ {}, {}, {}, ... ]
     * @return {Array}
     */
    getPublished(a) {
      return a.filter((e) => {
        return Boolean(Number(e.published))
      })
    },

    /**
     * Возвращает ближайший сеанс
     * @param  {EventObject}   e    Объект события
     * @return {SeanceObject}       Объект сеанса
     */
    getClosestSeance(e) {
      return e && e.seances && e.seances.length && e.seances.find((s) => {
        return moment(s.start_time) > moment()
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
     * Возвращает событие ближайшего сеанса
     * @param   {ProgramObject}      Объект программы
     * @return  {EventObject}   e    Объект события
     */
    getClosestSeanceEvent(p) {
      let cs = this.getClosestSeance(p)
      return cs && cs !== -1 && this.events.find((e) => {
        return Number(e.id) == Number(cs.event_id)
      })
    },

    /**
     * Возвращает площадку ближайшего сеанса
     * @param  {EventObject}   e    Объект события
     * @return {PlaceObject}        Объект площадки
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
      if(a.length > 0) {
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

    /**
     * Получает все события программы
     * @param  {Object} p программа
     * @return {Array}    массив событий
     */
    getProgramEvents(p) {
      if(p.seances === undefined) return false
      let eIds = p.seances.sort((a, b) => {
        return a.start_time > b.start_time
      }).map((s) => {
        return s.event_id
      }).getUnique()
      return eIds.map((id) => {
        return this.getById(this.events, id)
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

    /**
     * Дата проведения сеанса
     * @param  {Object} seance Объект сеанса
     * @return {String}        Дата ДД.ММ
     */
    getStartDate(seance) {
      return moment(seance.start_time).format('DD.MM')
    },

    /**
     * Время проведения сеанса
     * @param  {Object} seance Объект сеанса
     * @return {String}        Время ЧЧ:ММ
     */
    getStartTime(seance) {
      return moment(seance.start_time).format('HH:mm')
    },

    /**
     * Событие сеанса
     * @param  {Object} seance Объект сеанса
     * @return {Object}        Объект события
     */
    getEvent(seance) {
      return this.getById(this.events, seance.event_id)
    },

    /**
     * Программа сеанса
     * @param  {Object} seance Объект сеанса
     * @return {Object}        Объект программы
     */
    getProgram(seance) {
      return this.getById(this.programs, seance.program_id)
    },

    /**
     * Место проведения сеанса
     * @param  {Object} seance Объект сеанса
     * @return {Object}        Объект места
     */
    getPlace(seance) {
      return this.getById(this.places, seance.place_id)
    },

    /**
     * Название категории (типа события)
     * @param  {Object} evObj Объект события
     * @return {String}       Name
     */
    getEventTypeName(evObj) {
      if(evObj === undefined) return ''
      let catId = Number(evObj.category_id) || 0
      let cat = catId ? this.getCategoryById(catId) : { name: '' }
      return cat.name
    },

    /**
     *  ГЕНЕРАЦИЯ СПИСКОВ ДЛЯ ФИЛЬТРОВ
     */
    /**
     * Генерирует не повторяющийся список годов
     * соответствующих датам всех сеансов
     * @return {Array}
     */
    getExistedYears() {
      return this.events.map((ev) => {
        return ev.seances && ev.seances.map((s) => {
          let d = moment(s.start_time)
          return d.year()
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
      let a = this.categories.map((c) => {
        return c.name
      })
      return ['Все события', ...a]
    },

    /**
     * Значения переключателя "Сейчас/Скоро"
     * @return {Array}
     */
    getNowSoones() {
      return ['сейчас', 'скоро']
    },

    /**
     * Возвращает месяц для вкладки №i
     */
    getSoonTabMonth(i = 0) {
      let d = moment()
      if(i == 0) {
        d.add(14, 'days')
      }
      d.add(i, 'months')
      return d.month()
    },

    /**
     * Возвращает год для вкладки №i
     */
    getSoonTabYear(i) {
      let d = moment().add(i, 'months')
      return d.year()
    },

    getProgramNames() {
      return this.programs.map((program) => {
        return program.title
      })
    },

    /**
     *  ФОРМАТИРОВАНИЕ И ПРЕОБРАЗОВАНИЕ ДАТ
     */
    /**
     * Возвращает объект даты конца недели по
     * строке даты понедельника этой недели
     */
    getSunday(d) {
      return moment(d).endOf('week')
    },

    /**
     * Возвращает объект даты начала недели по
     * любой дате внутри этой недели
     */
    getMonday(d) {
      return moment(d).startOf('week')
    },

    /**
     * Парсит строку с датой, возвращает объект даты
     * @param  {String} str
     * @return {Date}
     */
    parse(str) {
      let time = new Date(str)
      return isNaN(time.getTime()) ? null : time
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
}

export default App

