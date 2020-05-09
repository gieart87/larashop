<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * OrderItem
 *
 * PHP version 7
 *
 * @category OrderItem
 * @package  OrderItem
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class OrderItem extends Model
{
	protected $fillable = [
		'order_id',
		'product_id',
		'qty',
		'base_price',
		'base_total',
		'tax_amount',
		'tax_percent',
		'discount_amount',
		'discount_percent',
		'sub_total',
		'sku',
		'type',
		'name',
		'weight',
		'attributes',
	];

	/**
	 * Define relationship with the Product
	 *
	 * @return void
	 */
	public function product()
	{
		return $this->belongsTo('App\Models\Product');
	}
}
