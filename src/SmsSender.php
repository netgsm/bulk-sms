<?php

namespace Netgsm\Service;

use Exception;

class SmsSender
{
    /**
     * Netgsm API'ye JSON POST isteği gönderme.
     *
     * @param string $url Netgsm API URL'si
     * @param array $data Gönderilecek veri
     * @return mixed API'den dönen cevap
     */
    public static function post( $data)
    {
       
        if (!is_object($data)) {
            throw new \Exception('The provided data is not an object.', 406);  
        }

        $response = Helper::curl($data);

        return $response;
    }
}
