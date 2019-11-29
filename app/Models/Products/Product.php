<?php

    namespace App\Models\Products;

    use App\Models\Color;
    use App\Models\Like;
    use App\Models\Settings;
    use App\Models\Users\User;
    use App\Observers\ProductObserver;
    use App\Traits\IsActive;
    use App\Traits\Models\HasAttachmentsTrait;
    use App\Traits\Models\HasCategoriesTrait;
    use App\Traits\Models\HasImageTrait;
    use App\Traits\Models\HasMaterialsTrait;
    use App\Traits\Models\HasTagsTrait;
    use Auth;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\URL;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Iatstuti\Database\Support\CascadeSoftDeletes;

    class Product extends Model
    {
        use HasTagsTrait, HasCategoriesTrait, HasImageTrait, SoftDeletes, HasMaterialsTrait, HasAttachmentsTrait, IsActive;

        /**
         * Product Statuses
         *
         */
        const STATUSES = [
            1 => 'moderation',
            2 => 'rejected',
            3 => 'profile_visible',
            4 => 'store_visible',
            5 => 'top_rated',
        ];

        /**
         * Product Types
         *
         * @var array
         */
        protected $types = [
            1 => 'Print',
            2 => 'Painting',
            3 => 'Design',
        ];

        /**
         * Product Aliases
         *
         * @var array
         */
        protected $aliases = [
            1 => 'poster',
            2 => 'picture',
            3 => 'thing',
        ];

        /**
         * Database Table
         *
         * @var string
         */
        protected $table = 'products';

        /**
         * Fillables
         *
         * @var array
         */
        protected $fillable = [
            'user_id',
            'name',
            'image_preview',
            'image_source',
            'price',
            'width',
            'height',
            'year',
            'description',
            'for_sale',
            'sold',
            'type',
            'depth',
            'weight',
            'status_id'
        ];

        /**
         * Appendables
         *
         * @var array
         */
        protected $appends = [
            'isLikedByAuthUser',
            'image_preview_xs',
            'image_preview_s',
            'image_preview_m',
            'image_preview_original',
            'type_name',
            'alias_name',
            'url',
            'facebookShareUrl',
            'print_price',
            'final_price',
            'delivery_price',
            'packing_price',
            'author_commission',
            'platform_commission',
            'prices',
            'type_class_colour',
            'status'
        ];

        /**
         * Default With Relations
         *
         * @var array
         */
        protected $with = [
            'author',
            'colors',
            'tags',
            'materials',
            'attachments',
            'categories',
        ];

        /**
         * Bootstrap
         *
         */
        protected static function boot()
        {
            parent::boot();

            self::observe(ProductObserver::class);

            static::addGlobalScope('order', function (Builder $builder) {
                $builder->orderBy('for_sale', 'DESC')->orderBy('created_at', 'desc');
            });
        }

        /**
         *  Morph Many Likes
         * Get all of the posters likes.
         */
        public function likes()
        {
            return $this->morphMany('App\Models\Like', 'likable');
        }

        /**
         *  Has One Author
         *
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function author()
        {
            return $this->hasOne(User::class, 'id', 'user_id');
        }

        /**
         * Has Many Colors
         *
         * @return $this
         */
        public function colors()
        {
            return $this->hasMany(Color::class, 'item_id', 'id')->where('item_type', 'poster');
        }

        /**
         * @return bool
         */
        public function getIsLikedByAuthUserAttribute()
        {
            if (Auth::check() && $this->id) {
                return Like::findLiked(Auth::id(), 'poster', $this->id) ? true : false;
            }
        }

        /**
         * Translation of attribute type
         *
         * @return array|\Illuminate\Contracts\Translation\Translator|null|string
         */
        public function getTypeNameAttribute()
        {
            return trans('homepage.' . $this->types[$this->type]);
        }

        /**
         * @return mixed
         */
        public function getAliasNameAttribute()
        {
            return $this->aliases[$this->type];
        }

        /**
         * @param $value
         */
        public function setUserIdAttribute($value)
        {
            if (!$value) {
                $this->attributes['user_id'] = \Illuminate\Support\Facades\Auth::id();
            } else {
                $this->attributes['user_id'] = $value;
            }
        }

        /**
         * Can be viewed in profile Scope
         *
         * @param $query
         * @return mixed
         */
        public function scopeAvailableForProfile($query)
        {
            return $query->where('status_id', '>=', 3);
        }

        /**
         * Can be viewed in catalog Scope
         *
         * @param $query
         * @return mixed
         */
        public function scopeAvailableForCatalog($query)
        {
            return $query->where('status_id', '>=', 4)->whereForSale(1)->whereSold(0);
        }

        /**
         * Can Be Viewed in Top Scope
         *
         * @param $query
         * @return mixed
         */
        public function scopeAvailableForTop($query)
        {
            return $query->where('status_id', '>=', 5)->whereForSale(1)->whereSold(0);
        }

        public function scopeLandscape($query)
        {
            return $query->whereRaw('height < width');
        }

        public function scopePortrait($query)
        {
            return $query->whereRaw('height > width');
        }

        public function scopeSquare($query)
        {
            return $query->whereRaw('height = width');
        }


        /**
         * Get Prices
         *
         * @return object
         */
        public function getPricesAttribute()
        {
            return $this->getPrices();
        }

        /**
         * Get Prices Summary
         *
         * @return object
         */
        public function getPrices()
        {
            $prices = [
                'print'    => $this->getPrintPriceAttribute(),
                'delivery' => $this->getDeliveryPriceAttribute(),
                'packing'  => $this->getPackingPriceAttribute(),
                'platform' => $this->getPlatformCommissionAttribute(),
                'author'   => $this->getAuthorCommissionAttribute(),
                'final'    => $this->getFinalPriceAttribute(),
            ];

            // AuthorPrice + 20% + PrintPrice (Includes20%) + DeliveryPrice + PackagePrice
            $prices['total'] = $prices['final'] + $prices['delivery'] + $prices['packing'];

            $prices['platform_with_print'] = (int)($prices['platform'] + $prices['print'] % 20);

            $prices['print_without_platform'] = (int)($prices['print'] - $prices['print'] % 20);

            return (object)$prices;
        }

        /**
         * Print Price
         *
         * @return int
         */
        public function getPrintPriceAttribute()
        {
            $craftPrice = ($this->width + 50) * ($this->height + 50) / 1000000 * 25;
            $backGroundPrice = (($this->width + 50) + ($this->height + 50)) * 2 / 1000;

            return (int)($craftPrice + $backGroundPrice + 1);
        }

        /**
         * Delivery Price
         *
         * @return mixed
         */
        public function getDeliveryPriceAttribute()
        {
            if ($this->width < 1000 && $this->height < 1000) {
                return Settings::whereName('delivery_per_print_unit_price_small')->first()->value;
            } else {
                return Settings::whereName('delivery_per_print_unit_price_big')->first()->value;
            }
        }

        /**
         * Packaging price
         *
         * @return mixed
         */
        public function getPackingPriceAttribute()
        {
            if ($this->width < 1000 && $this->height < 1000) {
                return Settings::whereName('package_per_print_unit_price_small')->first()->value;
            } else {
                return Settings::whereName('package_per_print_unit_price_big')->first()->value;
            }
        }

        /**
         * Get Text Status
         *
         * @param $value
         * @return string
         */
        public function getStatusAttribute(): string
        {
            return self::STATUSES[$this->status_id] ?? 'moderation';
        }

        /**
         * Final (clients) Price
         *
         * @return int
         */
        public function getFinalPriceAttribute()
        {
            if ($this->type !== 1) {
                return $this->price;
            }

            $priceWithComission = ($this->price + $this->price * Settings::whereName('revenue')->first()->value / 100);

            $finalPrice = (int)($priceWithComission + $this->print_price);

            return $finalPrice;
        }

        /**
         * Author Commission
         *
         * @return mixed
         */
        public function getAuthorCommissionAttribute()
        {
            //     return (int)($this->price * Settings::whereName('revenue')->first()->value / 100);
            return $this->price;
        }

        /**
         * Platform Commission
         *
         * @return int
         */
        public function getPlatformCommissionAttribute()
        {
            if ($this->type === 1) {
                return (int)($this->price * Settings::whereName('revenue')->first()->value / 100);
            } else {
                return (int)($this->price * Settings::whereName('commission')->first()->value / 100);
            }
        }

        /**
         * Product page URL
         *
         * @return mixed
         */
        public function getUrlAttribute()
        {
            return route('product.show', $this->id);
        }

        /**
         * Color for each Product type
         *
         * @return string
         */
        public function getTypeClassColourAttribute()
        {
            switch ($this->type) {
                case 3:
                    return 'blue';
                case 2:
                    return 'green';
                case 1:
                default:
                    return 'red';
            }
        }

        /**
         * Facebook Share Link
         *
         * @return string
         */
        public function getFacebookShareUrlAttribute()
        {
            return 'https://www.facebook.com/sharer/sharer.php?u=' . $this->url;
        }

        /**
         * @return array
         */
        public function getMetatagsAttribute()
        {
            $metatags = [
                'url'         => $this->url,
                'type'        => 'website',
                'title'       => $this->name,
                'description' => $this->description,
                'image'       => URL::to($this->image_preview_m),
            ];

            return $metatags;
        }

        /**
         * @param $request
         */
        public function fillAndStore(Request $request)
        {
            if (!$request->user_id) {
                $this->user_id = Auth::id();
            }

            $this->fill($request->all());

            $this->status_id = 1;

            $this->save();

            $this->fillTags($request->tags);
            $this->fillCategories($request->categories);

            if ($this->type !== 1) {
                $this->fillMaterials($request->materials);
                $this->fillAttachments($request->attachments);
            }
            $this->processColors();
        }
    }
