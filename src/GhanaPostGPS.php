<?php
/**
 * Created by PhpStorm.
 * User: brightantwiboasiako
 * Date: 2/15/20
 * Time: 9:34 PM
 */

namespace GhanaPostGPS;


use GhanaPostGPS\Encryption\AESEncryptor;
use GhanaPostGPS\Support\HttpClient;
use GhanaPostGPS\Encryption\RSAEncryptor;

/**
 * Class GhanaPostGPS
 * @package GhanaPostGPS
 */
class GhanaPostGPS
{

    /**
     *
     */
    const GHANAPOST_GPS_RSA_ENDPOINT = 'https://api.ghanapostgps.com/getapidata.aspx';

    /**
     * @var string
     */
    private $asaaseUserId;
    /**
     * @var string
     */
    private $deviceId;
    /**
     * @var string
     */
    private $aesKey;
    /**
     * @var AESEncryptor
     */
    private $aes;
    /**
     * @var RSAEncryptor
     */
    private $rsa;
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * GhanaPostGPS constructor.
     * @param string $asaaseUserId
     * @param string $deviceId
     * @param string $aesKey
     * @param AESEncryptor|null $aes
     * @param RSAEncryptor|null $rsa
     */
    public function __construct(
        $asaaseUserId,
        $deviceId,
        $aesKey,
        $aes = null,
        $rsa = null
    )
    {
        $this->asaaseUserId = $asaaseUserId;
        $this->deviceId = $deviceId;
        $this->aesKey = $aesKey;

        $this->aes = new AESEncryptor($aesKey);

        $this->setupHttpClient();
    }

    /**
     * @param $gpsName
     * @return mixed
     */
    public function getLocation($gpsName){
        return $this->makeDataRequest([
            'Action' => 'GetLocation',
            'GPSName' => $gpsName
        ]);
    }

    /**
     * @param $location
     * @return mixed
     */
    public function getGps($location){
        return $this->makeDataRequest([
            'Action' => 'GetGPSName',
            'Lati' => $location['lat'],
            'Longi' => $location['lng']
        ]);
    }

    /**
     * @param $deviceId
     * @param $aesKey
     * @return $this
     */
    public function withDevice($deviceId, $aesKey){
        $this->deviceId = $deviceId;
        $this->aes->setAesKey($aesKey);
        return $this;
    }

    /**
     * @param $payload
     * @return mixed
     */
    private function makeDataRequest($payload){
        $encryptedPayload = $this->aes->encrypt(
            http_build_query($payload)
        );

        $response = $this->httpClient->post('', [
            'DataRequest' => $encryptedPayload
        ], ['DeviceID' => $this->deviceId]);

        return json_decode($this->aes->decrypt($response), true)['Table'][0];
    }

    /**
     *
     */
    private function setupHttpClient(){
        $payload = "Web||$this->deviceId||$this->aesKey";

        if(is_null($this->rsa))
            $this->rsa = new RSAEncryptor($this->getRSAPublicKey());

        $response = HttpClient::postOnce(static::GHANAPOST_GPS_RSA_ENDPOINT, [
            'ApiData' => $this->rsa->encrypt($payload)
        ], [ 'AsaaseUser' => $this->asaaseUserId ]);

        $decrypted = $this->aes->decrypt($response);
        $dataUrl = explode('||', $decrypted)[1];

        $this->httpClient = new HttpClient($this->asaaseUserId, $dataUrl);
    }

    /**
     * @return mixed
     */
    private function getRSAPublicKey(){
        return HttpClient::getOnce(static::GHANAPOST_GPS_RSA_ENDPOINT . '?publickey=1');
    }

}