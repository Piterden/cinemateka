<template>
  <div class="collapsible place-item {{ isActive ? 'active' : '' }}">
    <div class="collapsible-header" @click="clickPlaceItem($event)">
      <div class="place-number">
        {{ index + 1 }}
      </div>
      <div class="place-name" v-if="place.title">
        «{{ place.title }}»
      </div>
      <div class="place-type" v-if="place.properties">
        {{ place.properties.place_type }}
      </div>
    </div>
    <div class="collapsible-body" v-show="isActive">
      <div class="place-address" v-if="place.address">
        <i class="fa fa-map-marker" aria-hidden="true"></i>
        {{ place.address }}
      </div>
      <div class="place-metro" v-if="place.metro">
        {{ place.metro }}
      </div>
      <div class="place-site" v-if="place.place_site">
        <i class="fa fa-globe" aria-hidden="true"></i>
        <a href="http://{{ place.place_site }}" target="_blank">{{ place.place_site }}</a>
      </div>
      <div class="place-email" v-if="place.place_email">
        <i class="fa fa-envelope-o" aria-hidden="true"></i>
        <a href="mailto:{{ place.place_email }}">{{ place.place_email }}</a>
      </div>
      <div class="place-tel" v-if="place.place_phone">
        <i class="fa fa-mobile" aria-hidden="true"></i>
        <a href="tel:{{ place.place_phone }}">{{ place.place_phone }}</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {

  props: {
    place: Object,
    cursorIndex: Number,
    index: Number
  },

  computed: {
    isActive() {
      return this.cursorIndex == this.place.id
    }
  },

  methods: {
    clickPlaceItem() {
      // this.cursorIndex = this.place.id
      this.$parent.$parent.$set('activeMarker', this.place.id)
      this.$parent.$parent.$set('center', this.place.position)
    }
  }

}
</script>

<style lang="css" scoped>
.collapsible {
  margin: 10px 0 5px 0;
}
.collapsible-header {
  display: block;
  background-color: #fff;
  padding: 0;
  line-height: 40px;
  min-height: 40px;
  cursor: pointer;
  white-space: nowrap;
}
.collapsible-header i {
  width: 2rem;
  font-size: 1.6rem;
  line-height: 40px;
  display: block;
  float: left;
  text-align: center;
  margin-right: 1rem;
}
.collapsible-header:hover {
  color: red;
  transition: color .3s linear;
}
.collapsible-body {
  box-sizing: border-box;
}
.collapsible-body p {
  margin: 0;
  padding: 2rem;
}
</style>
