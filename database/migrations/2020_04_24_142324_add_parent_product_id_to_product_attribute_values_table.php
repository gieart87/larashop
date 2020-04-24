<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentProductIdToProductAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_attribute_values', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_product_id')->after('id')->nullable();

			$table->foreign('parent_product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_attribute_values', function (Blueprint $table) {
            $table->dropForeign('product_attribute_values_parent_product_id_foreign');
			$table->dropColumn('parent_product_id');
        });
    }
}
