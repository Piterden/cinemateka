<style lang="css" scoped>

.error-box {
  position: absolute;
  width: 380px;
  height: 285px;
  top: 70px;
  left: 40px;
  padding: 0 30px 0 370px;
  font-size: 16px;
  border: 4px solid red;
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
<template>
  <div class="mdl-grid error-wrapper">
    <div class="mdl-cell mdl-cell--7-col">
			<div class="error-box err-low">
  			<svg>
    			<text y="130">404</text>
  			</svg>
  			<h1>Страница не найдена</h1>
  			Неправильно набран адрес, или такой страницына сайте больше не существует.<br><br>
  			Вернуться на главную страницу.
			</div>
		</div>
	</div>
</template>
<script>
export default {

  data() {
    return {

    }
  }
}
</script>
