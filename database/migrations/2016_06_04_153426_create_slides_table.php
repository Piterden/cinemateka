<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {

            /**
             * Columns
             */
            $table->increments('id');
            $table->enum('slider', ['На главной'])->comment('Размещение');
            $table->boolean('published')->default(1)->comment('Показывать');

            $table->string('title', 255)->comment('Название слайда');
            $table->string('src')->comment('Ссылка на изображение');
            $table->mediumtext('caption')->comment('Дополнительный текст');

            $table->timestamps();
            $table->softDeletes();

            /**
             * Indexes
             */
            $table->index('title');
            $table->index('published');
            $table->index('slider');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slides');
    }
}
