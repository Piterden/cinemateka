<style lang="css" scoped>

</style>

<template>
  <div class="wrap router-view program-page">
    <div class="program-image"
      :style="{'background-image': 'url(/'+images.mainimage+')'}">
      <div class="program-date">31.10</div>
      <div class="program-title">{{ programItem.title }}</div>
      <div class="program-programm">
        <a v-link="'/program/'+closestProgram.slug">
          {{ closestProgram.title }}
        </a>
      </div>
      <div v-if="programItem.videos" class="program-video">
        <iframe width="535" height="307" frameborder="0"
          :src="videos.mainvideo.replace('watch?v=','embed/')"
        ></iframe>
      </div>
    </div>
    <div class="mdl-grid">
      <div class="mdl-cell mdl-cell--7-col">
        <div class="program-desc">
          <div class="program-param">
            <div class="program-time">
              <i class="fa fa-clock-o" aria-hidden="true"></i>
              {{ closestSeanceTime }}
            </div>
            <div class="program-place" v-if="closestPlace">
              <i class="material-icons">place</i> {{ closestPlace.title }}
            </div>
            <div class="program-price">
              <i class="material-icons">account_balance_wallet</i>
              <strong>{{ closestSeance.price }}</strong> р.
            </div>
          </div>
          <div class="program-desc-text">
            {{ programItem.description }}
          </div>
        </div>
        <div class="program-more-info">
          <h3>Подробнее о фильме</h3>
          <table class="more-info-table">
            <tbody>
              <tr>
                <td>Оригин. название</td>
                <td>{{ programItem.orig_title || programItem.title }}</td>
                <td rowspan="15" v-if="programItem.actors">
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
              <tr v-if="programItem.slogan">
                <td>Cлоган</td>
                <td>«{{ programItem.slogan }}»</td>
              </tr>
              <tr v-if="programItem.year">
                <td>Год</td>
                <td>{{ programItem.year }}</td>
              </tr>
              <tr v-if="programItem.country">
                <td>Страна</td>
                <td>{{ programItem.country }}</td>
              </tr>
              <tr v-if="programItem.chrono">
                <td>Хронометраж</td>
                <td>{{ programItem.chrono }} мин.</td>
              </tr>
              <tr v-if="programItem.carrier">
                <td>Носитель</td>
                <td>{{ programItem.carrier }}</td>
              </tr>
              <tr v-if="programItem.language">
                <td>Язык</td>
                <td>{{ programItem.language }}</td>
              </tr>
              <tr v-if="programItem.subtitles">
                <td>Субтитры</td>
                <td>{{ programItem.subtitles }}</td>
              </tr>
              <tr v-if="programItem.director">
                <td>Режиссер</td>
                <td>{{ programItem.director }}</td>
              </tr>
              <tr v-if="programItem.writtenby">
                <td>Сценарий</td>
                <td>{{ programItem.writtenby }}</td>
              </tr>
              <tr v-if="programItem.operator">
                <td>Оператор</td>
                <td>{{ programItem.operator }}</td>
              </tr>
              <tr v-if="programItem.producer">
                <td>Продюсер:</td>
                <td>{{ programItem.producer }}</td>
              </tr>
              <tr>
                <td>Ограничения</td>
                <td>{{ programItem.age_restrictions || 0 }}+</td>
              </tr>
              <tr v-if="programItem.avards">
                <td>Награды/фестивали</td>
                <td>{{ programItem.avards }}</td>
              </tr>
              <tr v-if="programItem.link">
                <td>Cайт</td>
                <td>
                  <a href="{{ programItem.link }}" target="_blank">
                    {{ programItem.link }}
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
      :programs="closestProgramEvents"
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
      <div slot="bottom" class="more-programs-in-shadue">
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

  name: 'program-page',

  data () {
    return {

    };
  }
};
</script>
