<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

/**
 * VerifyCsrfToken
 *
 * PHP version 7
 *
 * @category VerifyCsrfToken
 * @package  VerifyCsrfToken
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class VerifyCsrfToken extends Middleware
{
	/**
	 * Indicates whether the XSRF-TOKEN cookie should be set on the response.
	 *
	 * @var bool
	 */
	protected $addHttpCookie = true;

	/**
	 * The URIs that should be excluded from CSRF verification.
	 *
	 * @var array
	 */
	protected $except = [
		'payments/notification'
	];
}
