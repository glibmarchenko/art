<?php

namespace App\Traits;

trait IsActive
{

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status_id', '>=', 3);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeNotActive($query)
    {
        return $query->where('status_id', '<=', 2);
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return ($this->status_id >= 3);
    }
}
