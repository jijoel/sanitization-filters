<?php namespace Jijoel\Sanitizer\Laravel;

use Illuminate\Support\ServiceProvider;
use Sanitizer;

class SanitizerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        Sanitizer::extend('address', \Jijoel\Sanitizer\Filters\Address::class);
        Sanitizer::extend('country', \Jijoel\Sanitizer\Filters\Country::class);
        Sanitizer::extend('date', \Jijoel\Sanitizer\Filters\Date::class);
        Sanitizer::extend('limit', \Jijoel\Sanitizer\Filters\Limit::class);
        Sanitizer::extend('lower', \Jijoel\Sanitizer\Filters\LowerCase::class);
        Sanitizer::extend('money', \Jijoel\Sanitizer\Filters\Name::class);
        Sanitizer::extend('name', \Jijoel\Sanitizer\Filters\Name::class);
        Sanitizer::extend('number', \Jijoel\Sanitizer\Filters\Number::class);
        Sanitizer::extend('phone', \Jijoel\Sanitizer\Filters\Phone::class);
        Sanitizer::extend('proper', \Jijoel\Sanitizer\Filters\TitleCase::class);
        Sanitizer::extend('state', \Jijoel\Sanitizer\Filters\State::class);
        Sanitizer::extend('strip', \Jijoel\Sanitizer\Filters\Strip::class);
        Sanitizer::extend('title-case', \Jijoel\Sanitizer\Filters\TitleCase::class);
        Sanitizer::extend('upper', \Jijoel\Sanitizer\Filters\UpperCase::class);
        Sanitizer::extend('zip', \Jijoel\Sanitizer\Filters\Zip::class);
    }
}
