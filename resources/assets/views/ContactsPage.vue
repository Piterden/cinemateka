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
  top: 191px;
  left: 41px;
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
  /* vertical-align: bottom; */
  margin-right: 8px;
  /* padding: 5px 2px 1px 7px; */
  display: inline-block;
  font-size: 13px;
  line-height: 20px;
  /* margin-right: 3px; */
}

.place-name {
  display: inline-block;
  font-weight: bold;
  /* line-height: 20px; */
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
  margin-right: 5px;
}

.place-tel i {
  vertical-align: bottom;
  margin-right: 10px;
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

<template lang="html">
  <div class="wrap router-view contacts-page map-wrapper"
    :style="{ width: mapWidth + 'px', height: mapHeight + 'px' }"
  >
    <map id="map"
      :center.sync="center"
      :zoom.sync="12"
      :options="options"
    >
      <list-places
        :places="places"
        :cursor-index="activeIndex || 0"
      ></list-places>
      <marker
        v-for="place in places"
        :clickable.sync="true"
        :title.sync="place.title"
        :cursor.sync="'pointer'"
        :draggable.sync="false"
        :label.sync="place.place_type"
        :position.sync="center"
        :place.sync="markerPlace"
        @g-click="center=place.position"
      ></marker>
    </map>
  </div>
</template>

<script type="text/javascript">

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
    mapWidth: { type: Number, default: window.innerWidth },
    mapHeight: { type: Number, default: window.innerHeight },
    activeMarker: { type: Number, default: 0 }
  },

  computed: {
    center() {
      return {
        lat: 59.94501723763008,
        lng: 390.3447668507324
      }
    },
    activeIndex() {
      return this.$root.getIndexById(this.places, this.activeMarker)
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
    }
  },

  ready() {
    // this.initMap()
    this.places = this.places.map((pl) => {
      pl.propsObj = pl.properties && JSON.parse(pl.properties)
      pl.propsObj = pl.propsObj || {}
      pl.propsObj.place_type = pl.propsObj.place_type || ''

      let url = 'https://maps.googleapis.com/maps/api/geocode/json?address=',
        addr = pl.propsObj.place_type + ' ' + pl.title + ' ' + pl.address
      url += addr.replace(' ', '+')



      $.ajax({ url: url, data: {}, method: 'POST',
        success(res) {
          pl.geo = res.results[0]
          // console.log(pl);
        },
        error(res) {
          // console.log('error', res)
        }
      })
      // loaded.then(() => {
      // })
      return pl
    })
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
