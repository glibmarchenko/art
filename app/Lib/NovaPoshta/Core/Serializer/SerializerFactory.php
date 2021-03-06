<?php

namespace App\Lib\NovaPoshta\Core\Serializer;

use App\Lib\NovaPoshta\Config;
use App\Lib\NovaPoshta\Core\NovaPoshtaException;

class SerializerFactory
{
    private static $serializer;

    /**
     * @return SerializerInterface|SerializerFactory|SerializerBatchInterface
     * @throws NovaPoshtaException
     */
    public static function getSerializer()
    {
        $format = strtoupper(Config::getFormat());
        $dataSerializer = 'App\Lib\NovaPoshta\Core\Serializer\DataSerializer' . $format;
        if (!class_exists($dataSerializer)) {
            throw new NovaPoshtaException('NovaPoshta\Core\Serializer\SerializerFactory_NO_SERIALIZER');
        }
        if (!self::$serializer) {
            self::$serializer = new $dataSerializer();
        }

        return self::$serializer;
    }
}