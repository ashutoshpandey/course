<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstituteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('institutes', function(Blueprint $table)
		{
            $table->increments('id');

            $table->string('name', 255);
            $table->dateTime('establish_date');
            $table->string('address', 1000);
            $table->integer('location_id')->unsigned();
            $table->string('land_mark', 1000);
            $table->string('contact_number_1', 20);
            $table->string('contact_number_2', 20);
			$table->float('latitude');
			$table->float('longitude');
			$table->string('zip', 20);
            $table->string('affiliation', 255);

            $table->string('status', 50);

			$table->foreign('location_id')->references('id')->on('locations');

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
		Schema::table('institutes', function(Blueprint $table)
		{
			//
		});
	}

}
