<?php

declare(strict_types=1);

namespace app\helpers;

final class Internet {

    public static function postURL(string $page, array $args, &$err = null) {
        try{
            return self::simpleCurl($page, [
                CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => $args
            ]);
        }catch(\Exception $ex) {
            $err = $ex->getMessage();
			return null;
        }
    }

    private static function simpleCurl(string $page, array $options = []) : ?array {
        /** @var \CurlHandle $ch */
        $ch = curl_init($page);
  
        if($ch === false) {
            throw new \RuntimeException("Unable to create new cURL session");
        }
        curl_setopt_array($ch, $options + [
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_RETURNTRANSFER => 1,
        ]);
        try {
            $raw = curl_exec($ch);

            if($raw === false){
                throw new \RuntimeException(curl_error($ch));
            }
            $data = json_decode($raw, true);

            if(json_last_error() == JSON_ERROR_NONE) {
                return $data;
            }
        }finally{
            curl_close($ch);
        }
        return null;
    }
}
?>