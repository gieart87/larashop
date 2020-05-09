<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreateOrderItemsTable
 *
 * PHP version 7
 *
 * @category CreateOrderItemsTable
 * @package  CreateOrderItemsTable
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class CreateOrderItemsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(
			'order_items',
			function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->unsignedBigInteger('order_id');
				$table->unsignedBigInteger('product_id');
				$table->integer('qty');
				$table->decimal('base_price', 16, 2)->default(0);
				$table->decimal('base_total', 16, 2)->default(0);
				$table->decimal('tax_amount', 16, 2)->default(0);
				$table->decimal('tax_percent', 16, 2)->default(0);
				$table->decimal('discount_amount', 16, 2)->default(0);
				$table->decimal('discount_percent', 16, 2)->default(0);
				$table->decimal('sub_total', 16, 2)->default(0);
				$table->string('sku');
				$table->string('type');
				$table->string('name');
				$table->string('weight');
				$table->json('attributes');
				$table->timestamps();

				$table->foreign('order_id')->references('id')->on('orders');
				$table->foreign('product_id')->references('id')->on('products');
				$table->index('sku');
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
		Schema::dropIfExists('order_items');
	}
}
