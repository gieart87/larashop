<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreateShipmentsTable
 *
 * PHP version 7
 *
 * @category CreateShipmentsTable
 * @package  CreateShipmentsTable
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class CreateShipmentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(
			'shipments',
			function (Blueprint $table) {
				$table->bigIncrements('id');
				$table->unsignedBigInteger('user_id');
				$table->unsignedBigInteger('order_id');
				$table->string('track_number')->nullable();
				$table->string('status');
				$table->integer('total_qty');
				$table->integer('total_weight');
				$table->string('first_name');
				$table->string('last_name');
				$table->string('address1')->nullable();
				$table->string('address2')->nullable();
				$table->string('phone')->nullable();
				$table->string('email')->nullable();
				$table->string('city_id')->nullable();
				$table->string('province_id')->nullable();
				$table->integer('postcode')->nullable();
				$table->unsignedBigInteger('shipped_by')->nullable();
				$table->datetime('shipped_at')->nullable();
				$table->softDeletes();
				$table->timestamps();

				$table->foreign('user_id')->references('id')->on('users');
				$table->foreign('order_id')->references('id')->on('orders');
				$table->foreign('shipped_by')->references('id')->on('users');
				$table->index('track_number');
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
		Schema::dropIfExists('shipments');
	}
}
