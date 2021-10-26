<?php
/**
 * User: rrafia
 * Date: 01/28/16
 */

namespace Aracademia\LaravelGeoIP;

use GeoIp2\Database\Reader;

class Geoip{

    protected $readerClass;
    public $ipAddress;


    public function __construct()
    {
        $this->readerClass = new Reader(strtolower(config('Geoip.account_type')) == 'premium' ? config('Geoip.premium_geoip_db_path_country') : config('Geoip.free_geoip_db_path_country'));
    }

    public function continentCode($ipAddress = null)
    {
        $ip = $this->ip($ipAddress);
        return $this->readerClass->country($ip)->continent->code;
    }

    public function countryIsoCode($ipAddress = null)
    {
        $ip = $this->ip($ipAddress);
        return $this->readerClass->country($ip)->country->isoCode;
    }

    public function countryName($ipAddress = null)
    {
        $ip = $this->ip($ipAddress);
        return $this->readerClass->country($ip)->country->name;
    }

    private function ip($ipAddress)
    {
        if(!is_null($ipAddress))
        {
            return $ipAddress;
        }
        if(!is_null($this->ipAddress))
        {
            return $this->ipAddress;
        }
        return $_SERVER['SERVER_ADDR'];
    }


}