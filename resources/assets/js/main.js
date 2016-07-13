/** ***************************************************/
/** **************** eslint config ********************/
/** ***************************************************/
/* eslint-disable no-unused-vars */
/** ***************************************************/

// Расширение объекта Array
import Array from './inc.js'

/**
 * Подключаемые библиотеки
 */
import _ from 'lodash'
import Vue from 'vue'
import VueMdl from 'vue-mdl'
import VueAnimatedList from 'vue-animated-list'

/**
 * Плагины
 */
Vue.use(VueAnimatedList)
Vue.use(VueMdl)

/**
 * Google Maps Components
 */
import { load, loaded, Map, Marker } from 'vue-google-maps'
load('AIzaSyCrukK_xKPenGQkn9okGUjoBfECOeiOvSc', '3.25.7')

/**
 * Vue-компоненты
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
Vue.config.debug = false
Vue.config.silent = true
  // console.log(Vue.config);

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

import App from './app.js'
import router from './router.js'

/**
 * Init Vue Router instance
 * Запускаем роутер и приложение
 */
router.start(App, 'body#App')

