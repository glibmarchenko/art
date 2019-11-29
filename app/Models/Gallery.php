<?php

    namespace App\Models;

    use App\Models\Products\Product;
    use App\Models\Users\User;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Iatstuti\Database\Support\CascadeSoftDeletes;

    class Gallery extends Model
    {
        use SoftDeletes, CascadeSoftDeletes;

        protected $cascadeDeletes = ['authors'];

        public $types = ['Галерея','Дизайн студия','Онлайн галерея','Арт менеджер',];

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'user_id',
            'name',
            'description',
            'phones',
            'web',
            'gallery_owner_phone',
            'gallery_owner_name',
            'facebook',
            'instagram',
            'vk',
            'google',
            'country',
            'city',
            'street',
            'type',
            'house'
        ];

        protected $appends = ['avatar_link','address', 'full_address','avatar','type_name'];

        protected static function boot()
        {
            parent::boot();

            static::addGlobalScope('order', function (Builder $builder) {
                $builder->orderBy('created_at', 'desc');
            });
        }

        public function owner()
        {
            return $this->belongsTo(User::class,'user_id','id');

        }

        public function items()
        {
            return $this->hasManyThrough(Product::class, User::class);
        }

        public function phonesList()
        {
            return explode(',', $this->phones);
        }

        public function authors()
        {
           return $this->hasMany(User::class);
        }

        public function getAddressAttribute()
        {
            $address = '';
            if ($this->country) $address = $this->country;
          //  if ($this->city) $address = $address.', '.$this->city;
            return $address;
        }

        public function getFullAddressAttribute()
        {
            $address = '';

            if ($this->city) $address = $this->city;
            if ($this->street) $address = $address.', '.$this->street;
            if ($this->street) $address = $address.', '.$this->house;
            return $address;
        }


        public function getAvatarAttribute()
        {
            return $this->owner->avatar;
        }

        public function getTypeNameAttribute()
        {
            return $this->types[$this->type-1];
        }

        public function getAvatarLinkAttribute()
        {
            return $this->avatar ? '/web/images/avatars/' . $this->avatar : '/web/images/ui/icon-default-avatar.svg';
        }

        /**
         * Get viewed/approved galleries
         *
         * @param \Illuminate\Database\Eloquent\Builder $query
         *
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function scopeViewed(Builder $query)
        {
            return $query->where('viewed', 1)->whereIsActive(1);
        }

        /**
         * Get viewed/approved galleries
         * Alias for viewed scope
         *
         * @param \Illuminate\Database\Eloquent\Builder $query
         *
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function scopeApproved(Builder $query)
        {
            return $this->scopeViewed($query);
        }


    }
