import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

/**
 * Vue-компоненты страницы
 */
import IndexPage from '../views/IndexPage.vue'
import SchedulePage from '../views/SchedulePage.vue'
import ArchivePage from '../views/ArchivePage.vue'
import AboutPage from '../views/AboutPage.vue'
import PartnersPage from '../views/PartnersPage.vue'
import ContactsPage from '../views/ContactsPage.vue'
import EventPage from '../views/EventPage.vue'
import ProgramPage from '../views/ProgramPage.vue'
import Error404 from '../views/Error-404.vue'

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
  transitionOnLoad: true
})

/**
 * ================================================================
 * Назначение маршрутов роутеру
 * ================================================================
 */
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
    }
  },

  // Архив
  '/archive': {
    component(resolve) {
      resolve(Vue.component('archive-page', ArchivePage))
    }
  },

  // О проекте
  '/about': {
    component(resolve) {
      resolve(Vue.component('about-page', AboutPage))
    }
  },

  // Партнеры
  '/partners': {
    component(resolve) {
      resolve(Vue.component('partners-page', PartnersPage))
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
        }
      }
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

router.beforeEach((trans) => {
  let fPath = trans.from && trans.from.path,
    tPath = trans.to && trans.to.path,
    // fSlug = trans.from && trans.from.params && trans.from.params.slug,
    tSlug = trans.to && trans.to.params && trans.to.params.slug,
    tId = trans.to && trans.to.params && trans.to.params.placeId,
    app = router.app

  if(fPath) {
    if (fPath == tPath) {
      trans.abort()
    }
    // if (tPath.startsWith('/event/') && fPath.startsWith('/event/')
    //   || tPath.startsWith('/program/') && fPath.startsWith('/program/')) {
    //   /* eslint-disable no-console */
    //   console.log(trans.to.router)
    //   /* eslint-enable no-console */
    // }
  }


  if(tPath.startsWith('/event/') && !app.getEventBySlug(tSlug)) {
    trans.redirect('/404')
  }
  if(tPath.startsWith('/program/') && !app.getProgramBySlug(tSlug)) {
    trans.redirect('/404')
  }
  if(tPath.startsWith('/contacts/') && !app.getPlaceById(tId)) {
    trans.redirect('/404')
  }

  trans.next()
})

let scrollToTop = (scrollDuration) => {
  let scrY = window.scrollY,
    scrollStep = -scrY / (scrollDuration / 15),
    scrollInterval = setInterval(() => {
      if(window.scrollY != 0) {
        window.scrollBy(0, scrollStep)
      } else {
        clearInterval(scrollInterval)
      }
    }, 15)
}

router.afterEach(() => {
  scrollToTop(400)
})

export default router

