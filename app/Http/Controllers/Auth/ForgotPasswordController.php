<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

/**
 * ForgotPasswordController
 *
 * PHP version 7
 *
 * @category ForgotPasswordController
 * @package  ForgotPasswordController
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class ForgotPasswordController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset emails and
	| includes a trait which assists in sending these notifications from
	| your application to your users. Feel free to explore this trait.
	|
	*/

	use SendsPasswordResetEmails;

	/**
	 * Show forgot password reset request form
	 *
	 * @return void
	 */
	public function showLinkRequestForm()
	{
		if (property_exists($this, 'linkRequestView')) {
			return view($this->linkRequestView);
		}
		return $this->loadTheme('auth.password.email');
	}
}
