<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouriersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('couriers', function(Blueprint $table)
		{
            $table->increments('id');

            $table->string('name', 50);
            $table->string('contact_person', 50);
            $table->string('address', 1000);
            $table->string('city', 255);
            $table->string('state', 255);
            $table->string('country', 255);
            $table->string('zip', 20);
            $table->string('contact_number_1', 50);
            $table->string('contact_number_2', 50);
            $table->string('email', 255);
            $table->string('status', 50);

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
		Schema::table('couriers', function(Blueprint $table)
		{
			//
		});
	}

}
