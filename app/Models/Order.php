<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Order
 *
 * PHP version 7
 *
 * @category Order
 * @package  Order
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Order extends Model
{
	protected $fillable = [
		'user_id',
		'code',
		'status',
		'order_date',
		'payment_due',
		'payment_status',
		'base_total_price',
		'tax_amount',
		'tax_percent',
		'discount_amount',
		'discount_percent',
		'shipping_cost',
		'grand_total',
		'note',
		'customer_first_name',
		'customer_last_name',
		'customer_address1',
		'customer_address2',
		'customer_phone',
		'customer_email',
		'customer_city_id',
		'customer_province_id',
		'customer_postcode',
		'shipping_courier',
		'shipping_service_name',
		'approved_by',
		'approved_at',
		'cancelled_by',
		'cancelled_at',
		'cancellation_note',
	];
	
	public const CREATED = 'created';
	public const CONFIRMED = 'confirmed';
	public const DELIVERED = 'delivered';
	public const COMPLETED = 'completed';
	public const CANCELLED = 'cancelled';

	public const ORDERCODE = 'INV';

	public const PAID = 'paid';
	public const UNPAID = 'unpaid';

	/**
	 * Define relationship with the Shipment
	 *
	 * @return void
	 */
	public function shipment()
	{
		return $this->hasOne('App\Models\Shipment');
	}

	/**
	 * Define relationship with the OrderItem
	 *
	 * @return void
	 */
	public function orderItems()
	{
		return $this->hasMany('App\Models\OrderItem');
	}

	/**
	 * Define relationship with the User
	 *
	 * @return void
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	/**
	 * Generate order code
	 *
	 * @return string
	 */
	public static function generateCode()
	{
		$dateCode = self::ORDERCODE . '/' . date('Ymd') . '/' .\General::integerToRoman(date('m')). '/' .\General::integerToRoman(date('d')). '/';

		$lastOrder = self::select([\DB::raw('MAX(orders.code) AS last_code')])
			->where('code', 'like', $dateCode . '%')
			->first();

		$lastOrderCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;
		
		$orderCode = $dateCode . '00001';
		if ($lastOrderCode) {
			$lastOrderNumber = str_replace($dateCode, '', $lastOrderCode);
			$nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);
			
			$orderCode = $dateCode . $nextOrderNumber;
		}

		if (self::_isOrderCodeExists($orderCode)) {
			return generateOrderCode();
		}

		return $orderCode;
	}

	/**
	 * Check if the generated order code is exists
	 *
	 * @param string $orderCode order code
	 *
	 * @return void
	 */
	private static function _isOrderCodeExists($orderCode)
	{
		return Order::where('code', '=', $orderCode)->exists();
	}
}
