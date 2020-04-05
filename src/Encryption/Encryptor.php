<?php
/**
 * Created by PhpStorm.
 * User: brightantwiboasiako
 * Date: 2/15/20
 * Time: 9:44 PM
 */

namespace GhanaPostGPS\Encryption;


/**
 * Interface Encryptor
 * @package GhanaPostGPS\Encryption
 */
interface Encryptor
{

    /**
     * @param $payload
     * @return mixed
     */
    public function encrypt($payload);

}