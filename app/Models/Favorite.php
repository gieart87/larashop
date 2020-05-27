<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
	protected $guarded = [
		'id',
		'created_at',
		'updated_at',
	];

	/**
	 * Define relationship with the Product
	 *
	 * @return void
	 */
	public function product()
	{
		return $this->belongsTo('App\Models\Product');
	}
}
