<template>
  <div class="wrap router-view program-page">
    <div class="r-wrapper" v-if="programItem">
      <div class="program-image" :style="{'background-image': 'url(/'+images.mainimage+')'}">
        <div class="program-date">
          <span v-if="formatted_start != formatted_end">
            {{ formatted_start }}-{{ formatted_end }}
          </span>
          <span v-else>
            {{ formatted_start }}
          </span>
        </div>
        <div class="program-title">{{ programItem.title }}</div>
        <div v-if="videos.mainvideo" class="program-video">
          <iframe width="535" height="307" frameborder="0" :src="videos.mainvideo.replace('watch?v=','embed/')"></iframe>
        </div>
      </div>
      <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--7-col">
          <div class="program-desc">
            <div class="program-param">
              <div class="program-time" v-if="programItem.start_date">
                <!-- <i class="fa fa-clock-o" aria-hidden="true"></i> -->
              </div>
              <div class="program-place" v-if="closestPlace">
                <i class="material-icons">place</i> {{ closestPlace.title }}
              </div>
              <div class="program-price" v-if="closestSeance">
                <i class="material-icons">account_balance_wallet</i>
                <strong>{{ closestSeance.price }}</strong> р.
              </div>
            </div>
            <div class="program-desc-text" v-if="programItem.description">
              {{{ programItem.description }}}
            </div>
          </div>
          <div class="program-more-info" style="display: none;">
            <h3>Подробнее о фильме</h3>
            <table class="more-info-table">
              <tbody>
                <tr v-if="programItem.slogan">
                  <td>Cлоган</td>
                  <td>«{{ programItem.slogan }}»</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <list-box v-if="programEvents"
        :entity="'program'"
        :events="programEvents"
        :limit.once="100"
        :filtered-count="2"
        :cols.once="4"
        :wrap-class="'same-programm-block'"
      >
        <h3 slot="top">События программы</h3>
        <!-- <div slot="bottom" class="more-events-in-shadue">
          <a href="#">Больше событий в расписании -->
            <!-- ?xml version="1.0" encoding="utf-8"? -->
            <!-- <svg version="1.1"
              id="Layer_1"
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink"
              x="0px"
              y="0px"
              viewBox="0 0 72 20"
              style="enable-background:new 0 0 72 20;"
              xml:space="preserve"
            ><g><g>
                  <line class="st0"
                    x1="0"
                    y1="9.4"
                    x2="70"
                    y2="9.4"></line>
                  <polyline class="st0"
                    points="57.8,1 70,9.4 58.2,19"></polyline>
              </g></g>
            </svg>
          </a>
        </div> -->
      </list-box>
    </div>
  </div>
</template>

<script>
import moment from 'moment'
moment.locale('ru_RU')

export default {

  computed: {
    // Объект программы
    programItem() {
      return this.$root.programs.find((p) => {
        return p.slug == this.$route.params.slug
      })
    },
    // Картинки
    images() {
      return this.programItem.images && JSON.parse(this.programItem.images)
    },
    // Видео
    videos() {
      return this.programItem.videos && JSON.parse(this.programItem.videos)
    },
    // Дата начала
    formatted_start() {
      let d = this.programItem.start_date
      return d && moment(d).format('DD.MM')
    },
    // Дата окончания
    formatted_end() {
      let d = this.programItem.end_date
      return d && moment(d).format('DD.MM')
    },
    // События
    programEvents() {
      return this.$root.getProgramEvents(this.programItem)
    }
  },

  methods: {
    filterMethod(e) {
      return e
    }
  },

  head: {
    title() {
      return {
        inner: this.programItem.title,
        separator: '|',
        complement: this.$root.meta.app
      }
    },
    meta() {
      let description = this.programItem.description,
        title = this.programItem.title,
        image = this.programItem.images[0]
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

<style lang="css" scoped>
.program-image {
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
.program-date {
  font-size: 48px;
  position: absolute;
  top: 50px;
  left: 40px;
  text-shadow: 0 0 2px #000;
}
.program-title {
  font-size: 48px;
  position: absolute;
  top: 111px;
  left: 40px;
  max-width: 500px;
  font-weight: bold;
  line-height: 50px;
  text-shadow: 0 0 2px #000;
}
.program-programm {
  position: absolute;
  top: 336px;
  left: 40px;
}
.program-programm a {
  color: white;
  text-decoration: underline;
}
.program-video {
  width: 535px;
  height: 307px;
  position: absolute;
  right: 40px;
  bottom: 50px;
  background-color: grey;
}
.program-param {
  display: inline-block;
  border-bottom: 2px solid black;
  margin-top: 20px;
  margin-bottom: 30px;
  width: 100%;
  padding-bottom: 40px;
  text-align: right;
  position: relative;
}
.program-time {
  display: inline-block;
  position: absolute;
  left: 0;
  font-size: 32px;
}
.program-place {
  display: inline-block;
  margin-right: 100px;
}
.program-place i,
.program-price i {
  vertical-align: bottom;
}
.program-price {
  display: inline-block;
  position: absolute;
  right: 0;
}
.program-more-info {
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
  background-color: white;
  padding-top: 121px;
  position: relative;
  margin-bottom: 100px;
}
.same-programm-block > h3 {
  position: absolute;
  top: 40px;
  left: 40px;
  color: black;
  font-size: 32px;
}
.same-programm-block h3 a {
  font-size: 32px;
  color: black;
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
