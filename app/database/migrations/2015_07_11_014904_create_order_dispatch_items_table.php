<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDispatchItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_dispatch_items', function(Blueprint $table)
		{
            $table->increments('id');

            $table->integer('order_dispatch_id')->unsigned();
			$table->integer('order_item_id')->unsigned();
            $table->string('status', 50);

			$table->foreign('order_dispatch_id')->references('id')->on('order_dispatches');

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
		Schema::table('order_dispatch_items', function(Blueprint $table)
		{
			//
		});
	}

}
