<template lang="html">
  <div class="wrap router-view contacts-page map-wrapper"
    :style="{ width: mapWidth + 'px', height: mapHeight + 'px' }"
  >
    <list-places
      :places="places"
      :cursor-index="activeMarker"
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
        :icon.sync="markerIcon"
        :label.sync="place.title"
        :position.sync="place.position"
        :place.sync="markerPlace"
        @g-click="activatePlace(place)"
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
        color: '#ff0025',
        // fontFamily: '',
        fontSize: '24px',
        fontWeight: 'normal',
        text: ''
      },
      markerIcon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|FF0025',
      options: {
        scrollwheel: false
        // styles: [{
        //   featureType: 'poi',
        //   elementType: 'labels.icon',
        //   stylers: [
        //     { visibility: 'off' }
        //   ]
        // }]
      },
      center: {},
      activeMarker: 0
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
      this.$set('activeMarker', place.id)
      this.$set('center', place.position)
    },

    activatePlace(place) {
      this.$set('activeMarker', place.id)
      this.$set('center', place.position)
    }
  },

  route: {
    activate() {
      let activePlace = this.places && this.places[0]
      if (activePlace) {
        this.$set('center', activePlace.position)
        this.$set('activeMarker', activePlace.id)
      }
      this.handleResize()
      window.removeEventListener('resize', this.handleResize)
      window.addEventListener('resize', this.handleResize)
    },
    deactivate() {
      window.removeEventListener('resize', this.handleResize)
    }
  },

  head: {
    title() {
      return {
        inner: 'Площадки',
        separator: '|',
        complement: this.$root.meta.app
      }
    },
    meta() {
      let description = '',
        title = 'Площадки - ' + this.$root.meta.app,
        image = ''
      return {
        name: {
          'application-name': this.$root.meta.app,
          description: description,
          'twitter:title': title,
          'twitter:description': description,
          'twitter:image': image
        }, //' comment to fix sublime highlighting
        itemprop: {
          name: title,
          description: description,
          image: image
        },
        property: {
          'fb:app_id': this.$root.meta.fbAppId,
          'og:url': window.location.href,
          'og:title': title,
          'og:description': description,
          'og:image': image
        } //' comment to fix sublime highlighting
      }
    }
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
