<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Controller
 *
 * PHP version 7
 *
 * @category Controller
 * @package  Controller
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected $data = [];
	protected $uploadsFolder = 'uploads/';

	protected $rajaOngkirApiKey = null;
	protected $rajaOngkirBaseUrl = null;
	protected $rajaOngkirOrigin = null;
	protected $couriers = [
		'jne' => 'JNE',
		'pos' => 'POS Indonesia',
		'tiki' => 'Titipan Kilat'
	];

	protected $provinces = [];

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->rajaOngkirApiKey = env('RAJAONGKIR_API_KEY');
		$this->rajaOngkirBaseUrl = env('RAJAONGKIR_BASE_URL');
		$this->rajaOngkirOrigin = env('RAJAONGKIR_ORIGIN');

		$this->_initAdminMenu();
	}

	/**
	 * Initiate admin menu
	 *
	 * @return void
	 */
	private function _initAdminMenu()
	{
		$this->data['currentAdminMenu'] = 'dashboard';
		$this->data['currentAdminSubMenu'] = '';
	}

	/**
	 * Load view for particular theme
	 *
	 * @param string $view view path
	 * @param arry   $data data
	 *
	 * @return void
	 */
	protected function loadTheme($view, $data = [])
	{
		return view('themes/'. env('APP_THEME') .'/'. $view, $data);
	}

	/**
	 * Raja Ongkir Request (Shipping Cost Calculation)
	 *
	 * @param string $resource resource url
	 * @param array  $params   parameters
	 * @param string $method   request method
	 *
	 * @return json
	 */
	protected function rajaOngkirRequest($resource, $params = [], $method = 'GET')
	{
		$client = new \GuzzleHttp\Client();

		$headers = ['key' => $this->rajaOngkirApiKey];
		$requestParams = [
			'headers' => $headers,
		];

		$url = $this->rajaOngkirBaseUrl . $resource;
		if ($params && $method == 'POST') {
			$requestParams['form_params'] = $params;
		} else if ($params && $method == 'GET') {
			$query = is_array($params) ? '?'.http_build_query($params) : '';
			$url = $this->rajaOngkirBaseUrl . $resource . $query;
		}
		
		$response = $client->request($method, $url, $requestParams);

		return json_decode($response->getBody(), true);
	}

	/**
	 * Get provinces
	 *
	 * @return array
	 */
	protected function getProvinces()
	{
		$provinceFile = 'provinces.txt';
		$provinceFilePath = $this->uploadsFolder. 'files/' . $provinceFile;

		$isExistProvinceJson = \Storage::disk('local')->exists($provinceFilePath);

		if (!$isExistProvinceJson) {
			$response = $this->rajaOngkirRequest('province');
			\Storage::disk('local')->put($provinceFilePath, serialize($response['rajaongkir']['results']));
		}

		$province = unserialize(\Storage::get($provinceFilePath));

		$provinces = [];
		if (!empty($province)) {
			foreach ($province as $province) {
				$provinces[$province['province_id']] = strtoupper($province['province']);
			}
		}

		return $provinces;
	}

	/**
	 * Get cities by province ID
	 *
	 * @param int $provinceId province id
	 *
	 * @return array
	 */
	protected function getCities($provinceId)
	{
		$cityFile = 'cities_at_'. $provinceId .'.txt';
		$cityFilePath = $this->uploadsFolder. 'files/' .$cityFile;

		$isExistCitiesJson = \Storage::disk('local')->exists($cityFilePath);

		if (!$isExistCitiesJson) {
			$response = $this->rajaOngkirRequest('city', ['province' => $provinceId]);
			\Storage::disk('local')->put($cityFilePath, serialize($response['rajaongkir']['results']));
		}

		$cityList = unserialize(\Storage::get($cityFilePath));
		
		$cities = [];
		if (!empty($cityList)) {
			foreach ($cityList as $city) {
				$cities[$city['city_id']] = strtoupper($city['type'].' '.$city['city_name']);
			}
		}

		return $cities;
	}

	/**
	 * Initiate payment gateway request object
	 *
	 * @return void
	 */
	protected function initPaymentGateway()
	{
		// Set your Merchant Server Key
		\Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
		// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
		\Midtrans\Config::$isProduction = false;
		// Set sanitization on (default)
		\Midtrans\Config::$isSanitized = true;
		// Set 3DS transaction for credit card to true
		\Midtrans\Config::$is3ds = true;
	}
}
