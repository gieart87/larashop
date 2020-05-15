<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * AddPaymentTokenToOrdersTable
 *
 * PHP version 7
 *
 * @category AddPaymentTokenToOrdersTable
 * @package  AddPaymentTokenToOrdersTable
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class AddPaymentTokenToOrdersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table(
			'orders',
			function (Blueprint $table) {
				$table->string('payment_token')->after('payment_status')->nullable();
				$table->string('payment_url')->after('payment_token')->nullable();

				$table->index('payment_token');
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
			'orders',
			function (Blueprint $table) {
				$table->dropColumn('payment_token');
				$table->dropColumn('payment_url');
			}
		);
	}
}
