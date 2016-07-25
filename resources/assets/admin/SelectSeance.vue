<template>
  <div id="events-example">
    <input v-model="strValue | json" :name="fieldName">
    <child v-for="seance in strValue" :seance="seance"></child>
    <button type="button"
      class="btn btn-default"
      @click.prevent="openElFinder(item.key)"
    ><i class="fa fa-cloud-upload"></i>
      Добавить сеанс
    </button>
    <button type="button"
      class="btn btn-default"
      @click.prevent="clearField(item.key)"
    >Очистить <i class="fa fa-eraser"></i>
    </button>
  </div>
</template>
<script>
export default {
  data() {
    return {
      msg: ''
    }
  },
  props: {
    strValue: Array,
    fieldName: String
  },
  components: {
    'child': {
      template: '<div>{{ seance.start_time }} '
        + '<i class="fa fa-times" @click="deleteSeance"></i></div>',
      props: ['seance'],
      methods: {
        notify() {
          if (this.msg.trim()) {
            this.$dispatch('child-msg', this.msg)
            this.msg = ''
          }
        },
        deleteSeance() {

        }
      }
    }
  },
  ready() {
    // var resource = this.$resource('/rest/seance{/id}')
    // resource.get({id: 5}).then(())
  }
}
</script>
<style lang="css" scoped>
</style>
