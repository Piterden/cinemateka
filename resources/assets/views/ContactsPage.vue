<style lang="css">
.map-wrapper {
  position: relative;
}
#map canvas {
  filter: grayscale(100%);
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
.collapsible-header {

}
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

<template>
  <div id="map" v-bind:style="{
    width: mapWidth + 'px',
    height: mapHeight + 'px'
  }">
    <list-places
      :places.once="places"
      :active-place-index.sync="activePlace"
    ></list-places>
  </div>
</template>

<script type="text/javascript">

// let myMap, myPlacemark, zoomControl

export default {

  data() {
    return {
      places: this.$root.places
    }
  },

  props: {
    myMap: Object,
    myPlacemark: Object,
    mapWidth: {
      type: Number,
      default() {
        return window.innerWidth
      }
    },
    mapHeight: {
      type: Number,
      default() {
        return window.innerHeight
      }
    },
    activePlace: {
      type: Number,
      default() {
        return 0
      },
      twoWay: true
    }
  },

  methods: {
    /**
     * При изменении размера окна и один раз при загрузке
     * изменяет размеры фрейма карты
     * @param  {Event} e DOM event
     */
    handleResize(e) {
      if (e !== undefined) e.preventDefault
      this.mapWidth = window.innerWidth
      this.mapHeight = window.innerHeight - 96 - 87
    },

    /**
     * Коллбек обхода массива площадок
     * @param {Object} place      Объект одной площадки
     * @param {Number} index      Индекс объекта в массиве
     */
    addPlacemarkToMap(place, index) {
      // Назначаем параметры меткам
      this.myPlacemark = new ymaps.Placemark(this.myMap.getCenter(), {
        hintContent: '<strong></strong><span></span>',
        balloonContent: '<strong></strong><span></span>'
      }, {
        iconLayout: 'default#image',
        iconImageHref: '/images/img-home-pin.png',
        iconImageSize: [44, 44],
        iconImageOffset: [-22, -44]
      })

      // И добавляем метки на карту
      this.myMap.geoObjects.add(this.myPlacemark)
    },

    /**
     * Инициализация карты
     */
    mapsInit() {
      ymaps.ready(() => { // По готовности карты
        // let activePlaceObject = this.places[this.activePlace]

        this.myMap = new ymaps.Map('map', {
          center: [55.7671, 37.5937],
          zoom: 15,
          controls: ['fullscreenControl', 'zoomControl', 'searchControl', 'typeSelector']
        }, {
          searchControlProvider: 'yandex#search'
        })

        this.places.forEach(this.addPlacemarkToMap)
      })
    },

  },

  ready() {
    this.handleResize()
    this.mapsInit()

    window.removeEventListener('resize', this.handleResize)
    window.addEventListener('resize', this.handleResize)
  },

  beforeDestroy() {
    window.removeEventListener('resize', this.handleResize)
    this.myMap.destroy()
  }

}
</script>
