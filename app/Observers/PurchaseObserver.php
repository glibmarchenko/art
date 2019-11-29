<?php

    namespace App\Observers;

    use App\Models\Notification;
    use App\Models\Purchase;

    class PurchaseObserver
    {
        protected $product;
        protected $user;
        protected $purchase;

        public function _construct(Purchase $purchase)
        {
            $this->product = $purchase->product;
            $this->user = $purchase->user;
            $this->purchase = $purchase;
        }

        public function created(Purchase $purchase)
        {   
//            dd($purchase);
//            $this->user->print_delivery_amount = 23;
//            $this->user->save();
        }

        public function updated()
        {
     

        }

        public function deleting()
        {

        }
        
    }