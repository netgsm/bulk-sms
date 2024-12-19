<?php

namespace Netgsm\Service;

use Exception;
use Netgsm\Enums\ServiceName;
use Netgsm\Helper;


class SmsSender
{
    /**
     * Netgsm API'ye JSON POST isteği gönderme.
     *
     
     * @param array $data Gönderilecek veri
     * @return mixed API'den dönen cevap
     */
    public static function post( $data)
    {
       $url="https://api.netgsm.com.tr/sms/send/rest/v1";
        if (!is_object($data)) {
            throw new \Exception('The provided data is not an object.', 406);  
        }
        $response = Helper::curl($data,$url,ServiceName::SmsSend->value);

        return $response;
    }
}
