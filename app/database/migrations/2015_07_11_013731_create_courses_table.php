<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('courses', function(Blueprint $table)
		{
            $table->increments('id');

            $table->integer('institute_id')->unsigned();

            $table->string('name', 255);                // blood group, weight etc.
            $table->string('description', 1000);
            $table->string('status', 50);

            $table->foreign('institute_id')->references('id')->on('institutes');

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
		Schema::table('courses', function(Blueprint $table)
		{
			//
		});
	}

}
