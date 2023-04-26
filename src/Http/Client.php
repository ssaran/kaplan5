<?php
/**
 * Created by PhpStorm.
 * User: Sancar Saran
 * Date: 25.06.2021
 * Time: 09:20
 */

namespace K5\Http;

class Client
{

    /**
     * @param $url
     * @param array $headers
     * @param bool $debug
     * @param bool $getRawContent
     * @return mixed
     * @throws \Exception
     */
    public static function Get($url,$headers=[],$debug=false,$getRawContent=false) : mixed
    {
        $response = self::Request(
            $url,
            'GET',
            false,
            false,
            $headers,
            $debug
        );

        if($getRawContent) {
            return $response->Content;
        }

        if(is_object($response->Content)) {
            return $response->Content;
        } else {
            $result = \K5\U::JSON2Php($response->Content);
            return $result;
        }
    }

    /**
     * @param $url
     * @param $headers
     * @param $data
     * @param $debug
     * @return mixed
     * @throws \Exception
     */
    public static function PutJson($url,$headers=[],$data=[],$debug=false) : mixed
    {
        $response = self::Request($url,'PUT',$data,false, $headers,$debug,false);
        if($response->State === 'FAILURE') {
            throw new \Exception($response->StatusCode." \n".$response->Message." \n".$response->Content);
        }

        if(is_object($response->Content)) {
            return $response->Content;
        } else {
            $result = \K5\U::JSON2Php($response->Content);
            return $result;
        }
    }

    /**
     * @param $url
     * @param $headers
     * @param $data
     * @param $debug
     * @return mixed
     */
    public static function PostJson($url,$headers=[],$data=[],$debug=false) : mixed
    {
        $response = self::Request($url,'POST',$data,false, $headers,$debug,false);
        if(is_object($response->Content)) {
            return $response->Content;
        } else {
            return \K5\U::JSON2Php($response->Content);
        }
    }

    /**
     * @param $url
     * @param $headers
     * @param $data
     * @param $debug
     * @return mixed
     * @throws \Exception
     */
    public static function Delete($url,$headers=[],$data=[],$debug=false) : mixed
    {
        $response = self::Request($url,'PUT',$data,false, $headers,$debug,false);
        if($response->State === 'FAILURE') {
            throw new \Exception($response->StatusCode." \n".$response->Message." \n".$response->Content);
        }

        if(is_object($response->Content)) {
            return $response->Content;
        } else {
            $result = \K5\U::JSON2Php($response->Content);
            return $result;
        }
    }

    /**
     * @param $url
     * @param $method
     * @param $json
     * @param $form_params
     * @param $headers
     * @param $debug
     * @param $auth
     * @param $multipart
     * @param $body
     * @return \K5\Entity\Http\Response
     */
    public static function Request(
        $url,$method='POST',$json=false,$form_params=false, $headers=false,$debug=false,$auth=false,
        $multipart=false,$body=false) : \K5\Entity\Http\Response
    {
        try {
            $cookieJar = new \GuzzleHttp\Cookie\CookieJar(true);
            $client = new \GuzzleHttp\Client(['cookies'=>$cookieJar]);

            $allParams = [];
            $allParams['redirect'] = true;

            if($headers) {
                $allParams['headers'] = $headers;
            }

            if($auth) {
                $allParams['auth'] = $auth;
            }

            if($form_params) {
                $allParams['form_params'] = $form_params;
            }

            if($json) {
                $allParams['json'] = $json;
            }

            if($multipart) {
                $allParams['multipart'] = $multipart;
            }

            if($debug) {
                $allParams['debug'] = true;
            }

            if($body) {
                $allParams['body'] = $body;
            }

            if(!$multipart) {
                $response = $client->request($method, $url, $allParams);
            } else {
                $response = $client->post($url, $allParams);
            }

            if($debug) {
                syslog(LOG_INFO,"<Guzzle_Debug>");
                syslog(LOG_INFO,$response);
                syslog(LOG_INFO,"</Guzzle_Debug>");
            }

            $_r = new \K5\Entity\Http\Response();
            $_r->State = "SUCCESS";
            $_r->Content = $response->getBody()->getContents();
            $_r->StatusCode = $response->getStatusCode();

            return $_r;
        } catch (\GuzzleHttp\Exception\TooManyRedirectsException $e) {
            $_r = new \K5\Entity\Http\Response();
            $_r->State = "FAILURE";
            $_r->Content = $e->getResponse()->getBody()->getContents();
            $_r->StatusCode = $e->getResponse()->getStatusCode();
            $_r->Message = $e->getMessage();

            return $_r;
        } catch (\GuzzleHttp\Exception\ClientException | \GuzzleHttp\Exception\ServerException $e) {
            // ClientException - A GuzzleHttp\Exception\ClientException is thrown for 400 level errors if the http_errors request option is set to true.
            // ServerException - A GuzzleHttp\Exception\ServerException is thrown for 500 level errors if the http_errors request option is set to true.
            $_r = new \K5\Entity\Http\Response();
            $_r->State = "FAILURE";
            if ($e->hasResponse()) {
                $_r->Content = $e->getResponse()->getBody()->getContents();
                $_r->StatusCode = $e->getResponse()->getStatusCode();
                $_r->Message = $e->getMessage();
            } else {
                $_r->Content = $e->getResponse()->getBody()->getContents();
                $_r->StatusCode = $e->getResponse()->getStatusCode();
                $_r->Message = $e->getMessage();
            }
            return $_r;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $_r = new \K5\Entity\Http\Response();
            $_r->State = "FAILURE";
            $_r->Content = $e->getResponse()->getBody()->getContents();
            $_r->StatusCode = $e->getResponse()->getStatusCode();
            $_r->Message = $e->getMessage();

            return $_r;
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            $_r = new \K5\Entity\Http\Response();
            $_r->State = "FAILURE";
            $_r->StatusCode = $e->getCode();
            $_r->Message = $e->getMessage();

            return $_r;
        } catch (\Exception $e) {
            $_r = new \K5\Entity\Http\Response();
            $_r->State = "FAILURE";
            $_r->StatusCode = $e->getCode();
            $_r->Message = $e->getMessage();
            return $_r;
        }
    }
}