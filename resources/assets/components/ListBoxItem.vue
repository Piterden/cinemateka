<style lang="css">
.fade-transition {
  transition: opacity .3s ease;
}
.fade-enter, .fade-leave {
  opacity: 0;
}
</style>
<template lang="html">
  <div class="mdl-cell mdl-cell--{{ getCols(method) }}-col"
    :style="styleObject"
    transition="fade"
    transition-mode="out-in"
  >
    <div class="event-item-card"
      :style="{backgroundImage: 'url(/' + this.images.mainimage + ')'}"
    >
      <div class="category">{{ eventTypeName }}</div>
      <div class="bottom-block">
        <div class="dates">
          {{ spendingRange() }}
        </div>
        <a v-link="{ path: 'event/' + item.slug }">
          <h3 class="title">{{ item.title }}</h3>
        </a>
        <div class="program">
          <a href="#" v-link="{path:'/program/'+closestProgram.slug}">
            {{ closestProgram.title }}
          </a>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
// @click.stop.prevent="$router.go( 'event/' + item.slug )"
export default {

  data() {
    return {
      closestProgram: this.$root.getClosestSeanceProgram(this.item),
      eventTypeName: this.$root.getCategoryById(this.item.category_id).name
    }
  },

  props: {
    item: Object,
    index: Number,
    cols: Number,
    method: String,
    limit: Number,
    height: Number,
    styleObject: {
      type: Object,
      default () {
        return {
          height: 'inherit'
        }
      }
    }
  },

  computed: {
    /**
     * Изображения
     */
    images() {
      return JSON.parse(this.item.images)
    },

    /**
     * Вычисляет ширину элемента списка в кол-ве колонок
     * @return {Number} Одинаковая ширина для всех элементов
     */
    same() {
      return this.cols
    },

    /**
     * Получает первый и, если нужно, последний элемент в 2 раза шире
     * @return {Number} Grid Width
     */
    firstLastDoubleWidth() {
      let showed = this.$parent.$children.length
      return !this.index
        || (
          this.$parent.$children.length == this.limit
          && this.index == this.limit - 1
        )
        ? this.cols * 2
        : this.cols
    }
  },

  methods: {
    /**
     * Получает строку из 2 дат - первого и последнего сеанса события, через '-'
     */
    spendingRange() {
      let seances = this.item.seances || [],
        start = new Date(seances[0].start_time),
        end = new Date(seances[seances.length - 1].start_time)

      if ((end - start) / 1000 / 60 / 60 / 24 / 365 > 1) {
        return this.$root.dateStrFromDateObj(start, 'DD.MM.YY') + '-' + this.$root.dateStrFromDateObj(end, 'DD.MM.YY')
      }
      return this.$root.dateStrFromDateObj(start, 'DD.MM') + '-' + this.$root.dateStrFromDateObj(end, 'DD.MM')
    },

    getCols(method) {
      return this[method]
    }
  }
}
</script>
