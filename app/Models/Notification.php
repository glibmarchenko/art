<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Builder;

    class Notification extends Model
    {
        protected $fillable = ['text', 'user_id'];

        protected $appends = ['datetime'];

        public function getDatetimeAttribute()
        {
            return $this->created_at->format('d-m-Y в H:i');

        }

        protected static function boot()
        {
            parent::boot();
            static::addGlobalScope('order', function (Builder $builder) {
                $builder->orderBy('created_at', 'desc');
            });
        }

    }
