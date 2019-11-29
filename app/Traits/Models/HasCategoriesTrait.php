<?php

    namespace App\Traits\Models;
    
    use App\Models\CategoryType;

    trait HasCategoriesTrait
    {
        /**
         * Relation to categories
         *
         * @return \Illuminate\Database\Eloquent\Relations\MorphMany
         */
        public function categories()
        {
            return $this->belongsToMany(CategoryType::class,'category_product','product_id');
        }
        

        /**
         * Fill multiple tags
         *
         * @param array $tags
         */
        public function fillCategories($categories)
        {
            $categories = collect($categories)->pluck('id');
            if ($categories) {
                $this->categories()->sync($categories);
            }
        }
        
        /**
         * @return \Illuminate\Support\Collection
         */
        public function categoriesList()
        {
            $categories = $this->categories;
            $categoriesList = [];
            foreach ($categories as $category) {
                $categoriesList[] = ['id' => $category->id, 'name' => $category->name];
            }
            return collect($categoriesList);
        }

    }