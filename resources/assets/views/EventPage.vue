<template>
  <div class="wrap router-view event-page">
    <div v-if="eventItem" class="event-image" style="background-image: url('/{{ eventItem.title_image }}');">
      <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--7-col main-titles">
          <div class="event-date" v-if="closestSeanceDate">{{ closestSeanceDate }}</div>
          <h1 class="event-title">{{{ eventItem.title }}}</h1>
          <div class="event-programm" v-if="closestProgram">
            <a v-link="'/program/'+closestProgram.slug">
              {{ closestProgram.title }}
            </a>
          </div>
        </div>
        <div class="mdl-cell mdl-cell--5-col">
          <div v-if="videos.mainvideo" class="event-video">
            <iframe width="100%" frameborder="0"
              :src="videos.mainvideo.replace('watch?v=','embed/')">
            </iframe>
          </div>
        </div>
      </div>
    </div>
    <div class="mdl-grid" v-if="eventItem">
      <div class="mdl-cell mdl-cell--7-col">
        <div class="event-desc">
          <div class="event-param">
            <div class="event-time" v-if="closestSeanceTime">
              <i class="fa fa-clock-o" aria-hidden="true"></i> {{ closestSeanceTime }}
            </div>
            <div class="event-place" v-if="closestPlace" @click="placeTooltip=!placeTooltip">
              <i class="fa fa-map-marker" aria-hidden="true"></i> «{{ closestPlace.title }}»
              <div class="placeTooltip" v-show="placeTooltip">
                <div class="place-address" v-if="closestPlace.address">
                  <i class="fa fa-map-marker" aria-hidden="true"></i>
                  {{ closestPlace.address }}
                </div>
                <div class="place-metro" v-if="closestPlace.metro">
                  {{ closestPlace.metro }}
                </div>
                <div class="place-site" v-if="closestPlace.place_site">
                  <i class="fa fa-globe" aria-hidden="true"></i>
                  <a href="http://{{ closestPlace.place_site }}" target="_blank">{{ closestPlace.place_site }}</a>
                </div>
                <div class="place-email" v-if="closestPlace.place_email">
                  <i class="fa fa-envelope-o" aria-hidden="true"></i>
                  <a href="mailto:{{ closestPlace.place_email }}">{{ closestPlace.place_email }}</a>
                </div>
                <div class="place-tel" v-if="closestPlace.place_phone">
                  <i class="fa fa-mobile" aria-hidden="true"></i>
                  <a href="tel:{{ closestPlace.place_phone }}">{{ closestPlace.place_phone }}</a>
                </div>
              </div>
            </div>
            <div class="event-price" v-if="closestSeance">
              <div v-if="eventItem.pay_link">
                <a href="{{ eventItem.pay_link }}" target="_blank">
                  <i class="material-icons">account_balance_wallet</i>
                  <strong>{{ closestSeance.price }}</strong> р.
                </a>
              </div>
              <div v-else>
                <i class="material-icons">account_balance_wallet</i>
                <strong>{{ closestSeance.price }}</strong> р.
              </div>
            </div>
          </div>
          <div class="event-desc-text" v-if="eventItem.description">
            {{{ eventItem.description }}}
          </div>
        </div>
        <div class="event-more-info">
          <h3>Подробнее о фильме</h3>
          <table class="more-info-table">
            <tbody>
              <tr>
                <td>Оригин. название</td>
                <td>{{ eventItem.orig_title || eventItem.title }}</td>
                <td rowspan="15" v-if="eventItem.actors">
                  <div class="actors-title">
                    <strong>В главных ролях</strong>
                  </div>
                  <ul class="actors-list list-group">
                    <li v-for="actor in actors">
                      {{ actor }}
                    </li>
                  </ul>
                </td>
              </tr>
              <tr v-if="eventItem.slogan">
                <td>Cлоган</td>
                <td>«{{ eventItem.slogan }}»</td>
              </tr>
              <tr v-if="eventItem.year">
                <td>Год</td>
                <td>{{ eventItem.year }}</td>
              </tr>
              <tr v-if="eventItem.country">
                <td>Страна</td>
                <td>{{ eventItem.country }}</td>
              </tr>
              <tr v-if="hasChrono">
                <td>Хронометраж</td>
                <td>{{ eventItem.chrono }} мин.</td>
              </tr>
              <tr v-if="eventItem.carrier">
                <td>Носитель</td>
                <td>{{ eventItem.carrier }}</td>
              </tr>
              <tr v-if="eventItem.language">
                <td>Язык</td>
                <td>{{ eventItem.language }}</td>
              </tr>
              <tr v-if="eventItem.subtitles != 'no'">
                <td>Субтитры</td>
                <td>{{ eventItem.subtitles == 'yes' ? 'Русские' : '' }}</td>
              </tr>
              <tr v-if="eventItem.director">
                <td>Режиссер</td>
                <td>{{ eventItem.director }}</td>
              </tr>
              <tr v-if="eventItem.writtenby">
                <td>Сценарий</td>
                <td>{{ eventItem.writtenby }}</td>
              </tr>
              <tr v-if="eventItem.operator">
                <td>Оператор</td>
                <td>{{ eventItem.operator }}</td>
              </tr>
              <tr v-if="eventItem.producer">
                <td>Продюсер:</td>
                <td>{{ eventItem.producer }}</td>
              </tr>
              <tr>
                <td>Ограничения</td>
                <td>{{ eventItem.age_restrictions || 0 }}+</td>
              </tr>
              <tr v-if="eventItem.awards">
                <td>Награды/фестивали</td>
                <td>{{ eventItem.awards }}</td>
              </tr>
              <tr v-if="eventItem.link">
                <td>Cайт</td>
                <td>
                  <a href="{{ eventItem.link }}" target="_blank">
                    {{ eventItem.link }}
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="mdl-cell mdl-cell--5-col" v-if="closestSeance">
        <div v-if="closestSeance.speaker_info" class="speakers">
          <h3><i class="fa fa-comment"></i> Фильм представляет</h3>
          {{{ closestSeance.speaker_info }}}
        </div>
        <div v-if="eventItem.pay_link">
          <a href="{{ eventItem.pay_link }}" target="_blank">
            <div class="ticket-button">
            Купить билет

                <!-- <div v-if="eventItem.pay_link">
                  <a href="{{ eventItem.pay_link }}" target="_blank">
                    <i class="material-icons">account_balance_wallet</i>
                    <strong>{{ closestSeance.price }}</strong> р.
                  </a>
                </div> -->
                <!-- <div v-else>
                  <i class="material-icons">account_balance_wallet</i>
                  <strong>{{ closestSeance.price }}</strong> р.
                </div> -->
            </div>
          </a>
        </div>
      </div>
    </div>
    <div class="mdl-grid social-block" v-if="eventItem">
      <div class="mdl-cell mdl-cell--12-col">
        <social-share
          :post-url="selfUrl"
          :post-title="eventItem.title"
          :post-text="eventItem.description"
          :post-img="selfImageUrl"
          :icon-facebook="'/images/icn-social-facebook.png'"
          :icon-vkontakte="'/images/icn-social-vkontakte.png'"
          :icon-twitter="'/images/icn-social-twitter.png'"
        ></social-share>
      </div>
    </div>
    <div class="mdl-grid press-block" v-if="eventItem">
      <div class="mdl-cell mdl-cell--6-col pic-gallery" v-if="gallery.length">
        <h3>Галерея</h3>
        <swipe
          :speed="600"
          :auto="0"
          :continuous="true"
          :show-indicators="true"
          :show-nav="true"
          :no-drag-when-single="false"
          :prevent="false"
          :style="{}"
        >
          <swipe-item
            v-for="slide in gallery"
            class="slide"
            :style="{backgroundImage: 'url(/' + slide + ')'}"
          >
            <div v-if="slide.caption" class="caption-wrapper">
              <div v-if="slide.caption.caption_title" class="caption-title">
                {{ slide.caption.caption_title }}
              </div>
              <div v-if="slide.caption.caption_content" class="caption-content">
                {{ slide.caption.caption_content }}
              </div>
            </div>
          </swipe-item>
        </swipe>
      </div>
      <div class="mdl-cell mdl-cell--6-col" v-if="eventItem.press_materials">
        <h3>Пресс-материалы</h3>
        <div class="press-materials-links">
          {{{ eventItem.press_materials }}}
        </div>
      </div>
    </div>
    <list-box
      v-if="closestProgram"
      :events="closestProgramEvents"
      :limit.once="3"
      :filtered-count="2"
      :cols.once="4"
      :wrap-class="'same-programm-block'"
    >
      <h3 slot="top">События
        <a href="#" v-link="{ path: '/program/' + closestProgram.slug }">
          той же программы
        </a>
      </h3>
      <div slot="bottom" class="more-events-in-shadue-wrapper">
        <a href="#" v-link="{ path: '/schedule/' }">
          <div class="more-events-in-shadue">
            Больше событий в расписании
            <svg version="1.1" viewBox="0 0 72 20">
              <g class="st0" stroke="white" stroke-linejoin="miter" stroke-width="2">
                <line  x1="0" y1="9.5" x2="70" y2="9.5"></line>
                <polyline fill="none" points="59,.5 71,9.5 59,18.5"></polyline>
              </g>
            </svg>
          </div>
        </a>
      </div>
    </list-box>
  </div>
