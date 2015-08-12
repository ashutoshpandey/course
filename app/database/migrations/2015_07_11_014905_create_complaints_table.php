<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('complaints', function(Blueprint $table)
		{
            $table->increments('id');

            $table->integer('user_id')->unsigned()->nullable();
			$table->string('contact_number', 25);
			$table->string('email', 255);
			$table->string('name', 255);
			$table->text('description');
			$table->integer('software_user_id')->unsigned();
            $table->string('status', 50);

			$table->foreign('software_user_id')->references('id')->on('software_users');

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
		Schema::table('complaints', function(Blueprint $table)
		{
			//
		});
	}

}
