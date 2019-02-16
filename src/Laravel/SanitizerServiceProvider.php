<?php namespace Jijoel\Sanitizer\Laravel;

use Waavi\Sanitizer\Laravel\Factory as Sanitizer;
use Illuminate\Support\ServiceProvider;
use Jijoel\Sanitizer\Filters;


class SanitizerServiceProvider extends ServiceProvider
{
    private $sanitizers = [
        'alpha' => \Jijoel\Sanitizer\Filters\Alphabetic::class,
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
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        app()->afterResolving(Sanitizer::class, function($s, $app) {
            foreach($this->sanitizers as $key => $value)
                $s->extend($key, $value);
        });
    }

}
