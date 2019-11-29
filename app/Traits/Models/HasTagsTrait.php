<?php

    namespace App\Traits\Models;

    use App\Models\Tag;

    trait HasTagsTrait
    {
        /**
         * Relation to tags
         *
         * @return \Illuminate\Database\Eloquent\Relations\MorphMany
         */
        public function tags()
        {
            return $this->hasMany(Tag::class,'taggable_id');
        }

        /**
         * Fill multiple tags
         *
         * @param array $tags
         */
        public function fillTags($tags)
        {
            if ($tags) {
                $this->tags()->delete();
                foreach ($tags as $tag) {
                    $this->tags()->create(
                        ['name' => $tag['name']]
                    );
                }
            }
        }

    }