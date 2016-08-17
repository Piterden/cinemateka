<template>
  <div class="vert-fluid">
    <div class="mdl-grid">
      <div class="mdl-cell mdl-cell--7-col">
        <h1>О проектe</h1>
        <p>Проект «Кино в городе. Петербургская синематека» — естественное продолжение всей деятельности журнала «Сеанс» на протяжении двадцати шести лет. Журнал был задуман как профессиональное издание о кино, но уже с первого номера редакция не мыслила кинематографических штудий вне контекста, вне пространства и времени, в которых кино и журнал создаются.</p>
        <p>«Кино в городе. Петербургская синематека» помогает зрителям, которые ждут от кинематографа не просто развлечений, посмотреть на большом экране фильмы, которые сегодня не показывают в кино.  Фильмы рождаются и существует в контексте — социальном, политическом, культурном. Даже на популярные и классические ленты можно и нужно взглянуть по-новому. Поэтому каждый сеанс «Кино в городе», сопровожденный выступлением профессионального киноведа, — не просто кинопоказ, но попытка погружения в контекст и время.</p>
      </div>
    </div>
  </div>
</template>
<script>
export default {

  methods: {
    handleResize(e) {
      if (e !== undefined) {
        e.preventDefault()
        e.stopPropagation()
      }
      document.querySelector('.vert-fluid').style
        .minHeight = Number(window.innerHeight - 96 - 87) + 'px'
    }
  },

  ready() {
    this.handleResize()
    window.removeEventListener('resize', this.handleResize)
    window.addEventListener('resize', this.handleResize)
  },

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
<style lang="css" scoped>
</style>
