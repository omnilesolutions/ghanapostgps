<?php
/**
 * Created by PhpStorm.
 * User: brightantwiboasiako
 * Date: 2/9/20
 * Time: 1:32 AM
 */
namespace Tests\Unit;

use Tests\BaseTest;
use GhanaPostGPS\GhanaPostGPS;

class GhanaPostGPSTest extends BaseTest {


    public function test_it_can_get_location_for_gps(){

        $asaaseUser = 'VGhpcyBJcyBUaGUgQW5kcm9pZCBVc2Vy';
        $deviceId = 'YOUR-DEVICE-ID';
        $gpsName = 'GA-585-7449';
        $aesKey = 'YOUR-AES-KEY';

        $gps = new GhanaPostGPS(
            $asaaseUser,
            $deviceId,
            $aesKey
        );

        $location = $gps->getLocation($gpsName);
        $this->assertIsArray($location);
        $this->assertArrayHasKey('CenterLatitude', $location);
        $this->assertArrayHasKey('CenterLongitude', $location);
        $this->assertArrayHasKey('PostCode', $location);
        $this->assertArrayHasKey('District', $location);
        $this->assertArrayHasKey('Region', $location);
        $this->assertArrayHasKey('Area', $location);
        $this->assertArrayHasKey('Street', $location);
    }

    public function test_it_can_get_gps_for_location(){

        $asaaseUser = 'VGhpcyBJcyBUaGUgQW5kcm9pZCBVc2Vy';
        $deviceId = 'YOUR-DEVICE-ID';
        $gpsName = 'GA-585-7449';
        $aesKey = 'YOUR-AES-KEY';

        $gps = new GhanaPostGPS(
            $asaaseUser,
            $deviceId,
            $aesKey
        );

        $location = $gps->getLocation($gpsName);

        $gps = $gps->getGps([
            'lat' => $location['CenterLatitude'],
            'lng' => $location['CenterLongitude']
        ]);
        $this->assertIsArray($gps);
        $this->assertArrayHasKey('GPSName', $gps);
        $this->assertArrayHasKey('Region', $gps);
        $this->assertArrayHasKey('District', $gps);
        $this->assertArrayHasKey('PostCode', $gps);
        $this->assertArrayHasKey('Area', $gps);
        $this->assertArrayHasKey('Street', $gps);
    }
}