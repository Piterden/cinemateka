<style lang="css">

</style>

<template lang="html">
  <div class="date-pickers">
    <div class="date-pickers-calendar">
      <i class="fa fa-calendar" aria-hidden="true"></i>
    </div>
    <input type="text" v-model="intervalStr" @click.stop="open" />
    <div class="date-popup" v-show="show">
      <datepicker :idx="0" :value="start" :show.sync="show"></datepicker>
      <datepicker :idx="1" :value="end" :show.sync="show"></datepicker>
    </div>
  </div>
</template>

<script>
export default {

  data() {
    return {
      // При загрузке - скрыты календари
      show: false,
      overrideNowSoon: false
    }
  },

  // Если FALSE, то даты не учитываются пр фильтрации
  props: {
    startDate: { default: false },
    endDate: { default: false }
  },

  /**
   * Строковые значения дат для вывода
   */
  computed: {
    startStr() {
      return this.$root.formatDateToStr(this.startDate, 'DD.MM')
    },
    endStr() {
      return this.$root.formatDateToStr(this.endDate, 'DD.MM')
    },
    intervalStr() {
      return this.startStr + ' - ' + this.endStr
    }
  },

  methods: {
    // Открывает календари
    open() {
      this.show = true
    },
    // Проверяет куда был клик, если мимо - закрывает календари
    leave(e) {
      if (!this.$el.contains(e.target)) {
        this.close()
      }
    },
    // Закрывает календари
    close() {
      this.show = false
    }
  },

  ready() {
    // Обработчик нажатий мимо элеметов
    document.addEventListener('click', this.leave, false)
  },

  beforeDestroy() {
    // Снимаем обработчик нажатий мимо
    document.removeEventListener('click', this.leave, false)
  }
}
</script>
