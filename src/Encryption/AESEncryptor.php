<?php
/**
 * Created by PhpStorm.
 * User: brightantwiboasiako
 * Date: 2/15/20
 * Time: 9:45 PM
 */

namespace GhanaPostGPS\Encryption;


use phpseclib\Crypt\AES;
use phpseclib\Crypt\Base;
use phpseclib\Crypt\Random;

/**
 * Class AESEncryptor
 * @package GhanaPostGPS\Encryption
 */
class AESEncryptor implements Encryptor, Decryptor
{

    const AES_RANDOM_IV_SIZE = 16;
    const AES_KEY_LENGTH = 128;
    const AES_BLOCK_LENGTH = 128;

    /**
     * @var AES
     */
    private $aes;

    /**
     * AESEncryptor constructor.
     * @param $aesKey
     * @param $mode
     */
    public function __construct($aesKey, $mode = Base::MODE_CBC)
    {
        $this->setupAES($aesKey, $mode);
    }


    /**
     * @param $key
     * @return $this
     */
    public function setAesKey($key){
        $this->aes->setKey($key);
        return $this;
    }

    /**
     * @param $payload
     * @return string
     */
    public function encrypt($payload)
    {
        $iv = Random::string(static::AES_RANDOM_IV_SIZE);
        $this->aes->setIV($iv);
        return base64_encode(
            $iv.$this->aes->encrypt($payload)
        );
    }

    /**
     * @param $encrypted
     * @return string
     */
    public function decrypt($encrypted)
    {
        $bytes = base64_decode($encrypted);
        // We extract the IV which is the first 16 characters
        // of the payload
        $ivBytes = substr($bytes, 0, static::AES_RANDOM_IV_SIZE);
        $mainBytes = substr($bytes, static::AES_RANDOM_IV_SIZE);
        $this->aes->setIV($ivBytes);
        return $this->aes->decrypt($mainBytes);
    }

    /**
     * @param $aesKey
     * @param $mode
     */
    private function setupAES($aesKey, $mode){
        $this->aes = new AES($mode);
        $this->aes->setKeyLength(static::AES_KEY_LENGTH);
        $this->aes->setBlockLength(static::AES_BLOCK_LENGTH);
        $this->aes->setKey($aesKey);
    }

}