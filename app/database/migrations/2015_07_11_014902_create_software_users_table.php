<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftwareUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('software_users', function(Blueprint $table)
		{
            $table->increments('id');

            $table->string('username', 255);
            $table->string('password', 255);
            $table->string('name', 255);
            $table->string('contact_number', 20);
            $table->string('email', 255);
            $table->string('gender', 20);

            $table->string('user_type', 20);                // admin, normal etc.
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
		Schema::table('software_users', function(Blueprint $table)
		{
			//
		});
	}

}
