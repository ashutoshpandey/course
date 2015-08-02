<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
            $table->increments('id');

            $table->integer('course_id')->unsigned();

            $table->string('name', 255);                // blood group, weight etc.
            $table->string('subject', 255);
            $table->string('author', 255);
            $table->float('price');
            $table->float('discounted_price');
            $table->date('publish_date');
            $table->string('product_type', 255);           // regular, supplementary
            $table->string('status', 50);

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
		Schema::table('products', function(Blueprint $table)
		{
			//
		});
	}

}
