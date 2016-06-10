<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seances', function (Blueprint $table) {

            /**
             * Columns
             */
            $table->increments('id');

            $table->integer('event_id')->unsigned()->comment('Событие');
            $table->integer('program_id')->unsigned()->comment('Программа');

            $table->dateTime('start_time')->comment('Дата и время проведения');
            $table->string('place', 100)->comment('Площадка (кинотеатр)');
            $table->integer('price')->unsigned()->nullable()->comment('Цена билета');
            $table->string('description')->comment('Описание');

            $table->mediumtext('speaker_info')->comment('Информация о спикере');
            $table->mediumtext('images')->comment('Изображение или набор изображений {$Images}');
            $table->mediumtext('videos')->comment('Видеоролик {video}');
            $table->mediumtext('properties');

            $table->timestamps();
            $table->softDeletes();

            /**
             * Indexes
             */
            $table->index('event_id');
            $table->index('program_id');
            $table->index('start_time');
            $table->index('place');
            $table->index('price');

            /**
             * Foreign keys
             */
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('program_id')->references('id')->on('programs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seances');
    }
}
