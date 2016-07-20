<template>
  <div id="events-example">
    <input
      type="hidden"
      v-model="strValue | json"
      :name="fieldName"
    >
    <input v-model="msg">
    <child v-for="seance in strValue"></child>
  </div>
</template>
<script>
export default {
  data: {
    msg: ''
  },
  props: {
    strValue: Array,
    fieldName: String
  },
  components: {
    'child': {
      template: '<div>{{ seance.start_time }}</div>',
      props: ['seance'],
      methods: {
        notify: function() {
          if (this.msg.trim()) {
            this.$dispatch('child-msg', this.msg)
            this.msg = ''
          }
        }
      }
    }
  }
}
</script>
<style lang="css" scoped>
</style>
