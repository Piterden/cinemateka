/**
 * Plugins
 */
import VueMdl from 'vue-mdl'
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);
Vue.use(VueMdl);

/**
 * Views
 */
import IndexPage from '../views/IndexPage.vue'
import SchedulePage from '../views/SchedulePage.vue'
import ArchivePage from '../views/ArchivePage.vue'
import AboutPage from '../views/AboutPage.vue'
import ContactsPage from '../views/ContactsPage.vue'
import EventPage from '../views/EventPage.vue'
import ProgramPage from '../views/ProgramPage.vue'

/**
 * Partials
 */
import { Swipe, SwipeItem } from 'vue-swipe'
import IndexPageEvents from '../components/IndexPageEvents.vue'
import BlocksHeader from '../components/BlocksHeader.vue'

Vue.component('swipe', Swipe);
Vue.component('swipe-item', SwipeItem);
Vue.component('index-page-events', IndexPageEvents);
Vue.component('blocks-header', BlocksHeader);

var App = Vue.extend({
  data() {
    return {
      events: events,
      programs: programs
    }
  }
});

var router = new VueRouter({
  hashbang: false,
  history: true,
  linkActiveClass: 'active',
  mode: 'html5',
  saveScrollPosition: true,
  transitionOnLoad: true,
});

Vue.config.debug = true;

router.map({
  '/': {
    component(resolve) {
      resolve(Vue.component('index-page', IndexPage))
    }
  },
  '/schedule/:page': {
    component(resolve) {
      resolve(Vue.component('schedule-page', SchedulePage))
    }
  },
  '/archive/:page': {
    component(resolve) {
      resolve(Vue.component('archive-page', ArchivePage))
    }
  },
  '/about': {
    component(resolve) {
      resolve(Vue.component('about-page', AboutPage))
    }
  },
  '/contacts': {
    component(resolve) {
      resolve(Vue.component('contacts-page', ContactsPage))
    }
  },
  '/event/:slug': {
    component(resolve) {
      resolve(Vue.component('event-page', EventPage))
    }
  },
  '/program/:slug': {
    component(resolve) {
      resolve(Vue.component('program-page', ProgramPage))
    }
  },
});

router.start(App, 'body#App');

// window.Vue = Vue;
// window.App = App;
// window.VueRouter = VueRouter;
