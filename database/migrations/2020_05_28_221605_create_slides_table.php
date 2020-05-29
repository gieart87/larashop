<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(
			'slides',
			function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->unsignedBigInteger('user_id');
				$table->string('title');
				$table->string('url')->nullable();
				$table->integer('position')->default(0);
				$table->string('status');
				$table->text('body')->nullable();
				$table->string('original')->nullabel();
				$table->string('extra_large')->nullabel();
				$table->string('small')->nullabel();
				$table->timestamps();

				$table->foreign('user_id')->references('id')->on('users');
				$table->index('user_id');
			}
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('slides');
	}
}
