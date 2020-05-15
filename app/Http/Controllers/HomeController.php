<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
		return $this->loadTheme('home');
	}
}
