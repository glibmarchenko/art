<?php

    namespace App\Models;

    use App\Lib\LiqPay;
    use App\Models\Products\Product;
    use App\Models\Users\User;
    use App\Services\OrderStatus\NonPrintStatusService;
    use App\Services\OrderStatus\PrintStatusService;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Concerns\HasEvents;
    use Illuminate\Support\Facades\Mail;

    class Order extends Model
    {
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $guarded = [];

        /**
         * @var array
         */
        protected $appends = ['total_amount'];

        /**
         * @var array
         */
        protected $attributes = ['delivery_house' => ' '];

        /**
         * @var array
         */
        protected $observables = [
            'paid',
            'produced',
            'reserved',
            'packed',
            'shipped',
            'completed',
        ];

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
        public function products()
        {
            return $this->belongsToMany(Product::class, 'purchases', 'order_id', 'product_id');
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
        public function buyer()
        {
            return $this->belongsTo(User::class, 'buyer_id')->with('deliveryDetails');
        }

        /**
         * @return mixed
         */
        public function getTotalAmountAttribute()
        {
            return $this->products_amount + $this->delivery_amount + $this->package_amount;
        }

        /**
         * Has One Commission
         *
         * @return mixed
         */
        public function commission()
        {
            return $this->hasOne(Commission::class);
        }


        /**
         * @param $eventName
         */
        public function fireEvent($eventName)
        {
            $this->fireModelEvent($eventName);
        }


        /**
         * Status Service
         *
         * @return NonPrintStatusService|PrintStatusService
         */
        public function statusService()
        {
            if ($this->type === 'print') {
                return new PrintStatusService($this);
            }
            return new NonPrintStatusService($this);
        }


        /**
         *
         */
        private function notifyAdministratorsViaEmail()
        {
            foreach (User::whereOrderNotify(1)->get() as $user) {
                Mail::send('web.emails.new-order', ['order' => $this], function ($message) use ($user) {
                    $message->to($user->email)->subject('Получен новый заказ.');
                });
            }
        }
    }
