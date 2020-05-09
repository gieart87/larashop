<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * OrderRequest
 *
 * PHP version 7
 *
 * @category OrderRequest
 * @package  OrderRequest
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class OrderRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'first_name' => 'required|string',
			'last_name' => 'required|string',
			'company' => '',
			'address1' => 'required|string',
			'address2' => '',
			'province_id' => 'required|numeric',
			'city_id' => 'required|numeric',
			'postcode' => 'required|numeric',
			'phone' => 'required',
			'shipping_service' => 'required|string',
		];

		$shipTo = $this->get('ship_to');

		if ($shipTo) {
			$rules = array_merge(
				$rules,
				[
					'shipping_first_name' => 'required|string',
					'shipping_last_name' => 'required|string',
					'shipping_company' => '',
					'shipping_address1' => 'required|string',
					'shipping_address2' => '',
					'shipping_province_id' => 'required|numeric',
					'shipping_city_id' => 'required|numeric',
					'shipping_postcode' => 'required|numeric',
					'shipping_phone' => 'required',
					'shipping_email' => 'email'
				]
			);
		}

		return $rules;
	}
}
