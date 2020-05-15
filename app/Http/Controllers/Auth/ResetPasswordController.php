<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

/**
 * ResetPasswordController
 *
 * PHP version 7
 *
 * @category ResetPasswordController
 * @package  ResetPasswordController
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class ResetPasswordController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

	use ResetsPasswords;

	/**
	 * Where to redirect users after resetting their password.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';


	/**
	 * Show reset password form
	 *
	 * @param Request $request request object
	 * @param string  $token   reset password token
	 *
	 * @return void
	 */
	public function showResetForm(Request $request, $token = null)
	{
		if (is_null($token)) {
			return $this->getEmail();
		}

		$this->data['email'] = $request->input('email');
		$this->data['token'] = $token;
		
		return $this->loadTheme('auth.password.reset', $this->data);
	}
}
