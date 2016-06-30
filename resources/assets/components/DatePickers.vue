<style lang="css"></style>

<template lang="html">
  <div class="date-pickers">
    <input type="text"
      v-model="interval"
      @click.stop="focusInput"
    />
    <div class="date-popup" v-show="show">
      <datepicker
        :idx="0"
        :value="start"
        :show.sync="show"
      ></datepicker>
      <datepicker
        :idx="1"
        :value="end"
        :show.sync="show"
      ></datepicker>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      show: false
    }
  },
  props: {
    startDate: Date,
    endDate: Date
  },
  computed: {
    start() {
      return this.$root.dateStrFromDateObj(this.startDate, 'DD.MM')
    },
    end() {
      return this.$root.dateStrFromDateObj(this.endDate, 'DD.MM')
    },
    interval() {
      return this.start + ' - ' + this.end
    }
  },
  methods: {
    focusInput() {
      this.$set('show', true)
    },
    leave(e) {
      if (!this.$el.contains(e.target)) {
        this.close()
      }
    },
    close() {
      this.show = false;
    }
  },
  ready () {
    document.addEventListener('click', this.leave, false);
  },
  beforeDestroy () {
    document.removeEventListener('click', this.leave, false);
  }
}

</script>
