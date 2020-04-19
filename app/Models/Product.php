<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'parent_id',
        'user_id',
        'sku',
        'type',
        'name',
        'slug',
        'price',
        'weight',
        'length',
        'width',
        'height',
        'short_description',
        'description',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function productInventory()
    {
        return $this->hasOne('App\Models\ProductInventory');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'product_categories');
    }

    public function variants()
    {
        return $this->hasMany('App\Models\Product', 'parent_id')->orderBy('price', 'ASC');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Product', 'parent_id');
    }

    public function productAttributeValues()
    {
        return $this->hasMany('App\Models\ProductAttributeValue');
    }

    public function productImages()
    {
        return $this->hasMany('App\Models\ProductImage')->orderBy('id', 'DESC');
    }

    public static function statuses()
    {
        return [
            0 => 'draft',
            1 => 'active',
            2 => 'inactive',
        ];
    }

    function status_label()
    {
        $statuses = $this->statuses();

       return isset($this->status) ? $statuses[$this->status] : null;
    }

    public static function types()
    {
        return [
            'simple' => 'Simple',
            'configurable' => 'Configurable',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1)
                ->where('parent_id', NULL)
                ->orderBy('created_at', 'DESC');
    }

    function price_label()
    {
        return ($this->variants->count() > 0) ? $this->variants->first()->price : $this->price;
    }
}
