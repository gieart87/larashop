<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ProductInventory
 *
 * PHP version 7
 *
 * @category ProductInventory
 * @package  ProductInventory
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class ProductInventory extends Model
{
	protected $fillable = [
		'product_id',
		'qty',
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

	/**
	 * Reduce stock product
	 *
	 * @param int $productId product ID
	 * @param int $qty       qty product
	 *
	 * @return void
	 */
	public static function reduceStock($productId, $qty)
	{
		$inventory = self::where('product_id', $productId)->firstOrFail();

		if ($inventory->qty < $qty) {
			$product = Product::findOrFail($productId);
			throw new \App\Exceptions\OutOfStockException('The product '. $product->sku .' is out of stock');
		}

		$inventory->qty = $inventory->qty - $qty;
		$inventory->save();
	}

	/**
	 * Increase stock product
	 *
	 * @param int $productId product ID
	 * @param int $qty       qty product
	 *
	 * @return void
	 */
	public static function increaseStock($productId, $qty)
	{
		$inventory = self::where('product_id', $productId)->firstOrFail();
		$inventory->qty = $inventory->qty + $qty;
		$inventory->save();
	}
}
