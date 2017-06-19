<?php namespace Jijoel\Sanitizer\Filters;

use Waavi\Sanitizer\Contracts\Filter;
use Illuminate\Support\Str;


class Zip implements Filter
{
    public function apply($text, $options = [])
    {
        if ($options === [])
            $options = ['US'];

        if (Str::upper($options[0]) !== 'US')
            return $text;

        $zip = preg_replace('/[^0-9]/','',$text);

        if (Str::length($zip) == 9)
            return Str::substr($zip, 0, 5)
                . '-'
                . Str::substr($zip, 5);

        return $text;
    }

}
