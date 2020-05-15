<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * AddStatusToPaymentsTable
 *
 * PHP version 7
 *
 * @category AddStatusToPaymentsTable
 * @package  AddStatusToPaymentsTable
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class AddStatusToPaymentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table(
			'payments',
			function (Blueprint $table) {
				$table->string('status')->after('method')->nullable();
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
		Schema::table(
			'payments',
			function (Blueprint $table) {
				$table->dropColumn('status');
			}
		);
	}
}