</template>

<script>
import moment from 'moment'
moment.locale('ru-RU')

export default {

  data() {
    return {
      placeTooltip: false
    }
  },

  computed: {
    // Объект события
    eventItem() {
      return this.$root.events.find((e) => {
        return e.slug == this.$route.params.slug
      })
    },
    // Ближайший в будущем сеанс
    closestSeance() {
      return this.eventItem && this.$root.getClosestSeance(this.eventItem)
    },
    // Ближайшая в будущем программа
    closestProgram() {
      return this.eventItem && this.$root.getClosestSeanceProgram(this.eventItem)
    },
    // События ближайшей в будущем программы
    closestProgramEvents() {
      return this.closestProgram && this.$root.getProgramEvents(this.closestProgram)
    },
    // Площадка ближайшего в будущем сеанса
    closestPlace() {
      return this.eventItem && this.$root.getClosestSeancePlace(this.eventItem)
    },
    // Время начала ближайшего сеанса
    closestSeanceTime() {
      let d = this.closestSeance && moment(this.closestSeance.start_time)
      return d && moment(d).format('HH:mm')
    },
    // Дата начала ближайшего сеанса
    closestSeanceDate() {
      let d = this.closestSeance && moment(this.closestSeance.start_time)
      return d && moment(d).format('DD.MM')
    },
    // Главная картинка
    bgStyleObject() {
      return this.title_image && {
        backgroundImage: 'url("/' + this.title_image + '")'
      }
    },
    // Картинки JSON
    images() {
      return this.eventItem.images && JSON.parse(this.eventItem.images)
    },
    // Актеры JSON
    actors() {
      return this.eventItem.actors && JSON.parse(this.eventItem.actors)
    },
    // Видео JSON
    videos() {
      return this.eventItem.videos && JSON.parse(this.eventItem.videos)
    },
    // Продолжительность
    hasChrono() {
      return this.eventItem.chrono > 0 ? this.eventItem.chrono : ''
    },
    // Картинки Array без главной
    gallery() {
      let obj = this.images, arr = [], key
      for (key in obj) {
        if (obj.hasOwnProperty(key) && key != 'mainimage') {
          arr.push(encodeURIComponent(obj[key]))
        }
      }
      return arr
    },
    // URL главной картинки
    selfImageUrl() {
      return 'http://' + window.location.host + '/' + this.images.mainimage
    },
    // URL страницы
    selfUrl() {
      return window.location.href
    }
  },

  methods: {
    filterMethod(e) {
      return e
    },

    /**
     * Считает высоту галереи
     * @return {[type]} [description]
     */
    calcSwipeHeigth(){
      let swipe = this.$el.querySelector('.swipe'), height
      if (!swipe) return 'inherit'
      height = Number(swipe.offsetWidth / 16 * 9)
      swipe.style.height = height + 'px'
      return height
    },

    /**
     * По изменению размера окна
     * @return {[type]} [description]
     */
    onWinResize() {
      this.calcSwipeHeigth()
    },

    /**
     * По загрузке страницы
     */
    onEnter() {
      this.calcSwipeHeigth()
      window.addEventListener('resize', this.onWinResize)
    },

    /**
     * По уходу со страницы
     */
    onLeave() {
      window.removeEventListener('resize', this.onWinResize)
    },

    /**
     * Ручная смена тайтла
     */
    changeTitle(newItem, oldItem) {
      if (!newItem || !oldItem) return
      if (newItem.title != oldItem.title) {
        let titleTag = document.getElementsByTagName('title')[0]
        titleTag.innerHTML = newItem.title
      }
    }
  },

  watch: {
    eventItem: {
      deep: true,
      handler(newItem, oldItem) {
        this.calcSwipeHeigth()
        // Меняем тайтл вручную при смене события на другое
        this.changeTitle(newItem, oldItem)
      }
    }
  },

  ready() {
    this.onEnter()
  },
  beforeDestroy() {
    this.onLeave()
  },
  route: {
    activate() {
      this.onEnter()
    },
    deactivate() {
      this.onLeave()
    }
  },

  /**
   * Содержимое head
   * @type {Object}
   */
  head: {
    title() {
      return {
        inner: this.eventItem.title,
        separator: '|',
        complement: this.$root.meta.app
      }
    },
    meta() {
      let description = this.eventItem.description,
        title = this.eventItem.title,
        image = this.selfImageUrl
      return {
        name: {
          'application-name': this.$root.meta.app,
          description: description,
          'twitter:title': title,
          'twitter:description': description,
          'twitter:image': image
        }, //' comment to fix sublime highlighting
        itemprop: {
          name: title,
          description: description,
          image: image
        },
        property: {
          'fb:app_id': this.$root.meta.fbAppId,
          'og:url': window.location.href,
          'og:title': title,
          'og:description': description,
          'og:image': image
        } //' comment to fix sublime highlighting
      }
    }
  }
}
</script>

