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
        if (!Schema::hasTable('slides'))
        {
            Schema::create('slides', function (Blueprint $table)
            {

                /**
                 * Columns
                 */
                $table->increments('id');
                $table->enum('slider', ['На главной'])->comment('Размещение');
                $table->boolean('published')->default(1)->comment('Показывать');
                $table->integer('category_id')->unsigned()->nullable()->comment('ID слайдера');

                $table->string('title', 255)->comment('Название слайда');
                $table->string('src')->comment('Ссылка на изображение');
                $table->mediumtext('caption')->comment('Дополнительный текст');

                $table->timestamps();
                // $table->softDeletes();

                /**
                 * Indexes
                 */
                $table->index('title');
                $table->index('published');
                $table->index('slider');
                $table->index('src');
                $table->index('category_id');

                // $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            });
        }
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
