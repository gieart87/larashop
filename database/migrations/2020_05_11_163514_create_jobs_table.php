<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreateJobsTable
 *
 * PHP version 7
 *
 * @category CreateJobsTable
 * @package  CreateJobsTable
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class CreateJobsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(
			'jobs',
			function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('queue')->index();
				$table->longText('payload');
				$table->unsignedTinyInteger('attempts');
				$table->unsignedInteger('reserved_at')->nullable();
				$table->unsignedInteger('available_at');
				$table->unsignedInteger('created_at');
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
		Schema::dropIfExists('jobs');
	}
}
