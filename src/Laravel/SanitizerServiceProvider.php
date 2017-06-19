<?php namespace Jijoel\Sanitizer\Laravel;

use Waavi\Sanitizer\Laravel\SanitizerServiceProvider as WaaviProvider;
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
        try {
            $sanitizer = app('sanitizer');
        } catch (\Exception $e) {
            throw new \Exception('waavi/sanitizer service provider is not loaded. Make sure it is required BEFORE jijoel/sanitization-filters in your composer.json file');
        }

        foreach($this->sanitizers as $key => $value)
            $sanitizer->extend($key, $value);
    }

}
