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
        <a v-if="external(slide.link)" :href="slide.link" target="_blank">
          <div v-if="hasText(slide)" class="caption-wrapper">
            <div v-if="slide.caption.caption_title" class="caption-title">
              {{{ slide.caption.caption_title }}}
            </div>
            <div v-if="slide.title" class="caption-title">
              {{{ slide.title }}}
            </div>
            <div v-if="slide.caption.caption_content" class="caption-content">
              {{{ slide.caption.caption_content }}}
            </div>
          </div>
        </a>
        <a v-else v-link="slide.link">
          <div v-if="hasText(slide)" class="caption-wrapper">
            <div v-if="slide.caption.caption_title" class="caption-title">
              {{{ slide.caption.caption_title }}}
            </div>
            <div v-if="slide.title" class="caption-title">
              {{{ slide.title }}}
            </div>
            <div v-if="slide.caption.caption_content" class="caption-content">
              {{{ slide.caption.caption_content }}}
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
    },
    /**
     * Проверка внешней ссылки
     */
    external(link) {
      return link.startsWith('http')
    },
    /**
     * Проверка на наличие текста у слайда
     */
    hasText(slide) {
      return slide.title || slide.caption && slide.caption.caption_title
    }
  },

  head: {
    title() {
      return {
        inner: 'Главная',
        separator: '|',
        complement: this.$root.meta.app
      }
    },
    meta() {
      let description = '',
        title = this.$root.meta.app,
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
          'og:url': '',
          'og:title': title,
          'og:description': description,
          'og:image': image
        } //' comment to fix sublime highlighting
      }
    }
  }
}
</script>

