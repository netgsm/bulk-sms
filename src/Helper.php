<?php

namespace Netgsm\Service;

class Helper
{
    /**
     * Netgsm API'ye JSON POST isteği gönderme.
     *
     * @param string $url Netgsm API URL'si
     * @param array $data Gönderilecek veri
     * @return mixed API'den dönen cevap
     */
    public static function curl($data)
    {
        
        // .env dosyasından API bilgilerini al
        $username = env('NETGSM_USERNAME');
        $password = env('NETGSM_PASSWORD');
        $url = env('NETGSM_URL');

       
        if (!$username || !$password || !$url) {
            throw new \Exception('Missing configuration information! Please check the .env file.', 406);
        }
        $data= json_encode($data);
        // cURL oturumunu başlat
        $ch = curl_init();

        // Basic Authentication Header
        $authHeader = 'Authorization: Basic ' . base64_encode("$username:$password");

        // cURL seçeneklerini ayarla
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);           // JSON veriyi doğrudan gönderiyoruz
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data),
            $authHeader,
        ]);

        
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
