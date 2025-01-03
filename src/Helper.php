<?php

namespace Netgsm\Service;

use Service;

class Helper
{
    /**
     * Netgsm API'ye JSON POST isteği gönderme.
     *
     * @param string $url Netgsm API URL'si
     * @param array $data Gönderilecek veri
     * @return mixed API'den dönen cevap
     */
    public static function curl(object $data,string $url,string $service=null)
    {
        $username = env('NETGSM_USERNAME');
        $password = env('NETGSM_PASSWORD');
        
        if (!$username || !$password || !$url) {
            throw new \Exception('Missing configuration information! Please check the .env file.', 406);
        }
        $data= json_encode($data);
       
        $ch = curl_init();

        $headers = [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data),
        ];
        
       
        if ($service == Service::SmsSend && !empty($username) && !empty($password)) {
            $authHeader = 'Authorization: Basic ' . base64_encode("$username:$password");
            $headers[] = $authHeader; // Header listesine ekle
        }
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);           
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            throw new \Exception('cURL Error: ' . curl_error($ch));
        }
        
        // cURL oturumunu kapat
        curl_close($ch);

        
        $decodedResponse = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Failed to decode JSON response: ' . json_last_error_msg(), 500); // 500 Internal Server Error
        }

        return $decodedResponse;
    }
}
