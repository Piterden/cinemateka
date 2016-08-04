<template>
  <div>
    <div class="mdl-grid">
      <div class="mdl-cell mdl-cell--7-col">
        <h1>Партнеры</h1>
        
Правительство Санкт-Петербурга / http://gov.spb.ru/gov/admin/<br>
Год российского кино / http://god-kino2016.ru/<br>
Культурный форум / https://culturalforum.ru/ru<br>
Госфильмофонд России / http://gosfilmofond.ru/<br>
Ленфильм / http://www.lenfilm.ru/<br>
Мосфильм / http://mosfilm.ru/main.php<br>
Родина / http://rodinakino.ru/<br>
Аврора / http://www.avrora.spb.ru/<br>
Новая сцена Александринского театра / http://thenewstage.ru/<br>
Порядок слов / http://wordorder.ru/ / <br>
Кино ТВ / http://kinochannel.ru/<br>
Дорожное радио / https://dorognoe.ru/?region=piter<br>
ТВ Санкт-Петербург / http://topspb.tv/<br>
Киноафиша / http://www.kinoafisha.spb.ru/<br>
Культкино / http://cultofcinema.com/<br>
2do2go / http://www.2do2go.ru/spb<br>
Kudago / http://kudago.com/spb/ <br>
Бумага / http://paperpaper.ru/<br>
Вилладж / http://paperpaper.ru/<br>
Newsdale / http://www.newsdale.ru/<br>
Буквоед / http://www.bookvoed.ru/<br>
Больше кофе / https://new.vk.com/morecoffee<br>
Хроники / https://new.vk.com/xronikibar<br>
"Афиша" // http://www.afisha.ru<br>
"Петербург2" // http://peterburg2.ru<br>

      </div>
    </div>
  </div>
</template>
<script>
export default {

  head: {
    title() {
      return {
        inner: 'О проектe',
        separator: '|',
        complement: this.$root.meta.app
      }
    },
    meta() {
      let description = '',
        title = 'О проектe - ' + this.$root.meta.app,
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
          // 'fb:app_id': this.$root.meta.fbAppId,
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
<style lang="css" scoped>
</style>
