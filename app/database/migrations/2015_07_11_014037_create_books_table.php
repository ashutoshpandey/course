<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('books', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('course_id')->unsigned();

			$table->string('name', 255);
			$table->string('subject', 255);
			$table->string('author', 255);
			$table->string('publication', 255);
			$table->float('price');
			$table->float('discounted_price');
			$table->string('book_type', 255);
			$table->string('picture_1', 255);
			$table->string('picture_2', 50);
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
		Schema::table('books', function(Blueprint $table)
		{
			//
		});
	}

}
