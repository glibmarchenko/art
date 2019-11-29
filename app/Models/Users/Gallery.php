<?php

    namespace App\Models\Users;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    class Gallery extends User
    {
        use Notifiable;

        protected static function boot()
        {
            parent::boot();
        }

        public function newQuery($excludeDeleted = true)
        {
            return parent::newQuery()->whereRole(3);
        }

        public function authors()
        {
            return $this->hasMany(User::class, 'gallery_id');
        }


    }
