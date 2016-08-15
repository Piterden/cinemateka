<template>
  <div class="mdl-grid error-wrapper">
    <div class="mdl-cell mdl-cell--7-col">
			<div class="error-box err-low">
  			<svg>
    			<text y="130">404</text>
  			</svg>
  			<h1>Страница не найдена</h1>
  			Неправильно набран адрес, или такой страницына сайте больше не существует.<br><br>
  			Вернуться на <a v-link="{ path: '/' }">главную страницу.</a>
			</div>
      {{ history | json }}
		</div>
	</div>
</template>

<script>
export default {

  data() {
    return {
      history: window.history
    }
  },

  head: {
    title() {
      return {
        inner: 'Страница не найдена',
        separator: '|',
        complement: this.$root.meta.app
      }
    },
    meta() {
      let description = '',
        title = 'Страница не найдена - ' + this.$root.meta.app,
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
.mdl-grid, .mdl-cell {
  height: 100%;
}
.error-box {
  width: 380px;
  height: 285px;
  margin: 70px 40px 250px;
  padding: 0 30px 0 370px;
  font-size: 16px;
  border: 4px solid red;
  position: relative;
}
.error-box h1 {
  font-size: 48px;
  white-space: nowrap;
  margin-bottom: 17px;
  letter-spacing: .03em;
}
.error-box:before {
  content: '';
  position: absolute;
  width: 260px;
  top: 215px;
  left: 50px;
  border-bottom: 2px solid red;
  transform: rotate(9deg);
}
.error-box svg {
  font-size: 154px;
  color: red;
  position: absolute;
  top: 23px;
  left: 50px;
}
.error-box svg text {
  fill: none;
  stroke: red;
  stroke-width: 2px;
  /* stroke-dasharray: 2,2; */
  /* stroke-linejoin: round; */
}
.err-low h1 {
  margin-top: 140px;
}
</style>
