# GhanaPostGPS
PHP package for GhanaPostGPS
 
This package connects with the GhanaPostGPS to look for digital addresses
in Ghana.

## Installation
You can install the package via composer using

```php
composer require brightantwiboasiako/ghanapostgps
```

## What you will need
Before connecting to GhanaPostGPS, you'll need the following:
1. AsaaseUser ID
    This is given to you during on-boarding with the GhanaPostGPS team 
    and can be found other your profile from the
    [GPSAdmin Portal](https://gpsadmin.ghanapostgps.com)
2. DeviceID
    You'll need to create a device on the [GPSAdmin Portal](https://gpsadmin.ghanapostgps.com)
    and use the ID. Note that you can create multiple devices on
    the portal.
3. AES Key
   The GhanaPostGPS server uses AES encryption to communicate with 
   with clients. You can access your AES key for each device you create
   in the portal.
   
## Data APIs
Use the ````GhanaPostGPS\GhanaPostGPS```` object to get data.
```php

$asaaseUser = 'YOUR-ASAASE-USER-ID'
$deviceId = 'YOUR-DEVICE-ID'
$aesKey = 'YOUR-AES-KEY-FOR-DEVICE'

$gps = new GhanaPostGPS\GhanaPostGPS($asaaseUser, $deviceId, $aesKey);
```
### Get Location for a GPS Name (Ghana Code)
```php

// Ghana Code
$gpsName = 'GA-585-7449';
 
// Location contains center latitude and longitude as well as
// a box around the center. You also get postcode, region,
// area, street, etc.
$location = $gps->getLocation($gpsName);

```
### Get GPS Name (Ghana Code) for a location
```php

$location = [
    'lat' => 5.7525573723,
    'lng' => -2.873287368
];

// The GPS info contains postcode, region, area and street info
// for the provided location.
$gpsInfo = $gps->getGps($location);

```

## Tests
Tests are setup in a way that actually connect with GhanaPostGPS to 
make sure everything works.
 
To run tests, supply your credentials in ```tests/Unit/GhanaPostGPSTest```
and run ```vendor/bin/phpunit```

### Prerequisites
* PHP 5.6 or above
* [curl](https://secure.php.net/manual/en/book.curl.php) and
[openssl](https://secure.php.net/manual/en/book.openssl.php)
extensions.

## Contributing
Contributions are welcome! Please do a PR with any bug-fixes or email me at [brightantwiboasiako@aol.com](mailto:brightantwiboasiako@aol.com) 
for a long term commitment.

## License
This open-source project is licensed under the [MIT LICENSE](https://opensource.org/licenses/MIT)
