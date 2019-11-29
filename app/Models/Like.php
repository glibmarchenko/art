<?php

    namespace App\Models;

    use App\Models\Products\Poster;
    use App\Models\Products\Product;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Auth;

    class Like extends Model
    {
        /**
         * fillable Attributes Array
         *
         * @var array
         */
        protected $fillable = [
            'user_id',
            'product_id',
        ];

        public function product()
        {
            return $this->belongsTo(Product::class);
        }
        
        public function post()
        {
            return $this->belongsTo(Product::class);
        }
        
        /**
         * Find Liked
         * 
         * @param int $user_id
         * @param string $product_type
         * @param int $product_id
         * @return mixed
         */
        public static function findLiked(int $user_id, string $product_type, int $product_id)
        {
            return self::where('user_id', $user_id)->where('product_id', $product_id)->first();
        }
        
        /**
         * Fill and Store Like
         * 
         * @param int $user_id
         * @param string $product_type
         * @param int $product_id
         * @return mixed
         */
        public static function fillAndStore(int $user_id, string $product_type, int $product_id)
        {
            $like = new Like();
            $like->user_id = $user_id;
            $like->product_id = $product_id;
            $like->save();
            return $like;
        }
    }
