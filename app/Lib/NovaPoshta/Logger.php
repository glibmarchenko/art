<?php

    namespace App\Lib\Novaposhta;

    use App\Lib\NovaPoshta\Core\Logger\InterfaceLogger;
    use App\Lib\NovaPoshta\Models\DataContainer;
    use App\Lib\NovaPoshta\Models\DataContainerResponse;

    /**
     * Class Logger
     *
     * @package NovaPoshta
     */
    class Logger implements InterfaceLogger
    {
        public static function setOriginalData($toData, $fromData)
        {
        }

        public static function setData(DataContainer $toData, DataContainerResponse $fromData)
        {
        }
    }