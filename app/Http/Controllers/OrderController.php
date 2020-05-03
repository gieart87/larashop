<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	public function checkout()
	{
		if (\Cart::isEmpty()) {
			return redirect('carts');
		}

		\Cart::removeConditionsByType('shipping');
		$this->updateTax();

		$items = \Cart::getContent();
		$this->data['items'] = $items;
		$this->data['totalWeight'] = $this->getTotalWeight() / 1000;

		$this->data['provinces'] = $this->getProvinces();
		$this->data['cities'] = isset(\Auth::user()->province_id) ? $this->getCities(\Auth::user()->province_id) : [];
		$this->data['user'] = \Auth::user();



		return $this->load_theme('orders.checkout', $this->data);
	}

	public function cities(Request $request)
	{
		$cities = $this->getCities($request->query('province_id'));
		return response()->json(['cities' => $cities]);
	}

	public function shippingCost(Request $request)
	{
		$destination = $request->input('city_id');
		
		return $this->getShippingCost($destination, $this->getTotalWeight());
	}

	public function setShipping(Request $request)
	{
		\Cart::removeConditionsByType('shipping');

		$shippingService = $request->get('shipping_service');
		$destination = $request->get('city_id');

		$shippingOptions = $this->getShippingCost($destination, $this->getTotalWeight());

		$selectedShipping = null;
		if ($shippingOptions['results']) {
			foreach ($shippingOptions['results'] as $shippingOption) {
				if (str_replace(' ', '', $shippingOption['service']) == $shippingService) {
					$selectedShipping = $shippingOption;
					break;
				}
			}
		}

		$status = null;
		$message = null;
		$data = [];
		if ($selectedShipping) {
			$status = 200;
			$message = 'Success set shipping cost';

			$this->addShippingCostToCart($selectedShipping['service'], $selectedShipping['cost']);

			$data['total'] = number_format(\Cart::getTotal());

		} else {
			$status = 400;
			$message = 'Failed to set shipping cost';
		} 

		$response = [
			'status' => $status,
			'message' => $message
		];

		if ($data) {
			$response['data'] = $data;
		}

		return $response;
	}

	private function addShippingCostToCart($serviceName, $cost)
	{
		$condition = new \Darryldecode\Cart\CartCondition(array(
			'name' => $serviceName,
			'type' => 'shipping',
			'target' => 'total',
			'value' => '+'. $cost,
		));

		\Cart::condition($condition);
	}

	private function getShippingCost($destination, $weight)
	{
		$params = [
			'origin' => env('RAJAONGKIR_ORIGIN'),
			'destination' => $destination,
			'weight' => $weight,
		];

		$results = [];
		foreach ($this->couriers as $code => $courier) {
			$params['courier'] = $code;
			
			$response = $this->rajaOngkirRequest('cost', $params, 'POST');
			
			if (!empty($response['rajaongkir']['results'])) {
				foreach ($response['rajaongkir']['results'] as $cost) {
					if (!empty($cost['costs'])) {
						foreach ($cost['costs'] as $costDetail) {
							$serviceName = strtoupper($cost['code']) .' - '. $costDetail['service'];
							$costAmount = $costDetail['cost'][0]['value'];
							$etd = $costDetail['cost'][0]['etd'];

							$result = [
								'service' => $serviceName,
								'cost' => $costAmount,
								'etd' => $etd,
							];

							$results[] = $result;
						}
					}
				}
			}
		}

		$response = [
			'origin' => $params['origin'],
			'destination' => $destination,
			'weight' => $weight,
			'results' => $results,
		];
		
		return $response;
	}

	private function getTotalWeight()
	{
		if (\Cart::isEmpty()) {
			return 0;
		}

		$totalWeight = 0;
		$items = \Cart::getContent();

		foreach ($items as $item) {
			$totalWeight += ($item->quantity * $item->associatedModel->weight);
		}

		return $totalWeight;
	}

	private function updateTax()
	{
		\Cart::removeConditionsByType('tax');

		$condition = new \Darryldecode\Cart\CartCondition(array(
			'name' => 'TAX 10%',
			'type' => 'tax',
			'target' => 'total',
			'value' => '10%',
		));

		\Cart::condition($condition);
	}
}
