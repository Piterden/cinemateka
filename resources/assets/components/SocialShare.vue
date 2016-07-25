<template>
  <div class="social-share">
    <a @click.prevent="shareFacebook"><img :src="iconFacebook"></a>
    <a @click.prevent="shareVkontakte"><img :src="iconVkontakte"></a>
    <a @click.prevent="shareTwitter"><img :src="iconTwitter"></a>
  </div>
</template>
<script>
export default {

  props: [
    'iconFacebook',
    'iconVkontakte',
    'iconTwitter',
    'postUrl',
    'postTitle',
    'postText',
    'postImg'
  ],

  methods: {
    shareFacebook() {
      // let url  = 'http://www.facebook.com/sharer.php?s=100'
      //   + '&p[title]='     + encodeURIComponent(this.postTitle)
      //   + '&p[summary]='   + encodeURIComponent(this.postText)
      //   + '&p[url]='       + encodeURIComponent(this.postUrl)
      //   + '&p[image]=' + encodeURIComponent(this.postImg)
      let url = 'https://www.facebook.com/sharer.php?u=' + encodeURIComponent(this.postUrl)
      this.popup(url)
    },
    shareVkontakte() {
      let url = 'http://vkontakte.ru/share.php?'
        + 'url='          + encodeURIComponent(this.postUrl)
        + '&title='       + encodeURIComponent(this.postTitle)
        + '&description=' + encodeURIComponent(this.postText)
        + '&image='       + encodeURIComponent(this.postImg)
        + '&noparse=true'
      this.popup(url)
    },
    shareTwitter() {
      let url  = 'http://twitter.com/share?'
        + 'text='      + encodeURIComponent(this.postTitle)
        + '&url='      + encodeURIComponent(this.postUrl)
        + '&counturl=' + encodeURIComponent(this.postUrl)
      this.popup(url)
    },
    popup(url) {
      window.open(url,'','toolbar=0,status=0,width=626,height=436')
    }
  }
}
</script>
<style lang="css" scoped>
</style>
