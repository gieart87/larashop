<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * OrderReceived
 *
 * PHP version 7
 *
 * @category OrderReceived
 * @package  OrderReceived
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class OrderReceived extends Mailable
{
	use Queueable, SerializesModels;

	public $order;
	/**
	 * Create a new message instance.
	 *
	 * @param Order $order order object
	 *
	 * @return void
	 */
	public function __construct($order)
	{
		$this->order = $order;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->markdown('emails.orders.received');
	}
}
