<style lang="css" scoped>
	.event-image {
		background-image: url(/images/events/img-events-wide-01.jpg);
    	/* background-position: left bottom; /* Положение фона */
    	background-repeat: no-repeat; /* Повторяем фон по горизонтали */
    	background-size: cover;
		height: 411px;
		width: 100%;
		position: relative;
		color: white;
	}
	.event-date {
		font-size: 48px;
		position: absolute;
		top: 50px;
		left: 40px;
	}
	.event-title {
		font-size: 48px;
		position: absolute;
		top: 111px;
		left: 40px;
		max-width: 500px;
		font-weight: bold;
		line-height: 50px;
	}
	.event-programm {
		position: absolute;
		top: 336px;
		left: 40px;
	}
	.event-programm a {
		color: white;
		text-decoration: underline;

	}
	.event-video {
		width: 535px;
		height: 307px;
		position: absolute;
		right: 40px;
		bottom: 50px;
		background-color: grey;
	}
	.event-param {
		display: inline-block;
		border-bottom: 2px solid black;
	    margin-top: 20px;
		margin-bottom: 30px;
		width: 100%;
		padding-bottom: 40px;
		text-align: right;
		position: relative;
	}
	.event-time {
		display: inline-block;
		position: absolute;
		left: 0;
		font-size: 32px;
	}
	.event-place {
		display: inline-block;
		margin-right: 100px;
	}
	.event-place i, .event-price i {
		vertical-align: bottom;
	}
	.event-price {
		display: inline-block;
		position: absolute;
		right: 0;
	}
	.event-more-info {
		margin-top: 45px;
	}
	.more-info-table td {
		margin-right: 18px;
	}
	.more-info-table tr td:first-child {
		font-weight: bold;
	}
</style>
<template>
  <div class="wrap router-view event-page">
  	<div class="event-image">
  		<div class="event-date">31.10</div>
  		<div class="event-title">Андалузский пес Ан дал узский пес Ан</div>
  		<div class="event-programm">
        <a href="#">Биеннале авангардного кино</a>
      </div>
  		<div class="event-video"></div>
  	</div>
    <div class="mdl-grid">
    	<div class="mdl-cell mdl-cell--7-col">
    		<div class="event-desc">
    			<div class="event-param">
    				<div class="event-time"><i class="material-icons">query_builder</i>19:00</div>
    				<div class="event-place"><i class="material-icons">place</i>Художественный</div>
    				<div class="event-price"><i class="material-icons">account_balance_wallet</i><strong>300</strong> р</div>
    			</div>
    			<div class="event-desc-text">
    				111 111Описание структуры таблиц БД, в которых сайт хранит данные, а также связей между ними. Здесь приводится не вся структура БД, а только необходимая для решения  задач сайта часть.Статическая страницаСписок необходимых полей:ЗаголовокПсевдоним (необходим для формирования маршрута)Аннотация (короткий текст, тизер)Содержимое (контент)Опубликовано (да/нет)Д1111111
    			</div>
    		</div>
    		<div class="event-more-info">
    			<h3>Подробнее о фильме</h3>
    			<table class="more-info-table">
    				<tbody>
    					<tr>
    						<td>Оригин. название</td>
    						<td>Un chien andalou</td>
    						<td rowspan="15"><strong>В главных ролях:</strong><br>
    							Симона Марёй<br>
    							Пьер Батчефф<br>
    							Луис Бунюэль<br>
    							Сальвадор Дали<br>
    							Роберт Хоммет<br>
    							Марвал<br>
    							Фано Мессан<br>
    							Жоме Миравитлье
    						</td>
    					</tr>
    					<tr>
    						<td>Cлоган</td><td>«Viva la France!»</td>
    					</tr>
    					<tr>
    						<td>Год</td><td>1929</td>
    					</tr>
    					<tr>
    						<td>Страна</td><td>Франция</td>
    					</tr>
    					<tr>
    						<td>Хронометраж</td><td>17 мин.</td>
    					</tr>
    					<tr>
    						<td>Носитель</td><td>DCP</td>
    					</tr>
    					<tr>
    						<td>Язык</td><td>французский</td>
    					</tr>
    					<tr>
    						<td>Субтитры</td><td>да</td>
    					</tr>
    					<tr>
    						<td>Режиссер</td><td>Луис Бунюэль</td>
    					</tr>
    					<tr>
    						<td>Сценарий</td><td>Сальвадор Дали</td>
    					</tr>
    					<tr>
    						<td>Оператор</td><td>Луис Бунюэль</td>
    					</tr>
    					<tr>
    						<td>Продюсер</td><td>Альбер Дюверте</td>
    					</tr>
    					<tr>
    						<td>Ограничения</td><td>16+</td>
    					</tr>
    					<tr>
    						<td>Награды / фестивали</td><td>-</td>
    					</tr>
    					<tr>
    						<td>Cайт</td><td>-</td>
    					</tr>
    				</tbody>
    			</table>
    		</div>
    	</div>
    </div>
  </div>
</template>

<script>
export default {

  name: 'event-page',

  data () {
    return {

    };
  }
};
</script>
