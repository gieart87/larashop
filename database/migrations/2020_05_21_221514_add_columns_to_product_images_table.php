<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProductImagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table(
			'product_images',
			function (Blueprint $table) {
				$table->string('extra_large')->nullable()->after('path');
				$table->string('large')->nullable()->after('extra_large');
				$table->string('medium')->nullable()->after('large');
				$table->string('small')->nullable()->after('medium');
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
			'product_images',
			function (Blueprint $table) {
				$table->dropColumn('extra_large');
				$table->dropColumn('large');
				$table->dropColumn('medium');
				$table->dropColumn('small');
			}
		);
	}
}
