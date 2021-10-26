<?php


return [
    'account_type'                          =>  env('ACCOUNT_TYPE','Free'), //Free or Premium
    'license_key'                           =>  env('LICENSE_KEY',''), //Premium Only
    'premium_geoip_db_path_country'         =>  env('COUNTRY_PREMIUM_GEOIP_DB_PATH', storage_path('app/GeoIP2DB/GeoIP2-Country.mmdb')),
    'free_geoip_db_path_country'            =>  env('COUNTRY_FREE_GEOIP_DB_PATH', storage_path('app/GeoIP2DB/GeoLite2-Country.mmdb'))
];