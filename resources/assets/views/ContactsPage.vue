<template lang="html">
  <div class="wrap router-view contacts-page map-wrapper"
    :style="{ width: mapWidth + 'px', height: mapHeight + 'px' }"
  >
    <list-places
      :places="places"
      :cursor-index="activeIndex || 0"
    ></list-places>
    <map id="map"
      :center.sync="center"
      :zoom.sync="15"
      :options="options"
    >
      <marker
        v-for="place in places"
        v-if="place.published != 0"
        :clickable.sync="true"
        :title.sync="place.title"
        :cursor.sync="'pointer'"
        :draggable.sync="false"
        :label.sync="place.place_type"
        :position.sync="place.position"
        :place.sync="markerPlace"
      ></marker>
    </map>
  </div>
</template>

<script>
export default {

  data() {
    return {
      places: this.$root.places,
      markerLabel: {
        color: '#000',
        // fontFamily: '',
        fontSize: '24px',
        fontWeight: 'normal',
        text: ''
      },
      options: {
        scrollwheel: false
      }
    }
  },

  props: {
    mapWidth: {
      type: Number,
      default: window.innerWidth
    },
    mapHeight: {
      type: Number,
      default: window.innerHeight
    },
    activeMarker: {
      type: Number,
      default: 0
    }
  },

  computed: {
    center() {
      let p = this.getActivePlace()
      return p && p != -1 && p.position || {}
    },
    activeIndex() {
      return this.$root.getIndexById(this.$root.places, this.activeMarker)
    }
  },

  methods: {

    /**
     * При изменении размера окна и один раз при загрузке
     * изменяет размеры фрейма карты
     * @param  {Event} e DOM event
     */
    handleResize(e) {
      if (e !== undefined) {
        e.preventDefault()
        e.stopPropagation()
      }
      this.mapWidth = window.innerWidth
      this.mapHeight = window.innerHeight - 96 - 87
    },

    clickPlaceItem(index) {
      let place = this.places[index]
      if (!place) {
        return false
      }
      this.activeMarker = place.id
    },

    setCursor(id) {
      if (!this.places || this.places.length <= 0) return false
      if (id === undefined) {
        this.clickPlaceItem(0)
        return true
      }
      let index = this.$root.getIndexById(this.places, id) || 0
      this.clickPlaceItem(Number(index))
      return true
    },

    getActivePlace() {
      return this.places[this.activeIndex]
    }
  },

  ready() {
    this.setCursor(this.$route.params.placeId)
    this.handleResize()
    window.removeEventListener('resize', this.handleResize)
    window.addEventListener('resize', this.handleResize)
  },

  beforeDestroy() {
    window.removeEventListener('resize', this.handleResize)
  }

}
</script>

<style lang="css">
.map-wrapper {
  position: relative;
}

#map {
  width: calc(100% - 15px);
  height: calc(100% - 183px);
}

.vue-map-container {
  filter: grayscale(1);
}

.places-wrapper {
  position: absolute;
  top: 10%;
  left: 5%;
  width: 385px;
  background-color: white;
  z-index: 5555;
  padding: 0 24px;
}

.place-item {
  margin: 4px 0;
  border-bottom: 2px solid black;
  padding-bottom: 12px;
}

.place-item:last-child {
  border: none;
  padding-bottom: 5px;
}

.collapsible-header {}

.place-number {
  width: 18px;
  height: 18px;
  border-radius: 50%;
  background-color: black;
  color: white;
  text-align: center;
  margin-right: 8px;
  display: inline-block;
  font-size: 13px;
  line-height: 20px;
}

.place-name {
  display: inline-block;
  font-weight: bold;
}

.place-type {
  display: inline-block;
}

.place-address {
  margin: 15px 0 0 25px;
  vertical-align: middle;
}

.place-address i {
  margin-right: 8px;
  font-size: 21px;
}

.place-site i {
  margin-right: 6px;
  font-size: 18px;
}

.place-email i {
  font-size: 16px;
  margin-right: 6px;
  margin-left: -1px;
}

.place-tel i {
  vertical-align: bottom;
  margin-right: 8px;
  margin-left: 2px;
  font-size: 25px;
}

.place-metro {
  font-size: 13px;
  margin: 0 0 0 51px;
}

.place-metro:before {
  content: 'ст.м. ';
}

.place-site {
  margin: 10px 0 0 25px;
}

.place-email {
  margin: 10px 0 0 25px;
}

.place-tel {
  margin: 10px 0 0 25px;
}
</style>
