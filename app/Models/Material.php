<?php

namespace App\Models;

use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $appends = ['selected'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }
    //
    public function products()
    {
        return $this->belongsToMany(Product::class,'material_to_product');
    }

    public function getSelectedAttribute()
    {
        return false;
    }

    /**
     * @param $value
     *
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    public function getNameAttribute($value)
    {
        return trans('materials.'.strtolower($this->alias));
    }
}
