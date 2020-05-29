<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Order;
use App\Models\Slide;

/**
 * HomeController
 *
 * PHP version 7
 *
 * @category HomeController
 * @package  HomeController
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index()
	{
		$products = Product::popular()->get();
		$this->data['products'] = $products;

		$slides = Slide::active()->orderBy('position', 'ASC')->get();
		$this->data['slides'] = $slides;

		return $this->loadTheme('home', $this->data);
	}
}
