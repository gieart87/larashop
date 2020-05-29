<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
	protected $guarded = [
		'id',
		'created_at',
		'updated_at',
	];

	public const UPLOAD_DIR = 'uploads';

	public const ACTIVE = 'active';
	public const INACTIVE = 'inactive';

	public const STATUSES = [
		self::ACTIVE => 'Active',
		self::INACTIVE => 'Inactive',
	];

	public const EXTRA_LARGE = '1920x643';
	public const SMALL = '135x75';

	/**
	 * Scope active product
	 *
	 * @param Eloquent $query query builder
	 *
	 * @return Eloquent
	 */
	public function scopeActive($query)
	{
		return $query->where('status', self::ACTIVE);
	}
	
	/**
	 * Get previous slide
	 *
	 * @return Eloquent
	 */
	public function prevSlide()
	{
		return self::where('position', '<', $this->position)
			->orderBy('position', 'DESC')
			->first();
	}

	/**
	 * Get next slide
	 *
	 * @return Eloquent
	 */
	public function nextSlide()
	{
		return self::where('position', '>', $this->position)
			->orderBy('position', 'ASC')
			->first();
	}
}
