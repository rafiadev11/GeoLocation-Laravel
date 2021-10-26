<?php

namespace Aracademia\LaravelGeoIP\Facades;


use Illuminate\Support\Facades\Facade;

class Geoip extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'Geoip';
    }

} 