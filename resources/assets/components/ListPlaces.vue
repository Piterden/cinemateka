<style lang="css" scoped>
</style>

<template>
  <div class="places-wrapper">
    <list-places-item
      v-for="place in places"
      v-if="place.published != 0"
      :place.once="place"
      :cursor-index.sync="cursorIndex"
      :index="$index"
    ></list-places-item>
  </div>
</template>

<script>
export default {

  props: {
    places: Array,
    cursorIndex: Number
  },

  methods: {
    getPropertiesObject(place, index) {
      if (place.properties !== undefined && !!place.properties) {
        let props = JSON.parse(place.properties)
        this.$parent.propArray.$set(index, props)
        return props
      }
      return false
    }
  }

}
</script>
