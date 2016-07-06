<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('places'))
        {
            Schema::create('places', function (Blueprint $table)
            {
                /**
                 * Columns
                 */
                $table->increments('id');
                $table->boolean('published')->default(1)->comment('Опубликовано');

                $table->string('title', 255)->comment('Название кинотеатра');
                // $table->string('slug', 255)->comment('Псевдоним (необходим для формирования маршрута)');
                $table->string('address', 255)->comment('Адрес');
                $table->string('metro', 255)->comment('Ближайшая станция метро');

                $table->mediumtext('description')->comment('Описание');
                $table->mediumtext('images')->comment('Изображение или набор изображений');
                $table->mediumtext('properties');
                $table->string('position');

                $table->timestamps();
                $table->softDeletes();

                /**
                 * Indexes
                 */
                $table->index('title');
                // $table->index('slug');
                $table->index('published');
                $table->index('address');
                $table->index('metro');

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
        Schema::dropIfExists('places');
    }
}
