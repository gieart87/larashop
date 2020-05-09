<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreateOrdersTable
 *
 * PHP version 7
 *
 * @category CreateOrdersTable
 * @package  CreateOrdersTable
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class CreateOrdersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(
			'orders',
			function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->unsignedBigInteger('user_id');
				$table->string('code')->unique();
				$table->string('status');
				$table->datetime('order_date');
				$table->datetime('payment_due');
				$table->string('payment_status');
				$table->decimal('base_total_price', 16, 2)->default(0);
				$table->decimal('tax_amount', 16, 2)->default(0);
				$table->decimal('tax_percent', 16, 2)->default(0);
				$table->decimal('discount_amount', 16, 2)->default(0);
				$table->decimal('discount_percent', 16, 2)->default(0);
				$table->decimal('shipping_cost', 16, 2)->default(0);
				$table->decimal('grand_total', 16, 2)->default(0);
				$table->text('note')->nullable();
				$table->string('customer_first_name');
				$table->string('customer_last_name');
				$table->string('customer_address1')->nullable();
				$table->string('customer_address2')->nullable();
				$table->string('customer_phone')->nullable();
				$table->string('customer_email')->nullable();
				$table->string('customer_city_id')->nullable();
				$table->string('customer_province_id')->nullable();
				$table->integer('customer_postcode')->nullable();
				$table->string('shipping_courier')->nullable();
				$table->string('shipping_service_name')->nullable();
				$table->unsignedBigInteger('approved_by')->nullable();
				$table->datetime('approved_at')->nullable();
				$table->unsignedBigInteger('cancelled_by')->nullable();
				$table->datetime('cancelled_at')->nullable();
				$table->text('cancellation_note')->nullable();
				$table->softDeletes();
				$table->timestamps();

				$table->foreign('user_id')->references('id')->on('users');
				$table->foreign('approved_by')->references('id')->on('users');
				$table->foreign('cancelled_by')->references('id')->on('users');
				$table->index('code');
				$table->index(['code', 'order_date']);
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
		Schema::dropIfExists('orders');
	}
}
