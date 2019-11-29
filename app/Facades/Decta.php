<?php
namespace App\Facades;

use App\Http\Client\DectaApiAccessor;

use Illuminate\Support\Facades\Facade;

/**
 * Class Decta
 * Decta Api Facade
 *
 * @package App\Facades
 */
class Decta extends Facade
{

  protected static function getFacadeAccessor()
  {
    $accessor = new DectaApiAccessor();

    $accessor->boot();

    return $accessor;
  }
}
