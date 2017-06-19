<?php namespace Jijoel\Sanitizer\Filters;

use Illuminate\Support\Str;
use Waavi\Sanitizer\Contracts\Filter;


class Number implements Filter
{
    public function apply($string, $options = [])
    {
        $string = preg_replace('/\((.*?)\)/', '-$1', $string);

        $string = preg_replace('/[^0-9\.\-]/', '', $string);

        if (! $string)
            return 0;

        if (strpos($string, '.') !== false)
            return (Float) $string;

        return (Integer) $string;
    }

}
