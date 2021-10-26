<?php
/**
 * User: rrafia
 * Date: 01/28/16
 */

namespace Aracademia\LaravelGeoIP;

use Aracademia\LaravelGeoIP\Console\GeoipCommand;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;


class GeoipServiceProvider extends ServiceProvider {


    public function boot()
    {

        $this->publishes([
            __DIR__.'/Config/GeoipConfig.php' => config_path('Geoip.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton('Geoip',function($app)
        {
            return new Geoip();
        });
        $this->app->singleton('GeoipCommand',function($app)
        {
            return new GeoipCommand();
        });

        $this->commands('GeoipCommand');

        //register our facades
        $this->app->booting(function()
        {
            AliasLoader::getInstance()->alias('Geoip','Aracademia\LaravelGeoIP\Facades\Geoip');
        });


    }

} 