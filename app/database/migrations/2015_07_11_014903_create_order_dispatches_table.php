<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDispatchesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_dispatches', function(Blueprint $table)
		{
            $table->increments('id');

            $table->integer('order_id')->unsigned();
			$table->integer('courier_id')->unsigned();
			$table->string('docket', 255);
            $table->string('status', 50);

			$table->foreign('order_id')->references('id')->on('orders');
			$table->foreign('courier_id')->references('id')->on('couriers');

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
		Schema::table('order_dispatches', function(Blueprint $table)
		{
			//
		});
	}

}
