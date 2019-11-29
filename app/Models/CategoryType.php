<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CategoryType extends Model
{
    protected $table = 'category_types';

    protected $appends = [
        'selected',
        'name',
    ];


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }
    
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public static function pluckNames($type = null)
    {
        if(!$type) {
            return self::select('id as value', 'name as name', 'alias')->get();
        }

        return self::select('id as value', 'name as name', 'alias')->whereType($type)->get();
    }

    /**
     * @param $value
     *
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    public function getNameAttribute($value)
    {
        return trans('category_types.names.'.$this->alias);
    }
    
    public function getSelectedAttribute()
    {
        return false;
    }
}
