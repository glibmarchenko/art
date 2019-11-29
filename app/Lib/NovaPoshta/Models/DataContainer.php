<?php

namespace App\Lib\NovaPoshta\Models;

use App\Lib\NovaPoshta\Core\BaseModel;

/**
 * Объект для формирования запроса
 *
 * Class DataContainer
 * @package NovaPoshta\Models
 */
class DataContainer extends BaseModel
{
    public $id;
    public $modelName;
    public $calledMethod;
    public $apiKey;
    public $methodProperties;
    public $language;
}