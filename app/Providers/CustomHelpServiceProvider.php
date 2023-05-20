<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class CustomHelpServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    
    protected $customHelpers = [
       'smsactiveAPI'
   ];
   public function register()
   {
        foreach ($this->customHelpers as $helper) {
            require_once(app_path().'/Helpers/'.$helper.'.php');
        }
   }
}
