<?php
/**
 * Created by PhpStorm.
 * User: brightantwiboasiako
 * Date: 2/18/20
 * Time: 2:57 PM
 */

namespace GhanaPostGPS\Encryption;


use phpseclib\Crypt\RSA;

/**
 * Class RSAEncryptor
 * @package GhanaPostGPS\Encryption
 */
class RSAEncryptor implements Encryptor
{

    /**
     * @var RSA
     */
    private $rsa;

    /**
     * RSAEncryptor constructor.
     * @param $publicKey
     * @param int $mode
     */
    public function __construct($publicKey, $mode = RSA::ENCRYPTION_PKCS1)
    {
        $this->rsa = new RSA();
        $this->rsa->setEncryptionMode($mode);
        $this->rsa->loadKey($publicKey);
    }

    /**
     * @param $payload
     * @return string
     */
    public function encrypt($payload)
    {
        return base64_encode(
            $this->rsa->encrypt($payload)
        );
    }
}