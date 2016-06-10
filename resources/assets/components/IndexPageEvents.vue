<style lang="sass" scoped>



</style>

<template>

  <div class="events-block">
    <blocks-header :title="title">
      <ul class="mdl-tabs__tab-bar">
        <li class="mdl-tabs__tab">
          <a class="active" @click.prevent="changeSubView(1, $event)">Test 1</a>
        </li>
        <li class="mdl-tabs__tab">
          <a @click.prevent="changeSubView(2, $event)">Test 2</a>
        </li>
        <li class="mdl-tabs__tab">
          <a @click.prevent="changeSubView(3, $event)">Disabled Tab</a>
        </li>
        <li class="mdl-tabs__tab">
          <a @click.prevent="changeSubView(4, $event)">Test 4</a>
        </li>
      </ul>
    </blocks-header>

  </div>

</template>

<script type="text/ecmascript-6">

export default {
  props: {
    events: {
      type: Array,
      default() {
        return this.$router.app.events || []
      }
    },
    programs: {
      type: Array,
      default() {
        return this.$router.app.programs || []
      }
    },
    title: {
      type: String,
      default() {
        return 'События'
      }
    },
    filters: {
      type: Array,
      default() {
        return [
          {'week1': {name: 'week1', title: 'На этой неделе'}},
          {'week2': {name: 'week2', title: 'На следующей'}},
          {'week3': {name: 'week3', title: 'date'}},
          {'week4': {name: 'week4', title: 'date'}},
        ]
      }
    }
  },
  methods: {
    changeSubView(v, e) {
      console.log(v,e);
    }
  },
  ready() {
    // console.log(this);
  }
}

</script>
