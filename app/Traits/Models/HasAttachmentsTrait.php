<?php

    namespace App\Traits\Models;

    use App\Models\Attachment;

    trait HasAttachmentsTrait
    {
        /**
         * Relation to attachments
         *
         * @return \Illuminate\Database\Eloquent\Relations\MorphMany
         */
        public function attachments()
        {
            return $this->hasMany(Attachment::class, 'product_id');
        }


        /**
         * Fill multiple tags
         *
         * @param array $tags
         */
        public function fillAttachments($attachments)
        {
            if ($attachments) {
                foreach ($attachments as $attachment) {
                    $attachment = Attachment::whereName($attachment)->first();
                    if ($attachment) {
                        $attachment->product_id = $this->id;
                        $attachment->save();
                    }
                }
            }
        }
    }