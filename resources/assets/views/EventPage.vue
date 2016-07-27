<style lang="css" scoped>
  h3 {
    margin-bottom: 24px;
  }
</style>
<template>
  <div class="wrap router-view event-page">
    <div v-if="eventItem" class="event-image" :style="bgStyleObject">
      <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--7-col">
          <div class="event-date">{{ closestSeanceDate }}</div>
          <h1 class="event-title">{{ eventItem.title }}</h1>
          <div class="event-programm">
            <a v-link="'/program/'+closestProgram.slug">
              {{ closestProgram.title }}
            </a>
          </div>
        </div>
        <div class="mdl-cell mdl-cell--5-col">
          <div v-if="videos.mainvideo" class="event-video">
            <iframe width="100%" frameborder="0" :src="videos.mainvideo.replace('watch?v=','embed/')"></iframe>
          </div>
        </div>
      </div>
    </div>
    <div class="mdl-grid" v-if="eventItem">
      <div class="mdl-cell mdl-cell--7-col">
        <div class="event-desc">
          <div class="event-param">
            <div class="event-time">
              <i class="fa fa-clock-o" aria-hidden="true"></i> {{ closestSeanceTime }}
            </div>
            <div class="event-place" v-if="closestPlace">
              <i class="fa fa-map-marker" aria-hidden="true"></i> «{{ closestPlace.title }}»
            </div>
            <div class="event-price">
              <i class="material-icons">account_balance_wallet</i>
              <strong>{{ closestSeance.price }}</strong> р.
            </div>
          </div>
          <div class="event-desc-text">
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
              <tr v-if="eventItem.subtitles">
                <td>Субтитры</td>
                <td>{{ eventItem.subtitles }}</td>
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
      <div class="mdl-cell mdl-cell--5-col">
        <div v-if="closestSeance.speaker_info" class="speakers">
          <h3><i class="fa fa-comment"></i> Спикеры</h3>
          {{ closestSeance.speaker_info }}
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
        ><swipe-item
            v-for="slide in gallery"
            class="slide"
            style="background-image: url('/{{ slide }}')"
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
      <div slot="bottom" class="more-events-in-shadue">
        <a href="#" v-link="{ path: '/schedule/' }">Больше событий в расписании
          <!-- ?xml version="1.0" encoding="utf-8"? -->
          <svg version="1.1"
            id="Layer_1"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            x="0px"
            y="0px"
            viewBox="0 0 72 20"
            style="enable-background:new 0 0 72 20;"
            xml:space="preserve"
          >
            <g>
              <g>
                <line class="st0"
                  x1="0"
                  y1="9.4"
                  x2="70"
                  y2="9.4"></line>
                <polyline class="st0"
                  points="57.8,1 70,9.4 58.2,19"></polyline>
              </g>
            </g>
          </svg>
        </a>
      </div>
    </list-box>
  </div>
</template>
<script>
export default {

  computed: {
    bgStyleObject() {
      return {
        backgroundImage: 'url("/' + this.images.mainimage + '")'
      }
    },
    closestSeance() {
      return this.eventItem && this.$root.getClosestSeance(this.eventItem)
    },
    closestProgram() {
      return this.eventItem && this.$root.getClosestSeanceProgram(this.eventItem)
    },
    closestProgramEvents() {
      return this.closestProgram && this.$root.getProgramEvents(this.closestProgram)
    },
    closestPlace() {
      return this.eventItem && this.$root.getClosestSeancePlace(this.eventItem)
    },
    eventItem() {
      return this.$root.events.find((e) => {
        return e.slug == this.$route.params.slug
      })
    },
    images() {
      return this.eventItem.images && JSON.parse(this.eventItem.images)
    },
    actors() {
      return this.eventItem.actors && JSON.parse(this.eventItem.actors)
    },
    videos() {
      return this.eventItem.videos && JSON.parse(this.eventItem.videos)
    },
    closestSeanceTime() {
      let d = this.closestSeance && new Date(this.closestSeance.start_time)
      return d && this.$root.timeStrFromDateObj(d)
    },
    closestSeanceDate() {
      let d = this.closestSeance && new Date(this.closestSeance.start_time)
      return d && this.$root.formatDateToStr(d, 'DD.MM')
    },
    hasChrono() {
      return this.eventItem.chrono > 0 ? this.eventItem.chrono : ''
    },
    gallery() {
      let obj = this.images, arr = [], key
      for (key in obj) {
        if (obj.hasOwnProperty(key) && key != 'mainimage') arr.push(obj[key])
      }
      return arr
    },
    selfUrl() {
      return window.location.href
    },
    selfImageUrl() {
      return 'http://' + window.location.host + '/' + this.images.mainimage
    }
  },

  methods: {
    /* eslint-disable no-unused-vars */
    filterMethod(events, filters) {
      return events
    }
    /* eslint-enable no-unused-vars */
  },

  head: {
    title() {
      return {
        inner: this.eventItem.title + ' - Кино в городе'
      }
    },
    meta() {
      return {
        name: {
          'application-name': this.$root.meta.app,
          description: this.eventItem.description,
          'twitter:title': this.eventItem.title,
          'twitter:description': this.eventItem.description,
          'twitter:image': this.selfImageUrl
        },
        itemprop: {
          name: this.eventItem.title,
          description: this.eventItem.description,
          image: this.selfImageUrl
        },
        property: {
          // 'fb:app_id': 123456789,
          'og:url': this.selfUrl,
          'og:title': this.eventItem.title,
          'og:description': this.eventItem.description,
          'og:image': this.selfImageUrl
        }
      }
    },
    // Examples of link tags
    // link: {
    //   canonical: {
    //     href: window.location.origin
    //   },
    //   author: {
    //     href: 'humans.txt'
    //   },
    //   stylesheet: {
    //     href: 'https://example.com/styles.css'
    //   },
    //   import: {
    //     href: 'component.html'
    //   }
    // }
  }

}
</script>
