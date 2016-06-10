<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {

            /**
             * Columns
             */
            $table->increments('id');
            $table->boolean('published')->default(1)->comment('Опубликовано');

            $table->string('title', 255)->comment('Название события');
            $table->string('slug', 255)->comment('Псевдоним (необходим для формирования маршрута)');
            $table->string('event_type', 100)->default('movie')->comment('Тип события (фильм, лекция, выставка, конференция)');
            $table->string('description')->comment('Описание');

            $table->string('orig_title', 255)->default('')->comment('Оригинальное название');
            $table->string('year', 50)->default('')->comment('Год');
            $table->string('country', 100)->default('')->comment('Страна');
            $table->string('carrier', 50)->default('')->comment('Носитель (DCP, 35 mm, Blu-ray)');
            $table->string('language', 2)->default('')->comment('Язык');
            $table->string('subtitles', 100)->default('')->comment('Субтитры или дубляж');
            $table->string('director', 255)->default('')->comment('Режиссер');
            $table->string('writtenby', 255)->default('')->comment('Сценарист');
            $table->string('operator', 255)->default('')->comment('Оператор');
            $table->string('producer', 255)->default('')->comment('Продюсер');
            $table->string('link')->default('')->comment('Ссылка на официальный сайт');

            $table->integer('chrono')->unsigned()->default(0)->comment('Хронометраж');
            $table->integer('age_restrictions')->unsigned()->default(0)->comment('Возрастные ограничения');

            $table->mediumtext('meta')->comment('META Tags');
            $table->mediumtext('actors')->comment('Актеры в главных ролях');
            $table->mediumtext('awards')->comment('Награды и фестивали');
            $table->mediumtext('videos')->comment('Видеоролик {video}');
            $table->mediumtext('images')->comment('Изображение или набор изображений {$Images}');
            $table->mediumtext('properties');

            $table->timestamps();
            $table->softDeletes();

            /**
             * Indexes
             */
            $table->index('published');
            $table->index('title');
            $table->index('slug');
            $table->index('event_type');
            $table->index('orig_title');
            $table->index('year');
            $table->index('country');
            $table->index('language');
            $table->index('subtitles');
            $table->index('age_restrictions');
            $table->index('director');
            $table->index('writtenby');
            $table->index('operator');
            $table->index('producer');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
