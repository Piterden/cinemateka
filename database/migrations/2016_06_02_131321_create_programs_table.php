<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {

            /**
             * Columns
             */
            $table->increments('id');
            $table->boolean('published')->default(1)->comment('Опубликовано');

            $table->string('title', 255)->comment('Название события');
            $table->string('slug', 255)->comment('Псевдоним (необходим для формирования маршрута)');
            $table->string('description')->comment('Описание');

            $table->dateTimeTz('start_date')->comment('Дата начала');
            $table->dateTimeTz('end_date')->comment('Дата конца');

            $table->string('slogan', 255)->default('')->comment('Слоган');

            $table->mediumtext('videos')->comment('Видеоролик {video}');
            $table->mediumtext('images')->comment('Изображение или набор изображений {$Images}');
            $table->mediumtext('meta')->comment('META Tags');
            $table->mediumtext('properties');

            $table->timestamps();
            $table->softDeletes();

            /**
             * Indexes
             */
            $table->index('published');
            $table->index('title');
            $table->index('slug');
            $table->index('start_date');
            $table->index('end_date');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programs');
    }
}
