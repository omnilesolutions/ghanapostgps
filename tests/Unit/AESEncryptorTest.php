<?php
/**
 * Created by PhpStorm.
 * User: brightantwiboasiako
 * Date: 2/15/20
 * Time: 10:16 PM
 */

namespace Tests\Unit;


use GhanaPostGPS\Encryption\AESEncryptor;
use Tests\BaseTest;

class AESEncryptorTest extends BaseTest
{

    public function test_it_can_encrypt_text(){
        $key = 'some-random-aes-key';
        $aes = new AESEncryptor($key);

        $payload = 'Action=GetLocation&GPSName=GH0019812';
        $encrypted = $aes->encrypt($payload);
        $this->assertNotEmpty($encrypted);
        $this->assertNotEquals($encrypted, $payload);
    }

    public function test_it_can_decrypt_text(){
        $key = 'some-random-aes-key';
        $aes = new AESEncryptor($key);

        $payload = 'Action=GetLocation&GPSName=GH0019812';
        $encrypted = $aes->encrypt($payload);
        $this->assertNotEquals($payload, $encrypted);
        $decrypted = $aes->decrypt($encrypted);
        $this->assertEquals($payload, $decrypted);
    }

}