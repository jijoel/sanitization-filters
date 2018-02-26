<?php namespace Jijoel\Sanitizer\Filters;

use Waavi\Sanitizer\Contracts\Filter;


class Alphabetic implements Filter
{
    public function apply($string, $options = [])
    {
        return preg_replace("/[^A-Za-z ]/", '', $string);
    }

}
