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
    public static function post(array $data)
    {
        try {

            
            json_encode($data);

            // POST isteği gönder
            $response = Helper::curl($data);

            // Yanıtı ekrana yazdır
            return $response;
        } catch (Exception $e) {
        }
    }
}
