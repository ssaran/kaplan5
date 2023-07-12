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
                "User-Agent : Chrome/49.0.2587.3",
                'Accept-Encoding : gzip',
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
}