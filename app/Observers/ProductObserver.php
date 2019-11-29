<?php

    namespace App\Observers;

    use App\Models\Products\Product;

    class ProductObserver
    {

        public function created(Product $product)
        {
            $author = $this->defineNotificationUser($product);
            $author->notifications()->create(['text' => 'Работа ' . $product->name . ' успешно создана и проходит проверку модератором']);
        }

        public function updated(Product $product)
        {
            $author = $this->defineNotificationUser($product);
            if ($product->viewed == 1) {
                $author->notifications()->create(['text' => 'Работа ' . $product->name . ' проверена модератором']);
            } else {
                $author->notifications()->create(['text' => 'Работа ' . $product->name . ' была изменена и повторно проходит проверку модератором']);
            }
            
            if ($product->favorite == 1) {
                $author->notifications()->create(['text' => 'Работа ' . $product->name . ' добавлена в список избранных']);
            }

            if (! $product->is_active) {
                $author->notifications()->create(['text' => 'Работа ' . $product->name . ' отклонена модератором, ознакомься с правилами размещения работ']);
            }

        }

        public function deleting(Product $product)
        {
            $author = $this->defineNotificationUser($product);
            $author->notifications()->create(['text' => 'Работа ' . $product->name . ' удалена с платформы']);
        }
        
        private function defineNotificationUser($product) {
            $author =  $product->author;
            if($author->gallery_id) {
                $author = $author->gallery->owner;
            }
            return $author;
        }

    }