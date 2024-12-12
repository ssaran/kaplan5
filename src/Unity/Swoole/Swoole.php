<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 3.01.2018
 * Time: 11:24
 */

namespace K5;


if(!defined("R_DIR")) {
    define("R_DIR", __DIR__ . "/../../front.xrp/");
}

class Swoole
{
    public static $wsStatus = null;
    public static function WebSocketPush($packet,$host="127.0.0.1", $port="9502",$ssl=false) {
        go(function() use($packet,$host,$port,$ssl){
            $cli = new \Swoole\Coroutine\Http\Client($host, $port,$ssl);
            $cli->setHeaders([
                'Host' => "localhost",
                "hede" => 'hodo',
                "User-Agent" => 'Ncn JobQue Client',
                'Accept' => 'text/html,application/xhtml+xml,application/xml',
                'Accept-Encoding' => 'gzip',
            ]);
            $cli->set([ 'timeout' => 1]);
            $cli->setMethod('POST');
            $ret = $cli->upgrade('/');
            if($ret) {
                $cli->push($packet);
            } else {
                \K5\U::ldbg("Cannot Upgrade ".socket_strerror($cli->errCode));
            }
            return false;
        });
    }
}
