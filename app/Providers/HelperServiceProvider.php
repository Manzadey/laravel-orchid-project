<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() : void
    {
        foreach (glob(app_path('/Helpers/*.php')) as $filename){
            require_once($filename);
        }
    }
}
