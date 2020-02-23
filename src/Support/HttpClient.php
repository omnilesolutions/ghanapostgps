<?php
/**
 * Created by PhpStorm.
 * User: brightantwiboasiako
 * Date: 2/15/20
 * Time: 10:34 PM
 */

namespace GhanaPostGPS\Support;


use GuzzleHttp\Client;

/**
 * Class HttpClient
 * @package GhanaPostGPS\Support
 */
class HttpClient
{

    /**
     * @var Client
     */
    private $engine;

    /**
     * @var string
     */
    private $asaaseUser;

    /**
     * HttpClient constructor.
     * @param string $asaaseUser
     * @param string $dataUri
     */
    public function __construct($asaaseUser, $dataUri)
    {
        $this->engine = new Client([
            'base_uri' => $dataUri
        ]);

        $this->asaaseUser = $asaaseUser;
    }


    /**
     * @param $resourcePath
     * @param $payload
     * @param array $headers
     * @return mixed|null
     */
    public function post($resourcePath, $payload, $headers = []){

        $response = $this->engine->post($resourcePath, [
            'form_params' => $payload,
            'headers' => array_merge($headers , [
                'AsaaseUser' => $this->asaaseUser,
                'Country' => 'GH',
                'CountryName' => 'Ghana'
            ])
        ]);

        if($response->getBody()){
            return (string)$response->getBody();
        }
        return null;
    }

    /**
     * @param $resourcePath
     * @param array $options
     * @return mixed|null
     */
    public function get($resourcePath, $options = []){
        $response = $this->engine->get($resourcePath, $options);
        if($response->getBody()){
            return json_decode($response->getBody(), true);
        }
        return null;
    }

    /**
     * @param $url
     * @param $payload
     * @param $headers
     * @return mixed
     * @throws \Exception
     */
    public static function postOnce($url, $payload, $headers = []){
        $response = (new Client())->post($url, [
            'form_params' => $payload,
            'headers' => $headers
        ]);

        if($response->getBody()){
            return (string)$response->getBody();
        }
        throw new \Exception($response->getReasonPhrase());
    }

    /**
     * @param $url
     * @param $headers
     * @return mixed
     * @throws \Exception
     */
    public static function getOnce($url, $headers = []){
        $response = (new Client())->post($url, [
            'headers' => array_merge($headers, [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Cache-Control' => 'no-cache',
            ])
        ]);

        if($response->getBody()){
            return (string)$response->getBody();
        }
        throw new \Exception($response->getReasonPhrase());
    }

}