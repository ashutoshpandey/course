<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_addresses', function(Blueprint $table)
		{
            $table->increments('id');

            $table->integer('user_id')->unsigned();

            $table->string('name', 255);
            $table->string('address', 1000);
            $table->string('address_type', 20);                 // shipping, billing
            $table->string('city', 255);
            $table->string('state', 255);
            $table->string('country', 255);
            $table->string('zip', 20);
            $table->string('land_mark', 1000);
            $table->string('contact_number_1', 20);
            $table->string('contact_number_2', 20);
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
		Schema::table('user_addresses', function(Blueprint $table)
		{
			//
		});
	}

}
