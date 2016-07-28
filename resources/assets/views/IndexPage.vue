<style lang="css">

</style>

<template lang="html">
  <div class="wrap router-view {{ $options.name }}">
    <swipe
      :speed="600"
      :auto="0"
      :continuous="true"
      :show-indicators="true"
      :show-nav="true"
      :no-drag-when-single="true"
      :prevent="false"
    ><swipe-item
        v-for="slide in slides"
        class="slide"
        :style="{ backgroundImage: 'url(/' + slide.src + ')'}"
      >
        <a v-link="slide.link">
          <div v-if="slide.caption" class="caption-wrapper">
            <div v-if="slide.caption.caption_title" class="caption-title">
              {{ slide.caption.caption_title }}
            </div>
            <div v-if="slide.caption.caption_content" class="caption-content">
              {{ slide.caption.caption_content }}
            </div>
          </div>
        </a>
      </swipe-item>
    </swipe>
    <index-page-soon></index-page-soon>
  </div>
</template>
<script>
export default {

  computed: {
    slides() {
      return this.$root.getPublished(this.$root.slides)
    },
    selfImageUrl() {
      return this.slides.length && this.slides[0].src
    }
  },

  methods: {
    /**
     * Срабатывает при нажатии на таб месяца
     */
    clickSoonTab(name) { // 'month$'
      let i = name.slice(5)
      this.$set('month.activeTab', Number(i))
    }
  },

  head: {
    title() {
      return {
        inner: 'Кино в городе'
      }
    },
    meta() {
      return {
        name: {
          'application-name': this.$root.meta.app,
          description: 'description on index',
          'twitter:title': 'Главная - Кино в городе',
          'twitter:description': 'description on index',
          'twitter:image': this.selfImageUrl
        },
        itemprop: {
          name: 'Главная - Кино в городе',
          description: 'description on index',
          image: this.selfImageUrl
        },
        property: {
          // 'fb:app_id': 123456789,
          'og:url': this.selfUrl,
          'og:title': 'Главная - Кино в городе',
          'og:description': 'description on index',
          'og:image': this.selfImageUrl
        }
      }
    }
  }
}
</script>

