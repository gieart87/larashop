<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * SendMailOrderShipped
 *
 * PHP version 7
 *
 * @category SendMailOrderShipped
 * @package  SendMailOrderShipped
 * @author   Sugiarto <sugiarto.dlingo@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class SendMailOrderShipped implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $order;
	/**
	 * Create a new job instance.
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
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$orderShippedEmail = new \App\Mail\OrderShipped($this->order);
		return \Mail::to($this->order->customer_email)->send($orderShippedEmail);
	}
}
