<?php

namespace Aracademia\LaravelGeoIP\Console;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GeoipCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geoip:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update GeoIP database ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(strtolower(config('Geoip.account_type')) == 'free')
        {
            $this->error('Only premium GeoIP accounts can be updated automatically');
            exit();
        }
        exec("wget 'https://download.maxmind.com/app/geoip_download?edition_id=GeoIP2-Country&suffix=tar.gz&license_key=".config('Geoip.license_key')."' -O storage/app/GeoIP2-Country.tar.gz");
        try{


            $this->deleteGeoIP2CountryDirectory();

            $phar = new \PharData(storage_path('/app/GeoIP2-Country.tar.gz'));
            $phar->extractTo(storage_path('/app'));
            Storage::delete('GeoIP2-Country.tar.gz');


            $dbfile = $this->getDBPath();


            if(!is_null($dbfile))
            {
                $this->updateGeoIP2CountryDB($dbfile);
            }
            else
            {
                $this->error("Database file is missing");
            }

            $this->deleteGeoIP2CountryDirectory();

            $this->info("GeoIP database was updated");

        }catch(Exception $e)
        {
            $this->error("There was an error downloading the new database file.");
        }
    }

    private function deleteGeoIP2CountryDirectory()
    {
        $folders = $this->getStoragechildDirectories();

        foreach($folders as $folder)
        {

            if(preg_match('/GeoIP2-Country_.+/', $folder))
            {
                Storage::deleteDirectory($folder);
            }
        }
    }

    private function getDBPath()
    {
        $path = $this->getFilesPathInStorageDir();
        foreach($path as $link)
        {
            if(preg_match('/GeoIP2-Country_.+\.mmdb/',$link))
            {
                return $link;
            }
        }
        return null;
    }

    private function getStoragechildDirectories()
    {
        return Storage::directories();
    }

    private function getFilesPathInStorageDir()
    {
        return Storage::allFiles();
    }

    private function updateGeoIP2CountryDB($dbfile)
    {
        if(Storage::has('GeoIP2DB/GeoIP2-Country.mmdb'))
        {
            Storage::delete('GeoIP2DB/GeoIP2-Country.mmdb');
        }
        Storage::copy($dbfile,'GeoIP2DB/GeoIP2-Country.mmdb');
    }
}
