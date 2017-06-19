<?php namespace Jijoel\Sanitizer\Laravel;

use Waavi\Sanitizer\Laravel\Factory as Sanitizer;
use Illuminate\Support\ServiceProvider;
use Jijoel\Sanitizer\Filters;


class SanitizerServiceProvider extends ServiceProvider
{
    private $sanitizers = [
        'address' => Filters\Address::class,
        'country' => Filters\Country::class,
        'date' => Filters\Date::class,
        'limit' => Filters\Limit::class,
        'lower' => Filters\LowerCase::class,
        'money' => Filters\Name::class,
        'name' => Filters\Name::class,
        'number' => Filters\Number::class,
        'phone' => Filters\Phone::class,
        'proper' => Filters\TitleCase::class,
        'state' => Filters\State::class,
        'strip' => Filters\Strip::class,
        'title-case' => Filters\TitleCase::class,
        'upper' => Filters\UpperCase::class,
        'zip' => Filters\Zip::class,
    ];

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
        foreach($this->sanitizers as $key => $value)
            app('sanitizer')->extend($key, $value);
    }

}
