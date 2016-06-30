<style lang="css" scoped>
.event-image {
  /* background-position: left bottom; /* Положение фона */
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

.more-info-table td {
  margin-right: 18px;
}

.more-info-table tr td:first-child {
  font-weight: bold;
}
</style>
<template>
  <div class="wrap router-view event-page">
    <div class="event-image" :style="{'background-image': 'url('+item.images.mainimage+')'}">
      <div class="event-date">31.10</div>
      <div class="event-title">{{ item.title }}</div>
      <div class="event-programm">
        <a v-link="'/program/'+closestProgram.slug">
          {{ closestProgram.title }}
        </a>
      </div>
      <div class="event-video"></div>
    </div>
    <div class="mdl-grid">
      <div class="mdl-cell mdl-cell--7-col">
        <div class="event-desc">
          <div class="event-param">
            <div class="event-time">
              <i class="material-icons">query_builder</i> {{ $root.timeStrFromDateObj(new Date(closestSeance.start_time)) }}
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
            {{ item.description }}
          </div>
        </div>
        <div class="event-more-info">
          <h3>Подробнее о фильме</h3>
          <table class="more-info-table">
            <tbody>
              <tr>
                <td>Оригинальное название:</td>
                <td>{{ item.orig_title || item.title }}</td>
                <td rowspan="15" v-if="item.actors">
                  <div class="actors-title">
                    <strong>В главных ролях:</strong>
                  </div>
                  <ul class="actors-list list-group">
                    <li v-for="actor in item.actors">
                      {{ actor }}
                    </li>
                  </ul>
                </td>
              </tr>
              <tr v-if="item.slogan">
                <td>Cлоган:</td>
                <td>«{{ item.slogan }}»</td>
              </tr>
              <tr v-if="item.year">
                <td>Год:</td>
                <td>{{ item.year }}</td>
              </tr>
              <tr v-if="item.country">
                <td>Страна:</td>
                <td>{{ item.country }}</td>
              </tr>
              <tr v-if="item.chrono">
                <td>Хронометраж:</td>
                <td>{{ item.chrono }} мин.</td>
              </tr>
              <tr v-if="item.carrier">
                <td>Носитель:</td>
                <td>{{ item.carrier }}</td>
              </tr>
              <tr v-if="item.language">
                <td>Язык:</td>
                <td>{{ item.language }}</td>
              </tr>
              <tr v-if="item.subtitles">
                <td>Субтитры:</td>
                <td>{{ item.subtitles }}</td>
              </tr>
              <tr v-if="item.director">
                <td>Режиссер:</td>
                <td>{{ item.director }}</td>
              </tr>
              <tr v-if="item.writtenby">
                <td>Сценарий:</td>
                <td>{{ item.writtenby }}</td>
              </tr>
              <tr v-if="item.operator">
                <td>Оператор:</td>
                <td>{{ item.operator }}</td>
              </tr>
              <tr v-if="item.producer">
                <td>Продюсер:</td>
                <td>{{ item.producer }}</td>
              </tr>
              <tr>
                <td>Ограничения:</td>
                <td>{{ item.age_restrictions || 0 }}+</td>
              </tr>
              <tr v-if="item.avards">
                <td>Награды / фестивали:</td>
                <td>{{ item.avards }}</td>
              </tr>
              <tr v-if="item.link">
                <td>Cайт:</td>
                <td>
                  <a href="{{ item.link }}" target="_blank">
                    Веб-сайт
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {

  props: {
    item: {
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
        return this.$root.getClosestSeance(this.item)
      }
    },
    closestProgram: {
      type: Object,
      default () {
        return this.$root.getClosestSeanceProgram(this.item)
      }
    },
    closestPlace: {
      type: Object,
      default() {
        return this.$root.getClosestSeancePlace(this.item)
        //return this.$root.places.filter((p) => {
        //  return p.id == this.closestSeance.place_id
        //})[0]
      }
    }
  },

  computed: {

  }

}
</script>
