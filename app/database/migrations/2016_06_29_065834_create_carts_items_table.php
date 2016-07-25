<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cart_items', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('cart_id')->unsigned();
			$table->integer('book_id')->unsigned();

			$table->string('status', 10);

			$table->foreign('cart_id')->references('id')->on('carts');
			$table->foreign('book_id')->references('id')->on('books');

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
		Schema::create('cart_items', function(Blueprint $table)
		{
		});
	}

}
