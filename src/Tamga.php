<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 20.08.2019
 * Time: 09:48
 */

namespace K5;


class Tamga
{

    public static $TokenConfig;
    public static $uKey;

    private static $token;
    private static $decoded;

    private static string $TimeZone = 'Europe/Istanbul';

    /**
     * @param Entity\Auth\Tamga $tamga
     * @return array
     */
    public static  function BuildTokenData(\K5\Entity\Auth\Tamga $tamga) : array
    {
        // issue at time and expires (token)
        $issuedAt = time();
        // jwt valid for 7 days (60 seconds * 60 minutes * 24 hours * 60 days)
        $expirationTime = $issuedAt + (60 * 60 * 24 * 7);

        return array(
            'iss' => self::$TokenConfig['iss'],
            'aud' => self::$TokenConfig['aud'],
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'tamga' => $tamga
        );
    }
    /**
     * @param $jwtHandler
     * @param $secret
     * @param $data
     * @return mixed
     */
    public static function Encode($jwtHandler,$secret,$data)
    {
        return $jwtHandler->encode($data, $secret);
    }

    /**
     * @param $jwtHandler
     * @param $secret
     * @param $token
     * @return mixed
     */
    public static function Decode($jwtHandler,$secret,$token)
    {
        return  $jwtHandler->decode($token, $secret, array('HS256'));
    }

    /**
     * @return mixed
     */
    public static function Get()
    {
        return self::$token;
    }

    /**
     * @param $token
     * @return mixed
     */
    public static function Set($token)
    {
        return self::$token = $token;
    }

    /**
     * @param $jwtHandler
     * @param $secret
     * @param $redisToken
     * @param $uKey
     * @return bool
     */
    public static function IsTamgaMatch($jwtHandler,$secret,$tamga) : bool
    {
        try {
            if(!$tamga) {
                \K5\U::lerr("Tamga not found");
                return false;
            }
            self::$decoded = self::Decode($jwtHandler,$secret,$tamga);
            if(!self::$decoded) {
                \K5\U::lerr("Cannot decode token");
                return false;
            }
            if(!isset(self::$decoded->tamga)) {
                \K5\U::lerr("jwt is not a tamga");
            }
            return true;
        } catch (\Exception $e) {
            \K5\U::lerr($e->getMessage());
            return false;
        }
    }

    /**
     * @return Entity\Auth\Tamga|null
     */
    public static function GetTamga() : ?\K5\Entity\Auth\Tamga
    {
        if(!isset(self::$decoded->tamga)) {
            \K5\U::lerr("jwt is not a tamga");
            \K5\U::lerr(self::$decoded);
            return null;
        }
        return \K5\U::Record2Entity(self::$decoded->tamga,new \K5\Entity\Auth\Tamga());
    }
}