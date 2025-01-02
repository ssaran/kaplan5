<?php
/**
 * Created by PhpStorm.
 * Date: 21.05.2021
 * Time: 11:33
 */

namespace K5\Helper\Websocket;


class Util
{
    /**
     * @param $token
     * @param $from
     * @param $to
     * @param $type
     * @param $destinationFd
     * @param $sourceFd
     * @param $bodyType
     * @param $isBounce
     * @param $isTest
     * @param $contentType
     * @param $channel
     * @param $bind
     * @param $cbcd
     * @return \K5\Entity\Websocket\Event
     */
    public static function GetEventBase($token,$from="",$to="",$type="",$destinationFd="",$sourceFd="",
                                        $bodyType="",$isBounce=0,$isTest=0,$contentType="",$channel="xws",$bind="",$cbcd=""
    ) : \K5\Entity\Websocket\Event
    {
        $event = new \K5\Entity\Websocket\Event();
        $event->type = $type;
        $event->content = new \K5\Entity\Websocket\EventBody();
        $event->content->from = $from;
        $event->content->to = $to;
        $event->content->dfd = $destinationFd;
        $event->content->token = $token;
        $event->content->type = $bodyType;
        $event->content->bounce = $isBounce;
        $event->content->is_test = $isTest;
        $event->content->content = new \K5\Entity\Websocket\EventBodyContent();
        $event->content->content->sfd = $sourceFd;
        $event->content->content->type = $contentType;
        $event->content->content->content = new \stdClass();
        $event->content->content->content->channel = $channel;
        $event->content->content->content->bind = $bind;
        $event->content->content->content->cbcd = $cbcd;

        return $event;
    }

    public static function GetRegisterMessage($type,$token) : string
    {
        $msg = [
            "type"=>$type,
            "content"=> [
                "token"=>$token
            ]
        ];
        return json_encode($msg);
    }

    public static function GetBot($clients)
    {
        try {
            if (!isset($clients->type) || $clients->type !== 'ws_server_response') {
                $msg = "Hatalı Cevap\n";
                $msg .= print_r($clients, true) . "\n";
                throw new \Exception($msg);
            }

            if (!isset($clients->content) || !isset($clients->content->type) || $clients->content->type !== 'ws_server_client_list') {
                $msg = "Hatalı Content\n";
                $msg .= print_r($clients->content, true) . "\n";
                throw new \Exception($msg);
            }

            $c1 = $clients->content;

            if (!isset($c1->content->content) || !isset($c1->content->content->clients)) {
                $msg = "List Content bulunamadı\n";
                $msg .= print_r($c1, true) . "\n";
                throw new \Exception($msg);
            }

            $_clients = $c1->content->content->clients;

            $bot = false;
            foreach ($_clients as $client) {
                if ($client->client_type == "xws") {
                    $bot = $client;
                }
            }

            if (!$bot) {
                $msg = "Register olmuş bot yok\n" . print_r($_clients, true) . "\n";
                throw new \Exception($msg);
            }
            return $bot;
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
            return false;
        }
    }
}