<style lang="css">
.event-page h3 {
  margin-bottom: 24px;
}
.event-price {
  position: relative;
}
.speakers {
  margin-bottom: 13px;
}
.speakers img {
  border-color: transparent;
  border-radius: 50%;
  max-width: 100px;
  max-height: 100px;
  margin: 5px 10px 0 0;
}
.ticket-button {
  width: calc(70% + 58px);
  height: 60px;
  margin-top: 20px;
  line-height: 60px;
  text-align: center;
  float: right;
  background-color: black;
  color: white;
  text-transform: uppercase;
  font-weight: bold;
  letter-spacing: .1em;
}
.ticket-button:hover {
  background-color: #ff0025;
  transition: background-color .3s linear;
}
.event-place {
  position: relative;
  cursor: pointer;
  transition: color .3s linear;
}
.event-place:hover {
  color: #ff0025;
}
.event-place .placeTooltip {
  position: absolute;
  top: 38px;
  width: 250px;
  left: -120px;
  text-align: left;
  background: #fff;
  border: 3px solid;
  padding: 0 0 15px 0;
  color: #000;
}
.event-place .placeTooltip:after {
  content: '';
  position: absolute;
  width: 15px;
  height: 15px;
  background: #fff;
  border-top: 3px solid;
  border-left: 3px solid;
  transform: rotate(45deg);
  top: -11px;
  left: 181px;
}
</style>
