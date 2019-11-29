<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Auth;

    class Tag extends Model
    {

        /**
         * fillable Attributes Array
         *
         * @var array
         */
        protected $fillable = [
            'name',
        ];

        /**
         * Get all of the owning taggable models.
         */
        public function taggable()
        {
            return $this->morphTo();
        }
    
        /**
         * Get Tags listed by ID and Name
         *
         * @param string|null $taggable_type
         * @return array
         */
        public static function getListedTagsByName(string $taggable_type = null)
        {
            return ($taggable_type) ?
                self::where('taggable_type', $taggable_type)->groupBy('name')->get() :
                self::groupBy('name')->get();
        }

    }
