<style lang="css">
.event-image {
  /* background-position: left bottom; /* Положение фона */
  background-position: 50% 50%;
  background-repeat: no-repeat;
  /* Повторяем фон по горизонтали */
  background-size: cover;
  height: 411px;
  width: 100%;
  position: relative;
  color: white;
}

.event-date {
  font-size: 48px;
  position: absolute;
  top: 50px;
  left: 40px;
}

.event-title {
  font-size: 48px;
  position: absolute;
  top: 111px;
  left: 40px;
  max-width: 500px;
  font-weight: bold;
  line-height: 50px;
}

.event-programm {
  position: absolute;
  top: 336px;
  left: 40px;
}

.event-programm a {
  color: white;
  text-decoration: underline;
}

.event-video {
  width: 535px;
  height: 307px;
  position: absolute;
  right: 40px;
  bottom: 50px;
  background-color: grey;
}

.event-param {
  display: inline-block;
  border-bottom: 2px solid black;
  margin-top: 20px;
  margin-bottom: 30px;
  width: 100%;
  padding-bottom: 40px;
  text-align: right;
  position: relative;
}

.event-time {
  display: inline-block;
  position: absolute;
  left: 0;
  font-size: 32px;
}

.event-place {
  display: inline-block;
  margin-right: 100px;
}

.event-place i,
.event-price i {
  vertical-align: bottom;
}

.event-price {
  display: inline-block;
  position: absolute;
  right: 0;
}

.event-more-info {
  margin-top: 45px;
}

.more-info-table {
  margin-top: 24px;
  margin-bottom: 40px;
}

.more-info-table tr td:first-child {
  font-weight: bold;
  width: 170px;
}
.more-info-table tr td:nth-child(2) {
  /* max-width: 340px; */
}
.more-info-table tr td:nth-child(3) {
  vertical-align: top;
}
.actors-list li {
  font-size: 16px;
  margin-bottom: 3px;
}
/* same programm block */
.mdl-grid.list-box.same-programm-block {
  background-color: black;
  padding-top: 121px;
  position: relative;
}
.same-programm-block > h3 {
  position: absolute;
  top: 40px;
  left: 40px;
  font-size: 32px;
}
.same-programm-block h3 a {
 font-size: 32px;
 color: white;
 text-decoration: underline;
}
.same-programm-block h3 a:hover {
  color: red;
}
.more-events-in-shadue {
  height: 72px;
  border: 2px solid white;
  width: 100%;
  margin: 45px 12px;
  text-align: center;
  line-height: 72px;
}
.more-events-in-shadue a {
  text-transform: uppercase;
  letter-spacing: .2em;
  color: white;
}
.more-events-in-shadue svg {
  width: 70px;
}
.st0 {
  width: 70px;
  fill: none;
  stroke: white;
  stroke-width: 2;
  stroke-miterlimit: 10;
}
</style>

<template>
  <div class="wrap router-view event-page">
    <div class="event-image"
      :style="{'background-image': 'url(/'+images.mainimage+')'}">
      <div class="event-date">{{ closestSeanceDate }}</div>
      <div class="event-title">{{ eventItem.title }}</div>
      <div class="event-programm">
        <a v-link="'/program/'+closestProgram.slug">
          {{ closestProgram.title }}
        </a>
      </div>
      <div v-if="eventItem.videos" class="event-video">
        <iframe width="535" height="307" frameborder="0"
          :src="videos.mainvideo.replace('watch?v=','embed/')"
        ></iframe>
      </div>
    </div>
    <div class="mdl-grid">
      <div class="mdl-cell mdl-cell--7-col">
        <div class="event-desc">
          <div class="event-param">
            <div class="event-time">
              <i class="fa fa-clock-o" aria-hidden="true"></i>
              {{ closestSeanceTime }}
            </div>
            <div class="event-place" v-if="closestPlace">
              <i class="material-icons">place</i> {{ closestPlace.title }}
            </div>
            <div class="event-price">
              <i class="material-icons">account_balance_wallet</i>
              <strong>{{ closestSeance.price }}</strong> р.
            </div>
          </div>
          <div class="event-desc-text">
            {{ eventItem.description }}
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
              <tr v-if="eventItem.chrono">
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
              <tr v-if="eventItem.avards">
                <td>Награды/фестивали</td>
                <td>{{ eventItem.avards }}</td>
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
        <a href="#">Больше событий в расписании
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

  props: {
    eventItem: {
      type: Object,
      default () {
        return this.$root.events.filter((e) => {
          return e.slug == this.$route.params.slug
        })[0]
      }
    },
    closestSeance: {
      type: Object,
      default () {
        return this.$root.getClosestSeance(this.eventItem)
      }
    },
    closestProgram: {
      type: Object,
      default () {
        return this.$root.getClosestSeanceProgram(this.eventItem)
      }
    },
    closestProgramEvents: {
      type: Array,
      default() {
        return this.$root.getProgramEvents(this.closestProgram)
      }
    },
    closestPlace: {
      type: Object,
      default() {
        return this.$root.getClosestSeancePlace(this.eventItem)
      }
    }
  },

  computed: {
    images() {
      return JSON.parse(this.eventItem.images)
    },
    actors() {
      return JSON.parse(this.eventItem.actors)
    },
    videos() {
      return JSON.parse(this.eventItem.videos)
    },
    closestSeanceTime() {
      let d = this.closestSeance && new Date(this.closestSeance.start_time)
      return d && this.$root.timeStrFromDateObj(d)
    },
    closestSeanceDate() {
      let d = this.closestSeance && new Date(this.closestSeance.start_time)
      return d && this.$root.formatDateToStr(d, 'MM-DD')
    }
  },

  methods: {
    filterMethod(events, filters) {
      return events
    }
  }

}
</script>
