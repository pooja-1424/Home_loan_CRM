<?php 

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\DataStorageService;

class MyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(DataStorageService::class, function () {
            return new DataStorageService(); // Adjust this instantiation as needed
        });
    }
}