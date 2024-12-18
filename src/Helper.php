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
    public static function curl(array $data)
    {
       
        $username = env('NETGSM_USERNAME');
        $password = env('NETGSM_PASSWORD');
        $url=env('NETGSM_URL');
        if (!$username || !$password || !$url) {
            return response()->json([
                'description' => 'Missing configuration information! Please check the .env file.'
            ], 406); 
        }
        $ch = curl_init();

        $jsonData = json_encode($data);

        $authHeader = 'Authorization: Basic ' . base64_encode("$username:$password");

        curl_setopt($ch, CURLOPT_URL, $url);                 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        
        curl_setopt($ch, CURLOPT_POST, true);                  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);       
        curl_setopt($ch, CURLOPT_HTTPHEADER, [                 
            'Content-Type: application/json',                  
            'Content-Length: ' . strlen($jsonData),           
            $authHeader,                                       
        ]);

        $response = curl_exec($ch);

       
        if(curl_errno($ch)) {
            return 'cURL Error: ' . curl_error($ch);
        }

       
        curl_close($ch);

        return json_decode($response, true);
    }
}
