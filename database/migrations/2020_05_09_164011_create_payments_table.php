<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreatePaymentsTable
 *
 * PHP version 7
 *
 * @category CreatePaymentsTable
 * @package  CreatePaymentsTable
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class CreatePaymentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(
			'payments',
			function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->unsignedBigInteger('order_id');
				$table->string('number')->unique();
				$table->decimal('amount', 16, 2)->default(0);
				$table->string('method');
				$table->string('token')->nullable();
				$table->json('payloads')->nullable();
				$table->string('payment_type')->nullable();
				$table->string('va_number')->nullable();
				$table->string('vendor_name')->nullable();
				$table->string('biller_code')->nullable();
				$table->string('bill_key')->nullable();
				$table->softDeletes();
				$table->timestamps();
				
				$table->foreign('order_id')->references('id')->on('orders');
				$table->index('number');
				$table->index('method');
				$table->index('token');
				$table->index('payment_type');
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
		Schema::dropIfExists('payments');
	}
}
