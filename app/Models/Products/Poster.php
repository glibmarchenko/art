<?php

namespace App\Models\Products;

class Poster extends Product
{
    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery()->whereType(1);
    }
}
