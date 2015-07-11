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

            $table->string('title');                // blood group, weight etc.
            $table->string('data');
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
