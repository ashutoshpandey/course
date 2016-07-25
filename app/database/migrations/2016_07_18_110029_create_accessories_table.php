<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessoriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     * accessories
     */
    public function up()
    {
        //
        Schema::create('accessories', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('course_id')->unsigned();

            $table->string('name', 255);
            $table->text('description');

            $table->float('cost_price');
            $table->float('sale_price');
            $table->string('accessories_type', 255);
            $table->string('picture_1', 255);
            $table->string('picture_2', 255);
            $table->string('picture_3', 255);
            $table->string('picture_4', 255);
            $table->string('status', 10);

            $table->foreign('course_id')->references('id')->on('courses');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

}
