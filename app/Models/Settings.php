<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{

    public static function getSmallPrintDeliveryPrice()
    {
        return self::whereName('delivery_per_print_unit_price_small')->first()->value;
    }

    public static function getBigPrintDeliveryPrice()
    {
        return self::whereName('delivery_per_print_unit_price_big')->first()->value;
    }

    public static function getSmallPrintPackagePrice()
    {
        return self::whereName('package_per_print_unit_price_small')->first()->value;
    }

    public static function getBigPrintPackagePrice()
    {
        return self::whereName('package_per_print_unit_price_big')->first()->value;
    }

    public static function getAuthorCommission()
    {
        return self::whereName('commission')->first()->value;
    }
}
