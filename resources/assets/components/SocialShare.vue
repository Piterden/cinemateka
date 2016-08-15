<template>
  <div class="social-share">
    <a @click.prevent="shareFacebook"><img :src="iconFacebook"></a>
    <a @click.prevent="shareVkontakte"><img :src="iconVkontakte"></a>
    <a @click.prevent="shareTwitter"><img :src="iconTwitter"></a>
  </div>
</template>
<script>
export default {

  props: {
    iconFacebook:   { type: String },
    iconVkontakte:  { type: String },
    iconTwitter:    { type: String },
    postUrl:        { type: String, default() { return '' } },
    postTitle:      { type: String, default() { return '' } },
    postText:       { type: String, default() { return '' } },
    postImg:        { type: String, default() { return '' } }
  },

  methods: {
    // shareFacebook() {
    //   // let url  = 'http://www.facebook.com/sharer.php?s=100'
    //   //   + '&p[title]='     + this.e(this.postTitle)
    //   //   + '&p[summary]='   + this.e(this.postText)
    //   //   + '&p[url]='       + this.e(this.postUrl)
    //   //   + '&p[image]=' + this.e(this.postImg)
    // },

    shareFacebook() {
      // let url = 'https://www.facebook.com/sharer.php?s=100&' +
      //   'p[title]=' + this.postTitle + '&p[summary]=' + this.postText +
      //   '&p[url]=' + this.postUrl + '&p[images][0]=' + this.postImg
      // this.popup(url)
      let url = 'https://www.facebook.com/sharer.php?u=' + this.e(this.postUrl)
      this.popup(url)
    },

    shareVkontakte() {
      let url = 'https://vk.com/share.php?'
        + 'url=' + this.e(this.postUrl)
        + '&title=' + this.e(this.postTitle)
        + '&description=' + this.e(this.postText)
        + '&image=' + this.e(this.postImg)
        + '&noparse=true'
      this.popup(url)
    },

    shareTwitter() {
      let url = 'http://twitter.com/share?' + 'text=' + this.e(this.postTitle) + '&url=' + this.e(this.postUrl) + '&counturl=' + this.e(this.postUrl)
      this.popup(url)
    },

    popup(url) {
      window.open(url, '', 'toolbar=0,status=0,width=626,height=436')
    },

    e(str) {
      return encodeURIComponent(str)
    }
  }
}
</script>
<style lang="css" scoped>
</style>
