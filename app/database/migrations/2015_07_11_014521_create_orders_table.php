<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
            $table->increments('id');

            $table->integer('user_id')->unsigned();

            $table->float('amount');
            $table->string('promo', 255);
            $table->float('discount');
            $table->float('net_amount');

            $table->string('shipping_name', 255);
            $table->string('shipping_address', 1000);
            $table->string('shipping_city', 255);
            $table->string('shipping_state', 255);
            $table->string('shipping_country', 255);
            $table->string('shipping_zip', 20);
            $table->string('shipping_land_mark', 1000);
            $table->string('shipping_contact_number_1', 20);
            $table->string('shipping_contact_number_2', 20);

            $table->string('billing_name', 255);
            $table->string('billing_address', 1000);
            $table->string('billing_city', 255);
            $table->string('billing_state', 255);
            $table->string('billing_country', 255);
            $table->string('billing_zip', 20);
            $table->string('billing_land_mark', 1000);
            $table->string('billing_contact_number_1', 20);
            $table->string('billing_contact_number_2', 20);

            $table->string('status', 50);

            $table->foreign('user_id')->references('id')->on('users');

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
		Schema::table('orders', function(Blueprint $table)
		{
			//
		});
	}

}
