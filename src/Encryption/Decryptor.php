<?php
/**
 * Created by PhpStorm.
 * User: brightantwiboasiako
 * Date: 2/18/20
 * Time: 3:05 PM
 */

namespace GhanaPostGPS\Encryption;


interface Decryptor
{

    /**
     * @param $encrypted
     * @return mixed
     */
    public function decrypt($encrypted);

}