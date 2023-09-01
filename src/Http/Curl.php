<?php

namespace K5\Http;

class Curl
{
    /**
     * @param array $req
     * @return bool|string
     * @throws \Exception
     */
    public static function Exec(array $req)
    {
        try {
            $cHeaders = [
                "User-Agent: Chrome/49.0.2587.3",
            ];
            $ch = curl_init();

            if($req['method'] == 'post') {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $req['fields']);
            }

            foreach($req['headers'] as $hKey => $hVal) {
                $cHeaders[$hKey] = $hVal;
            }

            curl_setopt($ch, CURLOPT_URL, $req['url']);
            //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $req->Method);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


            curl_setopt($ch, CURLOPT_HTTPHEADER, $cHeaders);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);

            $raw = curl_exec($ch);
            $headerSent = curl_getinfo($ch, CURLINFO_HEADER_OUT );
            curl_close($ch);

            return $raw;
        } catch (\Exception $e) {
            \K5\U::lerr($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param string $url
     * @param array $fields
     * @param array $headers
     * @param string $method
     * @return mixed
     * @throws \Exception
     */
    public static function Fetch(string $url,array $fields=[],array $headers=[],string $method='post')
    {
        $raw = self::Exec([
            'url'=> $url,
            'method'=> $method,
            'headers'=> $headers,
            'fields'=>$fields
        ]);

        if(empty($raw)) {
            $_eMsg = "Empty Curl Response \n";
            $_eMsg.= $url;
            $_eMsg.= print_r($headers,true)."\n";
            $_eMsg.= print_r($fields,true)."\n";
            $_eMsg.= "/---\n";
            \K5\U::lerr($_eMsg);

            throw new \Exception($_eMsg);
        }

        $resp = json_decode($raw);
        if(!isset($resp->payload) || !isset($resp->state)) {
            $_eMsg = "Bad Response \n";
            $_eMsg.= $url."\n";
            $_eMsg.= "/---\n";
            $_eMsg.= print_r($raw,true)."\n";
            $_eMsg.= "/---\n";
            \K5\U::lerr($_eMsg);

            throw new \Exception($_eMsg);
        }
        return $resp;
    }
}