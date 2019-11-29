<?php

    namespace App\Models\Users;

    use App\Models\Commission;
    use App\Models\DeliveryDetail;
    use App\Models\Notification;
    use App\Models\Order;
    use App\Models\Products\Poster;
    use App\Models\Products\Product;
    use App\Models\Purchase;
    use App\Models\Subscription;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\File;
    use Laravel\Passport\HasApiTokens;
    use Iatstuti\Database\Support\CascadeSoftDeletes;

    /**
     * Class User
     *
     * @package App\Models\Users
     */
    class User extends Authenticatable
    {
        use HasApiTokens, Notifiable, SoftDeletes, CascadeSoftDeletes;

        /**
         * @var array
         */
        protected $cascadeDeletes = ['products'];

        /**
         * @var string
         */
        protected $table = 'users';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name', 'surname', 'pseudonym', 'nickname', 'description', 'role', 'avatar', 'email',
            'password', 'country', 'city', 'street', 'house_number', 'apartment_number', 'phone', 'note', 'registered_from_url',
            'soc_vk', 'soc_google', 'soc_facebook', 'temp_email', 'no_password', 'about', 'user_id','contact_email','contact_phone'
        ];

        /* ----------------
         * role
         * ----------------
         * 0 - new
         * 1 - client
         * 2 - artist
         * 3 - gallery
         * 9 - admin
         *
         */

        /**
         * @var array
         */
        protected $appends = [
            'profile_url',
            'avatar_link',
            'full_name'
        ];

        /**
         * @var array
         */
        protected $dates = ['last_login_date'];

        /**
         *
         */
        protected static function boot()
        {
            parent::boot();

            static::addGlobalScope('order', function (Builder $builder) {
                $builder->orderBy('created_at', 'desc');
            });
        }

        /**
         * @return mixed
         */
        public function notifications()
        {
            return $this->hasMany(Notification::class);
        }

        /**
         * @return mixed
         */
        public function getProfileUrlAttribute()
        {
            return $this->profileURL();
        }

        /**
         * @return string
         */
        public function getAvatarLinkAttribute()
        {
            return $this->avatar ? '/web/images/avatars/' . $this->avatar : '/web/images/ui/icon-default-avatar.svg';
        }

        /**
         * @return mixed
         */
        public function deliveryDetails()
        {
            return $this->hasOne(DeliveryDetail::class);
        }

        /**
         * @return string
         */
        public function getFullNameAttribute()
        {
            if($this->pseudonym) {
                return $this->pseudonym;
            }
            return $this->name. ' ' .$this->surname;
        }

        /**
         * @return mixed
         */
        public function orders()
        {
            return $this->hasMany(Order::class,'buyer_id');
        }

        /**
         * Update User's last login date
         */
        public function touchLastLoginDate()
        {
            $this->last_login_date = Carbon::now();
            $this->save();
        }


        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password', 'remember_token',
        ];

        /**
         * @param $params
         * @return mixed
         */
        public function socialCheckExistUser($params)
        {
            if ($params['email'])
                return $this->where('email', $params['email'])->orWhere('soc_' . $params['social'], $params['social_id'])->first();
            else
                return $this->where('soc_' . $params['social'], $params['social_id'])->first();
        }

        /**
         * @return mixed
         */
        public function purchases()
        {
            return $this->hasMany(Purchase::class);
        }

        /**
         * @return mixed
         */
        public function posters()
        {
            return $this->hasMany(Poster::class, 'user_id');
        }

        /**
         * @return mixed
         */
        public function products()
        {
            return $this->hasMany(Product::class);
        }

        /**
         * @return mixed
         */
        public function items()
        {
            return $this->hasMany(Product::class);
        }

        /**
         * @param $toUser
         * @return int|null
         */
        public function subscribed($toUser)
        {
            $subscibed = Subscription::where('user_id', Auth::id())->where('subscription_id', $toUser)->first();
            if ($subscibed) {
                return 1;
            }
            return null;
        }

        /**
         * @return mixed
         */
        public function subscriptions()
        {
            return $this->hasMany('App\Models\Subscription', 'user_id', 'id');
        }

        /**
         * @return mixed
         */
        public function subscriptions_products()
        {
            return $this->manyThroughMany(Product::class, Subscription::class, 'subscription_id', 'id', 'user_id');
        }

        /**
         * @return mixed
         */
        public function subscribedToMe()
        {
            return $this->hasMany('App\Models\Subscription', 'subscription_id', 'id');
        }

        /**
         * @return mixed
         */
        public function authors()
        {
            return $this->hasMany('App\Models\Author', 'user_id', 'id');
        }

        /**
         * @return mixed
         */
        public function gallery_profile()
        {
            return $this->hasOne(\App\Models\Gallery::class,'user_id','id');
        }

        /**
         * @return int
         */
        public function isGalleryUser()
        {
            return $this->gallery_profile ? 1 : 0;
        }
        
        /**
         * @return mixed
         */
        public function profileURL()
        {
            return route('profile.page', $this->id);
        }

        /**
         * @return mixed
         */
        public function commissions()
        {
            return $this->hasMany(Commission::class, 'user_id');
        }

        /**
         * @return mixed
         */
        public function liked_products()
        {
            return $this->belongsToMany(Product::class, 'likes');
        }

        /**
         * @param null $avatar
         * @return null
         */
        public function storeAvatar($avatar = null)
        {
            if ($avatar) {
                $directory = "/web/images/avatars/";
                $this->avatar = $this->saveBase64File($avatar, $directory);
                $this->save();
            }
            return $avatar;
        }

        /**
         * Convert base64 code to JPEG image file
         *
         * @param $base64
         * @param $file
         * @return mixed
         */
        private function base64ToJpeg($base64, $file)
        {
            $ifp = fopen($file, "wb");
            $data = explode(',', $base64);
            fwrite($ifp, base64_decode($data[1]));
            fclose($ifp);
            return $file;
        }


        /**
         * Check exist path otherwise create this directory with 0777
         *
         * @param $path
         */
        public function checkExistPath($path)
        {
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true);
            }
        }

        /**
         * Save base64 image
         *
         * @param $base64
         * @param $directory
         * @return string filename
         */
        public function saveBase64File($base64, $directory)
        {
            $path = public_path() . $directory;
            $this->checkExistPath($path);
            $filename = md5(time() . uniqid()) . ".jpg";
            $filePath = $path . $filename;
            $this->base64ToJpeg($base64, $filePath);
            return $filename;

        }

        /**
         * @param $related
         * @param $through
         * @param $firstKey
         * @param $secondKey
         * @param $pivotKey
         * @return mixed
         */
        public function manyThroughMany($related, $through, $firstKey, $secondKey, $pivotKey)
        {
            $model = new $related;
            $table = $model->getTable();
            $throughModel = new $through;
            $pivot = $throughModel->getTable();

            return $model
                ->join('subscriptions', 'subscriptions' . '.' . 'subscription_id', '=', 'products' . '.' . 'user_id')
                ->select('products' . '.*')
                ->where('subscriptions' . '.' . 'user_id', '=', $this->id);
        }

        /**
         * Get viewed/approved authors
         *
         * @param \Illuminate\Database\Eloquent\Builder $query
         *
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function scopeViewed(Builder $query)
        {
            return $query->where('viewed', 1);
        }

        /**
         * Get viewed/approved authors
         * Alias for viewed scope
         *
         * @param \Illuminate\Database\Eloquent\Builder $query
         *
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function scopeApproved(Builder $query)
        {
            return $query->where('viewed', 1);
        }

        /**
         * Generate meta tags for user
         * @return array
         */
        public function getMetatagsAttribute()
        {
            $metatags = [
                'url' => $this->getProfileUrlAttribute(),
                'type' => 'website',
                'title' => '�����: '.$this->getFullNameAttribute(),
                'description' => 'ArtDealer. ��������� ��� ������� � ������� ������������ ���������.',
                'image' => $this->getAvatarLinkAttribute(),
            ];

            return $metatags;
        }
    }
