<?php

    namespace App\Observers;

    use App\Models\Gallery;

    class GalleryObserver
    {

        public function created(Gallery $gallery)
        {
            $author = $this->defineNotificationUser($gallery);
            $author->notifications()->create(['text' => 'Галерея ' . $gallery->name . ' успешно создана и проходит проверку модератором']);
        }

        public function updated(Gallery $gallery)
        {
            $author = $this->defineNotificationUser($gallery);

            if ($gallery->viewed == 1) {
                $author->notifications()->create(['text' => 'Галерея ' . $gallery->name . ' проверена модератором']);
            } else {
                $author->notifications()->create(['text' => 'Галерея ' . $gallery->name . ' была изменена и повторно проходит проверку модератором']);
            }
            if (! $gallery->is_active) {
                $author->notifications()->create(['text' => 'Галерея ' . $gallery->name . ' отклонена модератором, ознакомься с правилами']);
            }

        }

        public function deleting(Gallery $gallery)
        {
            $author = $this->defineNotificationUser($gallery);
            $author->notifications()->create(['text' => 'Галерея ' . $gallery->name . ' удалена с платформы']);
        }

        private function defineNotificationUser($gallery)
        {
            $owner = $gallery->owner;
            return $owner;
        }

    }