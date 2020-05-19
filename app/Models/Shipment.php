<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Shipment
 *
 * PHP version 7
 *
 * @category Shipment
 * @package  Shipment
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Shipment extends Model
{
	public const PENDING = 'pending';
	public const SHIPPED = 'shipped';

	protected $fillable = [
		'user_id',
		'order_id',
		'track_number',
		'status',
		'total_qty',
		'total_weight',
		'first_name',
		'last_name',
		'address1',
		'address2',
		'phone',
		'email',
		'city_id',
		'province_id',
		'postcode',
		'shipped_by',
		'shipped_at',
	];

	/**
	 * Relationship to the order model
	 *
	 * @return void
	 */
	public function order()
	{
		return $this->belongsTo(\App\Models\Order::class);
	}
}
