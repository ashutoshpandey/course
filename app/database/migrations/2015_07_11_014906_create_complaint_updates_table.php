<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintUpdatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('complaint_updates', function(Blueprint $table)
		{
            $table->increments('id');

            $table->integer('complaint_id')->unsigned()->nullable();
			$table->integer('software_user_id')->unsigned();
			$table->text('description');
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
